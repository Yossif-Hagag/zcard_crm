@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="createUserPage">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('users.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.users.edit_title')
            </h4>

            <x-form
                method="PUT"
                action="{{ route('users.update', $user) }}"
                has-files
                class="mt-4"
            >
            @csrf
                @include('app.users.form-inputs')

                <div class="mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left text-primary"></i>
                        @lang('crud.common.back')
                    </a>

                    <a href="{{ route('users.create') }}" class="btn btn-light">
                        <i class="icon ion-md-add text-primary"></i>
                        @lang('crud.common.create')
                    </a>

                    <button type="submit" class="btn btn-primary float-right btnn">

                        @lang('crud.common.update')
                    </button>
                </div>
            </x-form>
        </div>
    </div>
</div>
@endsection
