@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-sm text-center bg-red-600 text-white py-2 mt-1 rounded-sm']) }}>{{ $message }}</p>
@enderror