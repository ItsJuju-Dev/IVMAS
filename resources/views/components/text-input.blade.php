@props(['disabled' => false])

<input @disabled($disabled) {!! $attributes->merge([
    'class' => 'border-[#D8CFC2] bg-[#FCFAF5] text-brand-brown focus:border-brand-brown focus:ring-brand-brown rounded-xl shadow-sm'
]) !!}>