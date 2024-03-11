<div class="bg-white p-6 shadow-xl sm:rounded-lg overflow-hidden">
    <div class="mb-3 flex">
        <h1 class="text-2xl font-medium">
            All Products
        </h1>

        <div class="inline-block ml-auto">
            <x-button wire:click="openAddModal()">
                Add Product
            </x-button>
        </div>
    </div>

    @if ($alert['type'])
        @php
            $type = $alert['type'] === 'success' ? 'bg-green-100 text-green-800 border border-green-800' : 'bg-red-100 text-red-600 border border-red-800';
        @endphp
        <div class="p-4 px-6 {{ $type }} mb-4 rounded-md flex" x-data="{alertOpen: {{ isset($alert['type']) ? 'true' : 'false' }}}" x-show="alertOpen">
            <p>{{ $alert['message'] }}</p>

            <button type="button" class="ml-auto hover:scale-95" @click="alertOpen = false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
        </div>
    @endif

    <div class="mb-4">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-8">
            <table id="admin-products-lists" href="{{route('product.read')}}" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            SKU
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sale
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $product->details->sku }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $product->stock }}
                            </td>
                            <td
                                class="px-6 py-4 font-medium {{ $product->status_stock === 'instock' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->status_stock }}
                            </td>
                            <td class="px-6 py-4 font-medium {{ $product->sale_price ? 'text-green-600' : '' }}">
                                {{ $product->sale_price ? 'Yes' : 'No' }}
                            </td>
                            <td class="px-6 py-4">
                                {!! $product->getPriceFormated() !!}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="#"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline" wire:click="openEditModel('{{ $product->id }}')">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>

    @if (isset($modal['type']))
    <div wire:ignore.self class="absolute z-50 w-screen flex justify-center h-screen overflow-hidden right-0 top-0 bg-black bg-opacity-25" x-data="{modalOpen: {{ isset($modal['type']) ? 'true' : 'false'}}}" x-show="modalOpen">
        <div class="my-auto mx-auto w-1/2 h-full">
            <div class="bg-white block h-full overflow-auto max-h-[90vh] p-8 mx-auto min-h-32 my-7 rounded-lg shadow-xl">
                <div class="flex w-full items-center mb-4">
                    <h1 class="text-2xl">{{ $modal['type'] == 'edit' ? 'Edit Product' : 'Add Product' }}</h1>

                    <div class="ml-auto cursor-pointer" wire:click="closeModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </div>
                </div>
                
                <div class="mb-3">
                    <x-label>
                        {{__('Name Product')}}
                        <x-input :value="$productModal['name'] ?? ''" wire:model.defer="productModal.name" class="block w-full"/>
                    </x-label>
                </div>

                <div class="mb-3">
                    <x-label>
                        {{__('SKU Product')}}
                        <x-input name="sku" id="sku" :value="$productModal['sku'] ?? ''" wire:model="productModal.sku" class="block w-full"/>
                    </x-label>
                </div>

                <div class="mb-3">
                    <x-label>
                        {{__('Stock Product')}}
                        <x-input name="stock" id="stock" type="number" :value="$productModal['stock'] ?? ''" wire:model="productModal.stock" class="block w-full"/>
                    </x-label>
                </div>
                <div class="mb-3">
                    <x-label>
                        {{__('Sale Price')}}
                        <x-input name="sale_price" id="sale_price" type="number" :value="$productModal['sale_price'] ?? ''" wire:model="productModal.sale_price" class="block w-full"/>
                    </x-label>
                </div>

                <div class="mb-3">
                    <x-label>
                        {{__('Price')}}
                        <x-input type="number" name="price" id="price" :value="$productModal['price'] ?? ''" wire:model="productModal.price" class="block w-full"/>
                    </x-label>
                </div>

                <div class="mb-3">
                    <x-label>
                        {{__('Short Description')}}
                        <x-textarea row="5" class="block w-full" wire:model.live="productModal.short_description">{{$productModal['short_description']}}</x-textarea>
                    </x-label>
                </div>
                <div class="mb-3">
                    <x-label>
                        {{__('Description')}}
                        <x-textarea class="block w-full" wire:modal.live="productModal.description">{{$productModal['description']}}</x-textarea>
                    </x-label>
                </div>

                <div class="mb-3">
                    <x-button wire:click="updateProduct()">{{ $modal['type'] == 'edit' ? 'Update' : 'Submite' }}</x-button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
