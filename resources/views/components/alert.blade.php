@props(['type' => 'success'])

@php
    $classes = $type === 'error'
        ? 'border-[#d4d4d4] bg-[#f5f5f5] text-[#111111]'
        : 'border-[#e5e5e5] bg-white text-[#111111]';
@endphp

<div {{ $attributes->class(['mb-6 border px-4 py-3 text-sm', $classes]) }} role="alert">
    {{ $slot }}
</div>
