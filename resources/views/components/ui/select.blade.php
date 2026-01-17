@props([
    'label' => null,
    'error' => null,
    'helper' => null,
    'required' => false,
    'disabled' => false,
    'placeholder' => null,
    'options' => [],
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

    <select 
        {{ $attributes->except('class')->merge([
            'class' => 'form-select' . ($error ? ' form-input-error' : '')
        ]) }}
        @if($disabled) disabled @endif
        @if($required) required @endif
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @if(count($options) > 0)
            @foreach($options as $value => $optionLabel)
                <option value="{{ $value }}" {{ old($attributes->get('name')) == $value ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>

    @if($error)
        <p class="form-error">{{ $error }}</p>
    @elseif($helper)
        <p class="form-helper">{{ $helper }}</p>
    @endif
</div>
