@php $editing = isset($role) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="name" label="Name" :value="old('name', $editing ? $role->name : '')"></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="parent_id" label="parent" placeholder="parent" >
            <option value="">Choose</option>
            @forelse ($roles as $r)
                <option value="{{ $r->id }}"
                    {{ $editing ? ($r->id === $role->parent_id ? 'selected' : '') : '' }}>{{ $r->name }}</option>
            @empty
                No parent
            @endforelse
        </x-inputs.select>
    </x-inputs.group>
    <div class="form-group col-sm-12 mt-4">
        <h4>Assign @lang('crud.permissions.name')</h4>

        @foreach ($permissions as $permission)
            <div>
                <x-inputs.checkbox id="permission{{ $permission->id }}" name="permissions[]"
                    label="{{ ucfirst($permission->name) }}" value="{{ $permission->id }}" :checked="isset($role) ? $role->hasPermissionTo($permission) : false"
                    :add-hidden-value="false"></x-inputs.checkbox>
            </div>
        @endforeach
    </div>
</div>
{{-- @php $editing = isset($role) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="name" label="Name" :value="old('name', $editing ? $role->name : '')"></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="parent_id" label="parent" placeholder="parent" required>
            <option value="">Choose</option>
            @forelse ($roles as $r)
                <option value="{{ $r->id }}"
                    {{ $editing ? ($r->id === $role->parent_id ? 'selected' : '') : '' }}>{{ $r->name }}</option>
            @empty
                No parent
            @endforelse
        </x-inputs.select>
    </x-inputs.group>
    <div class="form-group col-sm-12 mt-4 EditRuleTitle">
        <div class="mainConRuls ">
            <div class="activeSection ">
                <div class="col-md-4"></div>
                <button class="active col-md-4">Active</button>
                <button class="unActive col-md-4">Un Active</button>
            </div>
            <div class="title">
                <div class="contitle">Assign @lang('crud.permissions.name')</div>
            </div> --}}
            {{-- @foreach ($permissions as $permission)
            <div>
                <x-inputs.checkbox id="permission{{ $permission->id }}" name="permissions[]"
                    label="{{ ucfirst($permission->name) }}" value="{{ $permission->id }}" :checked="isset($role) ? $role->hasPermissionTo($permission) : false"
                    :add-hidden-value="false"></x-inputs.checkbox>
            </div>
        @endforeach --}}
            {{-- <div class="mainTable">
                @foreach ($permissions as $permission)
                    <div class="TableRwo">
                        <div class="row">
                            <div class="col-md-4 d-flex">
                                <div class="name"><img src="{{ asset('admin/images/icons/BulletPoint.png') }}"
                                        alt="">{{ $permission->name }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="activeBtn">
                                    <label for="priN{{ $permission->id }}">
                                        <span class="btnActive ">A</span>
                                    </label>
                                    <input type="radio" name="pri{{ $permission->id }}"
                                        id="priN{{ $permission->id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="unActiveBtn"><label for="priNU{{ $permission->id }}"><span
                                            class="btnUnActive actived ">U</span></label>
                                    <input type="radio" name="pri{{ $permission->id }}"
                                        id="priNU{{ $permission->id }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div> --}}
