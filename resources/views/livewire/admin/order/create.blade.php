<form class="grid gap-4">
    <div class="sm:rounded-lg overflow-hidden">
        <div class="p-6 flex items-center font-medium">
            <h1 class="text-xl font-medium">Add new Order</h1>
        </div>      
    </div>
    
    <!-- Order Details -->
    <div class="bg-white p-6 shadow-xl sm:rounded-lg overflow-hidden">
        <div class="flex items-center font-medium mb-3">
            <h2 class="text-lg font-medium">Order Details</h2>
        </div>
        <div class="grid grid-cols-3 gap-2">
            <div>
                <h3 class="font-medium mb-3">General</h3>
                <div class="mb-2">
                    <x-label>
                        {{ __('Date Created') }}
                        <x-input type="date" name="created_at" class="block w-full" />
                    </x-label>
                </div>
                <div class="mb-2">
                    <x-label>
                        {{ __('Status') }}
                        <x-select class="block w-full" name="status" wire:model="order.status">
                            <option value="">Choose Status</option>
                            @foreach ($statusLists as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-select>
                    </x-label>
                </div>
                <div class="mb-2">
                    <x-label>
                        {{ __('Customer') }}
                        <x-select class="block w-full" name="status" wire:model.live="order.customer_id">
                            <option value="">Choose Customer</option>
                            @foreach ($customersLists as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-select>
                    </x-label>
                </div>
            </div>
            <div>
                <div class="flex mb-3">
                    <h3 class="font-medium">Billing</h3>

                    <button type="button" class="ml-auto" wire:click="toggleBillingDetails" title="{{ !$setBillingDetails ? 'set billing details' : '' }}">
                        @if (!$setBillingDetails)
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        @endif
                    </button>
                </div>
                @if ($setBillingDetails)
                <div class="billing_details">
                    <div class="mb-2">
                        <x-label>
                            {{ __('Address') }}
                            <x-input type="text" name="address" wire:model="billing_details.address" class="block w-full" />
                        </x-label>
                    </div>
                    <div class="mb-2">
                        <x-label>
                            {{ __('Email Address') }}
                            <x-input type="text" name="email" wire:model="billing_details.email" class="block w-full" />
                        </x-label>
                    </div>
                </div>
                @else
                <div class="billing_details">
                    <div class="mb-2">
                        <x-label>
                            {{ __('Address') }}
                            <p class="text-gray-500">{{ isset($billing_details['address']) && $billing_details['address'] != '' ? $billing_details['address'] : 'No billing address set.'  }}</p>
                        </x-label>
                    </div>
                    <div class="mb-2">
                        <x-label>
                            {{ __('Email Address') }}
                            <p class="text-gray-500">{{ isset($billing_details['email']) && $billing_details['email'] != '' ? $billing_details['email'] : 'No billing email address set.'  }}</p>
                        </x-label>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    
    <!-- Order Items -->
    <div class="bg-white p-6 shadow-xl sm:rounded-lg min-h-[50vh]">
        <div class="mb-4 flex">
            <h2 class="font-medium text-xl">Order Items</h2>

            <x-button type="button" class="ml-auto" wire:click.prevent="addRowItem">Add Item</x-button>
        </div>

        <div class="mb-4">
            <div class="lists_of_items grid">
            @if (isset($temp_items['product_id']))
                <div class="grid w-full grid-cols-5 p-3 gap-2 items-end">
                    <x-label class="col-span-2">
                        {{__('Product')}}
                        <livewire:components.select-product listenerName="temp-item-set-product"/>
                    </x-label>
                    <x-label class="col-span-2">
                        {{__('QTY')}}
                        <x-input type="number" value="1" class="block w-full" wire:model="temp_items.qty"/>
                    </x-label>
                    <div class="col-span-1 flex gap-1">
                        <x-button-link href="#" class="block bg-white hover:bg-red-500 hover:!text-white active:ring-red-500 active:bg-red-500 active:!text-white border-red-500 !text-red-500" wire:click.prevent="unsetTempItem" wire:confirm="Are you sure want to unset this item?">
                           Cancel
                        </x-button-link>
                        <x-button type="button" class="block" wire:click.prevent="addItem">
                            Save
                        </x-button>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>
</form>