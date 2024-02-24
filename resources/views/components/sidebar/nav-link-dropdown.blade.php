@props(['classes' => '', 'active' => false, 'schema' => 'light'])

@php
    $isActive = 'false'; 
    if($active) {
       $classes = ''; 
       $isActive = 'true'; 
    } else {
       $isActive = 'false'; 
    }
@endphp

<span class="grid" x-data="{isActive: {{$isActive}}}">
    <button @click="isActive = !isActive" type="button" 
    class="text-slate-600 flex items-center hover:bg-slate-600 hover:text-white active:scale-95 hover:bg-opacity-95 cursor-pointer ease-in duration-150 p-4 rounded-xl group"
    :class="{'text-white': isActive, 'text-slate-600': !isActive, 'bg-slate-600': isActive}"
    >
        {{ $icon }}
        <span class="ml-5 block">
            {{ $trigger }}
        </span>
        <span :class="{'rotate-90': isActive}" class="block ml-auto duration-150 ease-in">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
            </svg>
        </span>
    </button>

    <div x-show="isActive" @click.outside="isActive = false" class="mt-3">
        {{ $slot }}
    </div>
</span>