<?php

namespace App\Livewire;

use App\Models\Cart as CartModel;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\OrderAddress;
use App\Enums\OrderStatus;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    public $cartItems;
    public $total = 0;
    public $name;
    public $email;
    public $notes;
    
    // Address fields
    public $country;
    public $street;
    public $city;
    public $state;
    public $zip;

    // Search functionality
    public $search = '';
    public $showDropdown = false;
    public $filteredCountries = [];

    protected $countries = [
        'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan',
        'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina',
        'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Central African Republic',
        'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti',
        'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia',
        'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau',
        'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Ivory Coast',
        'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'North Korea', 'South Korea', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia',
        'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia',
        'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia',
        'Montenegro', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger',
        'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal',
        'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino',
        'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia',
        'Solomon Islands', 'Somalia', 'South Africa', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria',
        'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu',
        'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City',
        'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
    ];

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->filteredCountries = [];
            return;
        }

        if ($this->country) {
            return;
        }

        $this->filteredCountries = collect($this->countries)
            ->filter(function($country) {
                return str_contains(strtolower($country), strtolower($this->search));
            })
            ->take(10)
            ->toArray();
    }

    public function selectCountry($country)
    {
        $this->country = $country;
        if (empty($country)) {
            $this->search = '';
            $this->showDropdown = true;
        } else {
            $this->search = $country;
            $this->showDropdown = false;
        }
        $this->filteredCountries = [];
    }

    public function focusSearch()
    {
        if ($this->country) {
            $this->search = $this->country;
        }
        $this->showDropdown = true;
        $this->updatedSearch();
    }

    public function closeDropdown()
    {
        $this->showDropdown = false;
    }

    public function mount()
    {
        if (!auth('customer')->check()) {
            return redirect()->route('customer.login');
        }

        $customer = auth('customer')->user();
        $this->name = $customer->name;
        $this->email = $customer->email;

        $this->cartItems = CartModel::where('user_id', auth('customer')->id())
            ->with('product')
            ->get();

        if ($this->cartItems->isEmpty()) {
            return redirect()->route('cart');
        }

        $this->total = $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function getCountries()
    {
        return $this->countries;
    }

    public function placeOrder()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20'
        ]);

        try {
            DB::beginTransaction();

            // Generate a unique order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // Create the order
            $order = Order::create([
                'shop_customer_id' => auth('customer')->id(),
                'number' => $orderNumber,
                'total_price' => $this->total,
                'status' => OrderStatus::New->value,
                'currency' => 'USD',
                'shipping_price' => 0,
                'shipping_method' => 'standard',
                'notes' => $this->notes
            ]);

            // Only create address if any address field is filled
            if ($this->country || $this->street || $this->city || $this->state || $this->zip) {
                $order->address()->create([
                    'country' => $this->country,
                    'street' => $this->street,
                    'city' => $this->city,
                    'state' => $this->state,
                    'zip' => $this->zip
                ]);
            }

            // Create order items
            foreach ($this->cartItems as $cartItem) {
                OrderItem::create([
                    'shop_order_id' => $order->id,
                    'shop_product_id' => $cartItem->product_id,
                    'qty' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->price
                ]);
            }

            // Clear the cart
            CartModel::where('user_id', auth('customer')->id())->delete();

            DB::commit();

            session()->flash('success', 'Order placed successfully!');
            return redirect()->route('order.thankyou', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the actual error
            \Log::error('Order placement failed: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            session()->flash('error', 'There was an error processing your order: ' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.checkout', [
            'countries' => $this->countries
        ]);
    }
} 