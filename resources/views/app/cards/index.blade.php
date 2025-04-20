@extends('layouts.app')

@section('content')
    <div class="usersPage">
        <div class="">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.cards.index_title')</h4>
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
                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                @can('create', App\Models\Card::class)
                                    <a href="{{ route('cards.create') }}" class="btn btn-primary">
                                        <i class="icon ion-md-add"></i>
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
                                <th class="text-left">
                                    @lang('crud.cards.inputs.name')
                                </th>
                                <th class="">
                                    @lang('crud.cards.inputs.cost')
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
                            @forelse($cards as $card)
                                <tr>
                                    <td>{{ $card->name ?? '-' }}</td>
                                    <td>{{ $card->cost ?? '-' }}</td>
                                    <td>
                                        <x-partials.thumbnail src="{{ $card->image ? \Storage::url($card->image) : '' }}" />
                                    </td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group gap-1">
                                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                                @can('update', $card)
                                                    <a href="{{ route('cards.edit', $card) }}">
                                                        <button type="button" class="btn btn-light">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>
                                                    </a>
                                                @endcan
                                            @endif
                                            @can('view', $card)
                                                <a href="{{ route('cards.show', $card) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </a>
                                            @endcan
                                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                                @can('delete', $card)
                                                    <form action="{{ route('cards.destroy', $card) }}" method="POST"
                                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-light text-danger">
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
                                    <td colspan="4">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination d-flex justify-content-around align-content-around">{!! $cards->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
