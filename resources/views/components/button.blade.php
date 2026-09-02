@props(['variant' => 'primary', 'type' => 'button'])

<button type="{{ $type }}" {{ $attributes->class([$variant === 'primary' ? 'btn-primary' : 'btn-secondary']) }}>
    {{ $slot }}
</button>
