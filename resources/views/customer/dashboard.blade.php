<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Welcome, {{ Auth::guard('customer')->user()->name }}!</h2>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600">Your Account Dashboard</p>
                        </div>
                        <div class="logout-btn">
                            <livewire:auth.customer-logout />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 