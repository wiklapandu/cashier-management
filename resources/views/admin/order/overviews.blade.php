<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Orders')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-xl sm:rounded-lg overflow-hidden">
                <div class="mb-4">
                    <x-button-link href="{{ route('order.create') }}">Add Order</x-button-link>
                </div>
                <div class="mb-3 flex w-full">
                    @livewire('admin.order-tabel')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>