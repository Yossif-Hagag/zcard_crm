@extends('layouts.app')
@section('style')
<style>

</style>
@endsection
@section('content')
    <div class="container-fluid usersPage">
        <div class="">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.users.index_title')</h4>
                </div>

                <div class="searchbar mt-4 mb-5">
                    <div class="row">
                        <div class="col-md-10">
                            <form>
                                <div class="input-group">
                                    <input id="indexSearch" type="text" name="search"
                                        placeholder="{{ __('crud.common.search') }}" value="{{ $search ?? '' }}"
                                        class="" autocomplete="off" />
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
                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                @can('create', App\Models\User::class)
                                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                                        @lang('crud.common.create')
                                    </a>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    @lang('crud.users.inputs.name')
                                </th>
                                <th class="text-center">
                                    @lang('crud.users.inputs.email')
                                </th>
                                <th class="text-left">
                                    @lang('crud.cards.inputs.image')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="tdContent tdName">
                                            {{ $user->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tdContent">
                                            {{ $user->email ?? '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        <x-partials.thumbnail src="{{ $user->image ? \Storage::url($user->image) : '' }}" />
                                    </td>

                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @can('update', $user)
                                                @if (!Auth::user()->hasRole('Viewer Admin'))
                                                    <a href="{{ route('users.edit', $user) }}">
                                                        <button type="button" class="btn ">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                                @endcan @can('view', $user)
                                                <a href="{{ route('users.show', $user) }}">
                                                    <button type="button" class="btn ">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </a>
                                            @endcan
                                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                                @can('delete', $user)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn  text-danger">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination d-flex justify-content-around align-content-around">{!! $users->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
