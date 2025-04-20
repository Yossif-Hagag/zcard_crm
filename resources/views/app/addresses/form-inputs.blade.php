@php $editing = isset($address) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="address"
            label="Address"
            :value="old('address', ($editing ? $address->address : ''))"
            maxlength="255"
            placeholder="Address"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="flat_number"
            label="Flat Number"
            :value="old('flat_number', ($editing ? $address->flat_number : ''))"
            maxlength="255"
            placeholder="Flat Number"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="floor"
            label="Floor"
            :value="old('floor', ($editing ? $address->floor : ''))"
            maxlength="255"
            placeholder="Floor"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $address->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
