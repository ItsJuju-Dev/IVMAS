<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        inline-flex items-center
        px-6 py-3
        bg-[#4A3728]
        border border-transparent
        rounded-xl
        font-medium
        text-sm
        text-white
        tracking-wide
        shadow-md
        hover:bg-[#5A4635]
        transition duration-200
    '
]) }}>
    {{ $slot }}
</button>