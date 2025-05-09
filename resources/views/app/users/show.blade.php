@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('users.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.users.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.users.inputs.name')</h5>
                        <span>{{ $user->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.users.inputs.email')</h5>
                        <span>{{ $user->email ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.roles.name')</h5>
                        <div>
                            @forelse ($user->roles as $role)
                                <div class="badge badge-primary">{{ $role->name }}</div>
                                <br />
                            @empty -
                            @endforelse
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5>Leader Name</h5>
                        <div>
                        <div class="badge badge-primary">
    {{ $user?->parents?->first()?->name ?? '-' }}
</div>
                            <br />
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @if (!Auth::user()->hasRole('Viewer Admin'))
                        @can('create', App\Models\User::class)
                            <a href="{{ route('users.create') }}" class="btn btn-light">
                                <i class="icon ion-md-add"></i> @lang('crud.common.create')
                            </a>
                        @endcan
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
