@props(['classes' => '','active' => false, 'icon' => '', 'schema' => 'light'])

@php
    if($schema == 'dark') {
        $classes = "text-white hover:bg-white hover:text-slate-600";
    }

    if($active) {
        if($schema == 'light') {
            $classes = "bg-blue-600 !text-white shadow-lg shadow-blue-300";
        } else {
            $classes = "bg-white !text-slate-600";
        }
    }
@endphp


<a {{ $attributes->merge(['class' => $classes . " flex items-center hover:bg-blue-600 hover:text-white active:scale-95 cursor-pointer ease-in duration-150 p-4 rounded-xl text-gray-500"]) }}>
    {{$icon}}
    <span class="ml-3">
        {{$slot}}
    </span>
</a>