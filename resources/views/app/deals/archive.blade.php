@extends('layouts.app')

@section('content')
    <div class="DealsArchive usersPage">
        <div class="">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">Archive Deals</h4>
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
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Recipient</th>
                                <th scope="col" class="text-center">Mobile </th>
                                {{-- <th scope="col" class="text-center">Card</th> --}}
                                <th scope="col" class="text-center">Price</th>
                                {{-- <th scope="col" class="text-center">Card name</th>
                                <th scope="col" class="text-center">Shipping Address</th> --}}
                                <th scope="col" class="text-center" class="text-left">
                                    <div class="d-flex flex-column align-items-center">
                                        <div>Deal Date</div>

                                    </div>
                                </th>
                                <th scope="col" class="text-center" class="text-left">
                                    <div class="d-flex flex-column align-items-center">
                                        <div>Receipt Date</div>

                                    </div>
                                </th>
                                <th scope="col" class="text-center">Sales</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Comment</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deals as $deal)
                                <tr>
                                    <td>
                                        <div class="tdContent">{{ $deal->defaultname }}</div>
                                    </td>
                                    <td>
                                        <div class="tdContent">{{ $deal->defaultphone }}</div>
                                    </td>
                                    {{-- <td>
                                        <div class="tdContent">
                                            @if ($deal->deal_cards->isNotEmpty())
                                                <div class="tdContent">{{ $deal->deal_cards->first()->card_name }}
                                                </div>
                                            @else
                                                <span>No Card</span>
                                            @endif
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="tdContent">EGP{{ $deal->cost }}</div>
                                    </td>
                                    {{-- <td>
                                        <div class="tdContent">{{ $deal->deal_cards()->first()->customer_name }}</div>
                                    </td> --}}
                                    {{-- <td>
                                        <div class="tdContent">{{ $deal->customer_address }}</div>
                                    </td> --}}
                                    <td>
                                        <div class="tdContent">
                                            {{ $deal->deal_date ? $deal->deal_date->format('Y-m-d') : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tdContent">
                                            {{ $deal->delivery_date ? $deal->delivery_date->format('Y-m-d') : '-' }}
                                        </div>
                                    </td>
                                    @if ($deal->lead->users->count() > 0)
                                        <td data-bs-toggle="modal" data-bs-target="#userModal{{ $deal->id }}"
                                            style="cursor: pointer">
                                            {{ $deal?->lead->users->first()->name ?? '-' }}
                                        </td>
                                    @else
                                        <td>{{ $deal?->lead->users->first()->name ?? '-' }}</td>
                                    @endif
                                    <td>
                                        <div class="tdContent">
                                            {{ $deal->status ? $deal->status : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tdContent">
                                            {{ $deal->comment ? $deal->comment : '-' }}
                                        </div>
                                    </td>


                                    <td class="action d-flex justify-content-around">
                                        @if (!Auth::user()->hasRole('Viewer Admin'))
                                            @can('delete', $deal)
                                                <form action="{{ route('deals.restore', $deal->id) }}" method="POST"
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

                                            @can('delete', $deal)
                                                <form action="{{ route('deals.forceDelete', $deal->id) }}" method="POST"
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
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14">
                                        <div class="tdContent">No deals found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination d-flex justify-content-around align-content-around">{!! $deals->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
