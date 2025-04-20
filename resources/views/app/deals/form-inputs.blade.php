@php $editing = isset($deal) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="customer_name"
            label="Customer Name"
            :value="old('customer_name', ($editing ? $deal->customer_name : ''))"
            maxlength="255"
            placeholder="Customer Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="customer_phone"
            label="Customer Phone"
            :value="old('customer_phone', ($editing ? $deal->customer_phone : ''))"
            maxlength="255"
            placeholder="Customer Phone"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="customer_address"
            label="Customer Address"
            :value="old('customer_address', ($editing ? $deal->customer_address : ''))"
            maxlength="255"
            placeholder="Customer Address"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="cost"
            label="Cost"
            :value="old('cost', ($editing ? $deal->cost : ''))"
            max="255"
            placeholder="Cost"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="deal_date"
            label="Deal Date"
            value="{{ old('deal_date', ($editing ? optional($deal->deal_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="delivery_date"
            label="Delivery Date"
            value="{{ old('delivery_date', ($editing ? optional($deal->delivery_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="card_name"
            label="Card Name"
            maxlength="255"
            required
            >{{ old('card_name', ($editing ? json_encode($deal->card_name) :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="status_id" label="Status" required>
            @php $selected = old('status_id', ($editing ? $deal->status_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Status</option>
            @foreach($statuses as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="lead_id" label="Lead" required>
            @php $selected = old('lead_id', ($editing ? $deal->lead_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Lead</option>
            @foreach($leads as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
