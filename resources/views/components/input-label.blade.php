@props(['value'])

<label {{ $attributes->merge([
    'class' => 'block text-sm font-medium text-[#4A3728]'
]) }}
style="font-family: 'Poppins', sans-serif;"
>
    {{ $value ?? $slot }}
</label>