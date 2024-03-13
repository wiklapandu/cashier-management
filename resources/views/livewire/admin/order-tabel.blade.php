<div class="mb-4 w-full">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-8">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Customer
                </th>
                <th scope="col" class="px-6 py-3">
                    Items Subtotal
                </th>
                <th scope="col" class="px-6 py-3">
                    Order Total
                </th>
                <th scope="col" class="px-6 py-3">
                    Created By
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Created At
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </thead>

            <tbody>
                @foreach ($orders as $order)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ $order->id }}
                        </th>
                        <td class="px-6 py-4">{{$order->details->customer_detail->user->name}}</td>
                        <td class="px-6 py-4">{{ Str::get_price_html($order->items_subtotal) }}</td>
                        <td class="px-6 py-4">{{ Str::get_price_html($order->order_total) }}</td>
                        <td class="px-6 py-4">{{ $order->author->name ?? $order->author_id }}</td>
                        <td class="px-6 py-4">{{ $order->getStatusLabel() }}</td>
                        <td class="px-6 py-4">{{ $order->getCreatedAtFormated('d F Y') }}</td>
                        <td class="px-6 py-4"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>
</div>