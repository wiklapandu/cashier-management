@props(['disabled' => false, 'row' => 10, 'col' => 30])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!} cols="{{$col}}" rows="{{$row}}">{{$slot}}</textarea>