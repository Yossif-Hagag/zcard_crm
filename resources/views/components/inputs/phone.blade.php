@props([
    'name',
    'label',
    'value',
    'min' => null,
    'max' => null,
    'step' => null,
])

<x-inputs.basic type="text" :name="$name" label="{{ $label ?? ''}}" :value="$value ?? ''" :attributes="$attributes"></x-inputs.basic>
