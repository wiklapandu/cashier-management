<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex items-center mb-8">
                    <div class="leading-8">
                        <h3 class="text-xl font-bold">Today's Sales</h3>
                        <h5 class="text-gray-500 font-medium">Sales Summary</h5>
                    </div>
                    <div class="ml-auto">
                        <a href="#" class="inline-flex items-center px-6 p-3 border-2 border-gray-400 text-gray-600 font-medium rounded-lg">
                            <span class="inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                                </svg>
                            </span>
                            <span class="ml-3">
                                Export
                            </span>
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-4 gap-3">
                    @for ($i = 0;$i < 4; $i++)
                    <div class="min-h-28 bg-red-200 p-4 rounded-md">
                        <div class="h-8 w-8 rounded-full mb-3 text-white bg-red-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                            <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
                            </svg>
                        </div>
                        <div class="font-bold text-2xl">$1k</div>
                        <div class="font-medium">Total Sales</div>
                        <a href="#" class="block text-blue-600">+5% from yesterday</a>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
