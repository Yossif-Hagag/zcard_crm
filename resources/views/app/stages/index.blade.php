@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">@lang('crud.stages.index_title')</h4>
                </div>

                <div class="searchbar mt-4 mb-5">
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="input-group">
                                    <input id="indexSearch" type="text" name="search"
                                        placeholder="{{ __('crud.common.search') }}" value="{{ $search ?? '' }}"
                                        class="form-control" autocomplete="off" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                @can('create', App\Models\Stage::class)
                                    <a href="{{ route('stages.create') }}" class="btn btn-primary">
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
                                    @lang('crud.stages.inputs.name')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stages as $stage)
                                <tr>
                                    <td>{{ $stage->name ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                                @can('update', $stage)
                                                    <a href="{{ route('stages.edit', $stage) }}">
                                                        <button type="button" class="btn btn-light">
                                                            <i class="icon ion-md-create"></i>
                                                        </button>
                                                    </a>
                                                @endcan
                                                @can('view', $stage)
                                                    <a href="{{ route('stages.show', $stage) }}">
                                                        <button type="button" class="btn btn-light">
                                                            <i class="icon ion-md-eye"></i>
                                                        </button>
                                                    </a>
                                                @endcan
                                                @can('delete', $stage)
                                                    <form action="{{ route('stages.destroy', $stage) }}" method="POST"
                                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-light text-danger">
                                                            <i class="icon ion-md-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif
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
                    <div class="pagination d-flex justify-content-around align-content-around">{!! $stages->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
