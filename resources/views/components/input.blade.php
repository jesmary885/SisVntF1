@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'inline-flex items-center rounded-md border border-gray-300 bg-gray-50 text-gray-500 sm:text-sm']) !!}>
