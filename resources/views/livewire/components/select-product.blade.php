@props(['class' => ''])

<div class="w-full relative" x-data="{show: false}" @click.away="show = false">
    <x-input placeholder="Search Product..." wire:model="search" wire:input.debounce.250ms="find" class="w-full select-search" @focus="show = true"/>

    <div x-show="show" class="bg-white shadow-xl h-fit absolute z-50 grid gap-y-1 overflow-auto w-full mt-3 rounded-md">
        @if(isset($selected['label'])) 
        <button type="button" class="p-2 text-left cursor-pointer border-2 hover:border-blue-600 border-blue-600 bg-blue-600 text-white first:rounded-t-md last:rounded-b-md"
            wire:click="unset"
        >{{ $selected['label'] }}</button>
        @endif

        @if (!$products)
            <button type="button" class="p-2 text-left cursor-pointer border-2 border-transparent bg-white text-gray-500 first:rounded-t-md last:rounded-b-md"
            >Type to search...</button>
        @endif

        @foreach ($products as $value => $label)
            <button type="button"
            class="p-2 text-left cursor-pointer border-2 border-transparent hover:border-blue-600 active:border-blue-600 active:bg-blue-600 active:text-white first:rounded-t-md last:rounded-b-md" 
            wire:click.prevent="choice('{{$label}}', '{{$value}}')"
            >{{ $label }}</button>
        @endforeach
    </div>
</div>