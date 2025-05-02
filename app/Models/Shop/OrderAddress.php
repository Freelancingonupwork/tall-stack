<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderAddress extends Model
{
    use HasFactory;

    protected $table = 'shop_order_addresses';

    protected $fillable = [
        'shop_order_id',
        'country',
        'street',
        'city',
        'state',
        'zipcode',
        'addressable_type',
        'addressable_id'
    ];

    /** @return MorphTo<Model,self> */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
