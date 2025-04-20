<div>

    <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.roles.name')</h4>

        @foreach ($roles as $role)
            <div>
                <x-inputs.checkbox wire:model.live="selectedRoles" id="role{{ $role->id }}" name="roles[]"
                    label="{{ ucfirst($role->name) }}" value="{{ $role->id }}"
                    :add-hidden-value="false"></x-inputs.checkbox>
            </div>
        @endforeach
    </div>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="leader" label="leader" placeholder="leader">
            <option value="">Choose</option>
            @forelse ($users as $u)
                <option value="{{ $u->id }}"
                    {{ $editing ? (in_array($u->id, $parentsIds) ? 'selected' : '') : '' }}>{{ $u->name }}</option>
            @empty
                No Leader
            @endforelse
        </x-inputs.select>
    </x-inputs.group>

</div>
