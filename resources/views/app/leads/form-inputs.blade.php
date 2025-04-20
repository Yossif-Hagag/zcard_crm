@php $editing = isset($lead) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $lead->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="phone"
            label="Phone"
            :value="old('phone', ($editing ? $lead->phone : ''))"
            maxlength="255"
            placeholder="Phone"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="phone2"
            label="Phone2"
            :value="old('phone2', ($editing ? $lead->phone2 : ''))"
            maxlength="255"
            placeholder="Phone2"
        ></x-inputs.text>
    </x-inputs.group>

   
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="stage_id" label="Stage">
            @php
            $selected = old('stage_id', $editing ? $lead->stage_id : '');
            @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Stage</option>
            @foreach($stages as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="source_id" label="Source" required>
            @php $selected = old('source_id', ($editing ? $lead->source_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Source</option>
            @foreach($sources as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>



    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="follow_date"
            label="Follow Date"
            value="{{ old('follow_date', ($editing ? optional($lead->follow_date)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
    <x-inputs.text
        name="follow_up_comment"
        label="Follow Comment"
        value="{{ old('follow_up_comment', ($editing ? $lead->follow_up_comment : '')) }}"
        max="255"
    ></x-inputs.text> <!-- Corrected from x-inputs.date to x-inputs.text -->
</x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="contract_id" label="Contract" required>
            @php $selected = old('contract_id', ($editing ? $lead->contract_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Contract</option>
            @foreach($contracts as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

</div>
