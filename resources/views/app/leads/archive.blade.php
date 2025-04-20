@extends('layouts.app')

@section('content')
    <div class=" usersPage">
        <div class="">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">Archive Leads</h4>
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
                        {{-- <div class="col-md-2 text-right">
                            @can('create', App\Models\Lead::class)
                                <a href="{{ route('leads.create') }}" class="btn btn-primary">
                                    <i class="icon ion-md-add"></i>
                                    @lang('crud.common.create')
                                </a>
                            @endcan
                        </div> --}}
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.name')
                                </th>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.phone')
                                </th>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.phone2')
                                </th>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.address')
                                </th>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.stage_id')
                                </th>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.user_id')
                                </th>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.follow_date')
                                </th>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.contract_id')
                                </th>
                                <th class="text-center">
                                    @lang('crud.leads.inputs.card_id')
                                </th>
                                <th class="text-center">
                                    @lang('crud.common.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leads as $lead)
                                <tr class="text-center">
                                    <td>{{ $lead->name ?? '-' }}</td>
                                    <td>{{ $lead->phone ?? '-' }}</td>
                                    <td>{{ $lead->phone2 ?? '-' }}</td>
                                    <td>{{ $lead->address ?? '-' }}</td>
                                    <td>{{ optional($lead->stage)->name ?? '-' }}</td>
                                    @forelse ($lead->users as $user)
                                        <td>{{ $user->name }}</td>
                                    @empty
                                        <td>{{ ' - ' }}</td>
                                    @endforelse
                                    <td>{{ $lead->follow_date ?? '-' }}</td>
                                    <td>
                                        {{ optional($lead->contract)->name ?? '-' }}
                                    </td>
                                    <td>{{ optional($lead->card)->name ?? '-' }}</td>
                                    <td class="text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="btn-group">
                                            {{-- @can('update', $lead)
                                    <a href="{{ route('leads.edit', $lead) }}">
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $lead)
                                    <a href="{{ route('leads.show', $lead) }}">
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan  --}}

                                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                                @can('delete', $lead)
                                                    <form action="{{ route('leads.restore', $lead->id) }}" method="POST"
                                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-light text-danger">
                                                            <div class="tdContent">
                                                                <img src="{{ asset('fro/images/icons/folder.png') }}"
                                                                    alt="">
                                                            </div>
                                                        </button>
                                                    </form>
                                                @endcan

                                                @can('delete', $lead)
                                                @if ($lead->deals()->exists())
                                                    <form action="{{ route('leads.forceDelete', $lead->id) }}" method="POST"
                                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-light text-danger" disabled>
                                                            <div class="tdContent">
                                                                <img src="{{ asset('fro/images/icons/delete.png') }}"
                                                                    alt="">
                                                            </div>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('leads.forceDelete', $lead->id) }}" method="POST"
                                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-light text-danger">
                                                            <div class="tdContent">
                                                                <img src="{{ asset('fro/images/icons/delete.png') }}"
                                                                    alt="">
                                                            </div>
                                                        </button>
                                                    </form>
                                                    @endif
                                                @endcan
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="10">
                                        @lang('crud.common.no_items_found')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination d-flex justify-content-around align-content-around">{!! $leads->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
