@props([
    'label' => null,
    'error' => null,
    'helper' => null,
    'required' => false,
    'disabled' => false,
    'type' => 'text',
])

<div {{ $attributes->only('class')->merge(['class' => '']) }}>
    @if($label)
        <label for="{{ $attributes->get('id') }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input 
        type="{{ $type }}"
        {{ $attributes->except('class')->merge([
            'class' => 'form-input' . ($error ? ' form-input-error' : '')
        ]) }}
        @if($disabled) disabled @endif
        @if($required) required @endif
    >

    @if($error)
        <p class="form-error">{{ $error }}</p>
    @elseif($helper)
        <p class="form-helper">{{ $helper }}</p>
    @endif
</div>
