@extends('layouts.app')

@section('content')
    <div class=" usersPage">
        <div class="">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.roles.index_title')</h4>
                </div>

                <div class="searchbar mt-4 mb-5">
                    <div class="row">
                        <div class="col-md-10">
                            <form>
                                <div class="input-group">
                                    <input id="indexSearch" type="text" name="search"
                                        placeholder="{{ __('crud.common.search') }}" value="{{ $search ?? '' }}"
                                        class="form-control" autocomplete="off" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-dark">
                                            <img src="{{ asset('admin/images/icons/magnifying-glass1.png') }}"
                                                alt="" srcset="">
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2 text-right">
                            @can('create', App\Models\Role::class)
                                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                    <i class="icon ion-md-add"></i>
                                    @lang('crud.common.create')
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    @lang('crud.roles.inputs.name')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->name ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group gap-1">
                                            @can('update', $role)
                                                <a href="{{ route('roles.edit', $role) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                </a>
                                            @endcan

                                            @can('view', $role)
                                                <a href="{{ route('roles.show', $role) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </a>
                                                @endcan @can('delete', $role)
                                                <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-light text-danger">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination d-flex justify-content-around align-content-around">{!! $roles->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
