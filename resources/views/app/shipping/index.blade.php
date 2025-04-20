@php
    use App\Models\Lead;

@endphp
@extends('layouts.app')
@section('style')
    <style>
        .page-item.active .page-link {
            background-color: #3551B5 !important;
            color: #fff !important;
            border-color: unset !important;
        }

        .delay {
            position: absolute;
            right: 60px;
        }

        .codeEdit .btns .lite,
        .codeConfirm .btns .lite {
            /* width: 50%; */
            background-color: rgb(235 234 234);
            border-radius: 12px;
            font-size: small;
            color: black;
            transition: 1s;
        }

        .codeEdit .btns .black,
        .codeConfirm .btns .black {
            /* width: 50%; */
            background-color: #333333;
            border-radius: 12px;
            font-size: small;
            color: #EBEAEA;
            transition: 1s;
        }

        .shippTablee {
            font-size: small
        }

        .table-header {
            padding: 5px !important;
            gap: 2px
        }
    </style>
@endsection
@section('titlePage')
    Manage Management System
@endsection
@section('path')
    <span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
            class="fa-solid fa-chevron-right"></i></span>
    <span><a class="text-decoration-none text-body" href="{{ route('shippings.index') }}">Shipping</a> <i
            class="fa-solid fa-chevron-right"></i></span>
@endsection
@section('search')
@endsection
@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show w-75" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show w-75" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ $error }}
            </div>
        @endforeach
    @endif

    <!-- DATA table -->
    <section class="section3 shippingPage ShippingPage">
        <div class="tableData pt-0 d-flex  align-items-center justify-content-between">
            <div class="" style="min-width: fit-content; width: 100%;">
                <!-- Customer data -->
                <div class="customerData">
                    <div class="titles">
                        <h5 class="fw-bold">Total Order: {{ $shippings->count() ?? 0 }}</h5>

                        @if (!Auth::user()->hasRole('Team Leader'))
                            <div class="delay"> <button class="btnActionBlack" data-bs-toggle="modal"
                                    data-bs-target="#Delay">Delay List</button>
                            </div>
                        @endif

                    </div>
                </div>
                <!-- Customer data -->
                <div class="">


                    <div class="headerSearching">
                        <div class="table-header">
                            <form class="d-flex justify-content-around align-items-center w-100 h-100">
                                <div id="all" class="item"><a href="{{ route('shippings.index') }}"
                                        class=""><button class="btn btn-sm" value="all"
                                            name="item_name">All</button></a></div>
                                <div id="new" class="item"><a href="{{ route('shippings.index') }}"
                                        class=""><button class="btn btn-sm" value="new"
                                            name="item_name">New</button></a></div>
                                <div id="in-progress" class="item"><a href="{{ route('shippings.index') }}"
                                        class=" filter__link--number"> <button class="btn btn-sm" value="in-progress"
                                            name="item_name">In progress</button></a></div>
                                <div id="on-the-way" class="item"><a href="{{ route('shippings.index') }}"
                                        class=" filter__link--number"> <button class="btn btn-sm" value="on-the-way"
                                            name="item_name">On the way</button></a>
                                </div>
                                <div id="waiting-for-follow-up" class="item"><a href="{{ route('shippings.index') }}"
                                        class=" filter__link--number"> <button class="btn btn-sm"
                                            value="waiting-for-follow-up" name="item_name">Waiting for
                                            follow-up</button></a></div>
                                <div id="completed" class="item"><a href="{{ route('shippings.index') }}"
                                        class=" filter__link--number"> <button class="btn btn-sm" value="completed"
                                            name="item_name">Successfully completed</button></a></div>
                                <div id="unsuccessful" class="item"><a href="{{ route('shippings.index') }}"
                                        class=" filter__link--number"> <button class="btn btn-sm" value="unsuccessful"
                                            name="item_name">Unsuccessful completion</button></a></div>
                                <div id="returns-rejected" class="item"><a href="{{ route('shippings.index') }}"
                                        class=" filter__link--number"> <button class="btn btn-sm" value="returns-rejected"
                                            name="item_name">Returns are rejected</button></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="headerSearching">
                        <div class="table-header">
                            <form class="d-flex align-items-center w-100 mx-4 h-100">
                                <div id="" class="fillterInputs"><input type="text" class="shippingSearchInput"
                                        id="customer_name" name="customer_name" value="{{ request('customer_name') }}"
                                        placeholder="Name"></div>
                                <div id="" class="fillterInputs"><input type="text"
                                        class="shippingSearchInput" id="customer_phone" name="customer_phone"
                                        value="{{ request('customer_phone') }}" placeholder="Phone"></div>
                                <div id="" class="fillterInputs"><input type="text"
                                        class="shippingSearchInput" id="location" name="location"
                                        value="{{ request('location') }}" placeholder="Location"></div>

                                <div id="" class="fillterInputs"><input type="text"
                                        class="shippingSearchInput" id="price" name="price"
                                        value="{{ request('price') }}" placeholder="Price"></div>
                                <div id="" class="fillterInputs"><select id="delivery_status"
                                        name="delivery_status">
                                        <option value="">Delivery Status</option>
                                        <option value="Delivery Representatives"
                                            {{ request('delivery_status') == 'Delivery Representatives' ? 'selected' : '' }}>
                                            Delivery Representatives
                                        </option>
                                        <option value="Shipping Company"
                                            {{ request('delivery_status') == 'Shipping Company' ? 'selected' : '' }}>
                                            Shipping Company
                                        </option>
                                    </select></div>
                                <div id="" class="fillterInputs"><select id="attempts" name="attempts">
                                        <option value="">Attempts</option>
                                        <option value="1" {{ request('attempts') == '1' ? 'selected' : '' }}>
                                            1
                                        </option>
                                        <option value="2" {{ request('attempts') == '2' ? 'selected' : '' }}>
                                            2
                                        </option>
                                        <option value="3" {{ request('attempts') == '3' ? 'selected' : '' }}>
                                            3
                                        </option>
                                    </select></div>
                                <div id="" class="fillterInputs towInputs"><input type="date"
                                        name="delivery_date_from" id="delivery_date_from"
                                        value="{{ $deliveryDateFrom ?? null }}" class="shippingSearchingDate">

                                    <input type="date" name="delivery_date_to" id="delivery_date_to"
                                        value="{{ $deliveryDateTo ?? null }}" class="shippingSearchingDate">
                                </div>
                                <div id="" class="fillterInputs"><select id="delivery_boy" name="delivery_boy">
                                        <option value="">Delivery Boy</option>
                                        @forelse ($delivryBoys as $boy)
                                            <option value="{{ $boy->id }}"
                                                {{ request('delivery_boy') == $boy->id ? 'selected' : '' }}>
                                                {{ $boy->name }}
                                            </option>
                                        @empty
                                            <option>No Delivery Boy</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div id="" class="fillterInputs"><select id="sales" name="sales">
                                        <option value="">Sales</option>
                                        @forelse ($sales as $salesboy)
                                            <option value="{{ $salesboy->id }}"
                                                {{ request('sales') == $salesboy->id ? 'selected' : '' }}>
                                                {{ $salesboy->name }}
                                            </option>
                                        @empty
                                            <option>No Sales</option>
                                        @endforelse
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <input type="hidden" name="" id="item_name" value="{{ $item_name }}">

                    <div class="shippTablee">
                        <div class="table-header">
                            <div class="header__item"><a id="name" class="filter__link">ID</a></div>
                            <div class="header__item">
                                <a id="name" class="filter__link">Customer Name</a>

                            </div>
                            <div class="header__item">
                                <a id="wins" class="filter__link filter__link--number">Customer
                                    Number</a>

                            </div>
                            <div class="header__item">
                                <a id="draws" class="filter__link filter__link--number">Location</a>

                            </div>
                            <div class="header__item"><a id="losses" class="filter__link filter__link--number">Price
                                </a>

                            </div>
                            <div class="header__item"><a id="losses"
                                    class="filter__link filter__link--number">Delivery Status
                                </a>

                            </div>
                            <div class="header__item"><a id="total"
                                    class="filter__link filter__link--number">Attempts</a>

                            </div>
                            <div class="header__item"><a id="total"
                                    class="filter__link filter__link--number">Delivery
                                    Data</a>

                            </div>
                            <div class="header__item"><a id="total"
                                    class="filter__link filter__link--number">Delivery
                                    Boy</a>
                            </div>
                            <div class="header__item"><a id="total"
                                    class="filter__link filter__link--number">Sales</a>

                            </div>
                            @if (!Auth::user()->hasRole('Team Leader'))
                                <div class="header__item"><a id="total"
                                        class="filter_link filter_link--number">Action</a>
                                </div>
                            @endif
                            <div class="header__item mx-lg-auto"><a id="total"
                                    class="filter__link filter__link--number">Status</a>
                            </div>
                        </div>
                        <div class="table-content">
                            @forelse ($shippings as $shipp)
                                <div class="table-row ">
                                    <div class="table-data ">{{ $x++ }}</div>
                                    <div class="table-data">{{ $shipp->defaultname }}</div>
                                    <div class="table-data">+{{ $shipp->defaultphone }}</div>
                                    <div class="table-data">{{ $shipp->customer_address }}</div>
                                    <div class="table-data">{{ $shipp->cost }} EGP
                                    </div>
                                    <div class="table-data">{{ $shipp->delivery_status ?? '-' }}</div>
                                    <div class="table-data barPower">{{ $shipp->attempts }}/3
                                        <div class="power">
                                            <input type="hidden" value="{{ $shipp->attempts }}">
                                            <span class="red"></span>
                                            <span class="blue"></span>
                                            <span class="green"></span>
                                        </div>
                                    </div>
                                    <div class="table-data d-flex flex-column">
                                        <div>{{ $shipp->delivery_date }}</div>
                                        <div>{{ $shipp->time }}</div>
                                    </div>
                                    @php
                                        $lead = Lead::with('users')->find($shipp->lead_id);
                                    @endphp
                                    <div class="table-data">{{ $shipp?->users->first()->name ?? '-' }}</div>
                                    <div class="table-data">{{ $lead?->users->first()->name ?? '-' }}</div>



                                    @if (!Auth::user()->hasRole('Team Leader'))
                                        <div class="table-data flex-column">
                                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                                @if ($shipp->shipping_status == 'new' || $shipp->shipping_status == 'unsuccessful')
                                                    <button class="btnActionBlack" data-bs-toggle="modal"
                                                        data-bs-target="#shippingEdit{{ $shipp->id }}">Action</button>
                                                @else
                                                    <button class="btnActionBlack disabledcolor" data-bs-toggle="modal"
                                                        data-bs-target="#shippingEdit{{ $shipp->id }}"
                                                        disabled>Action</button>
                                                @endif
                                            @endif



                                            <button
                                                class="btnActionBlack {{ $shipp->shipping_delay->count() >= 3 ? 'disabledcolor' : '' }}"
                                                data-bs-toggle="modal" data-bs-target="#shippingDelay{{ $shipp->id }}"
                                                {{ $shipp->shipping_delay->count() >= 3 ? 'disabled' : '' }}>Delay</button>


                                        </div>
                                    @endif
                                    <div class="table-data progressTableData flex-column gap-2 mx-lg-auto">
                                        @if (!Auth::user()->hasRole('Viewer Admin'))
                                            <form action="{{ route('shippings.change_status', $shipp->id) }}"
                                                method="post">
                                                @csrf
                                                @switch($shipp->shipping_status)
                                                    @case('new')
                                                        <button class="btnProgress unclickable"> New </button>
                                                    @break

                                                    @case('in-progress')
                                                        @if (Auth::user()->hasRole('Team Leader'))
                                                            <button class="btnProgress unclickable" value="in-progress"> In
                                                                Progress
                                                            </button>
                                                        @else
                                                            <button class="btnProgress" name="btnStat" value="in-progress"> In
                                                                Progress
                                                            </button>
                                                        @endif
                                                    @break

                                                    @case('on-the-way')
                                                        @if (Auth::user()->hasRole('Team Leader'))
                                                            <button class="btnProgress unclickable" value="on-the-way"> On The
                                                                Way</button>
                                                        @else
                                                            <button class="btnProgress" name="btnStat" value="on-the-way"> On The
                                                                Way</button>
                                                        @endif
                                                    @break

                                                    @case('waiting-for-follow-up')
                                                        @if (Auth::user()->hasRole('Team Leader'))
                                                            <button class="btnProgress unclickable" type="button">
                                                                Waiting For Follow Up </button>
                                                        @else
                                                            <button class="btnProgress" id="waiting-for-follow-up"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#followup{{ $shipp->id }}" type="button"
                                                                @if (Auth::user()->hasRole('Shipping Operation')) disabled @endif>
                                                                Waiting For Follow Up
                                                            </button>
                                                        @endif



                                                        @push('modals')
                                                            {{-- modal 3 --}}
                                                            <div class="modal fade shippingModals" id="followup{{ $shipp->id }}"
                                                                tabindex="-1" aria-labelledby="followupLabel" aria-hidden="true">
                                                                <div class="modal-dialog ShippingForms succ">
                                                                    <form action="{{ route('shippings.change_status', $shipp->id) }}"
                                                                        method="post">
                                                                        @csrf

                                                                        <div class="modal-content">
                                                                            <div
                                                                                class="align-items-center d-flex justify-content-center modal-body">
                                                                                <button
                                                                                    class="succ btn rounded-pill success btn-sm mx-2 rounded"
                                                                                    name="btnStat" value="completed"
                                                                                    role="button">Successfully
                                                                                    Completed</button>
                                                                                @if ($shipp->attempts != 3)
                                                                                    <button
                                                                                        class="unSucc btn rounded-pill primary btn-sm mx-2 rounded"
                                                                                        name="btnStat"
                                                                                        value="unsuccessful-follw">Unsuccessful
                                                                                        Completion</button>
                                                                                @endif
                                                                                <button
                                                                                    class="succ btn rounded-pill danger btn-sm mx-2 rounded"
                                                                                    name="btnStat" value="returns-rejected">Returns
                                                                                    are
                                                                                    rejected</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endpush
                                                    @break

                                                    @case('completed')
                                                        <button class="btnProgress unclickable">Successfully Completed </button>
                                                    @break

                                                    @case('unsuccessful')
                                                        <button class="btnProgress unclickable" name="btnStat"
                                                            value="unsuccessful">
                                                            IN Progress
                                                            Again </button>
                                                    @break

                                                    @case('returns-rejected')
                                                        @if (Auth::user()->hasRole('Team Leader'))
                                                            <button class="btnProgress unclickable" value="returns-rejected"
                                                                type="button">
                                                                Returns are rejected </button>
                                                        @else
                                                            <button class="btnProgress" name="btnStat" value="returns-rejected"
                                                                id="returns-rejected" data-bs-toggle="modal"
                                                                data-bs-target="#returns-rejected{{ $shipp->id }}"
                                                                type="button">
                                                                Returns are rejected </button>
                                                        @endif
                                                        @push('modals')
                                                            {{-- modal 4 --}}
                                                            <div class="modal fade shippingModals reasonCanselModal"
                                                                id="returns-rejected{{ $shipp->id }}" tabindex="-1"
                                                                aria-labelledby="returns-rejectedLabel" aria-hidden="true">

                                                                <div class="modal-dialog ShippingForms succ">
                                                                    <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                                        alt="" srcset="">

                                                                    <div
                                                                        class="modal-content d-flex justify-content-center align-items-center p-5">
                                                                        <div class="reasonTitle">
                                                                            Reasons
                                                                        </div>
                                                                        <form
                                                                            action="{{ route('shippings.reason_reject', $shipp->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @php
                                                                                $selectedReasonId = $shipp->rejectShippingReasons->isNotEmpty()
                                                                                    ? $shipp->rejectShippingReasons->first()
                                                                                        ->id
                                                                                    : null;

                                                                                $other = $shipp->rejectShippingReasons->isNotEmpty()
                                                                                    ? $shipp->rejectShippingReasons->first()
                                                                                        ->pivot->other
                                                                                    : '';
                                                                            @endphp

                                                                            @foreach ($reject_resons as $reason)
                                                                                <div>
                                                                                    <input type="radio" name="reason_id"
                                                                                        value="{{ $reason->id }}"
                                                                                        id="reason{{ $reason->id }}"
                                                                                        {{ old('reason_id', $selectedReasonId) == $reason->id ? 'checked' : '' }}>
                                                                                    <label
                                                                                        for="reason{{ $reason->id }}">{{ $reason->reason }}</label>
                                                                                </div>
                                                                            @endforeach

                                                                            <div class="form-group">
                                                                                <label for="other">Other Reason:</label>
                                                                                <textarea id="other" name="other" class="form-control" placeholder="Please specify other reason...">{{ $other ?? null }}</textarea>
                                                                            </div>

                                                                            <div class="btnn">
                                                                                <button class="btn btn-dark" type="submit">Update
                                                                                    Reason</button>
                                                                            </div>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endpush
                                                    @break

                                                    @default
                                                @endswitch
                                            </form>
                                        @endif
                                        @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Shipping Operation'))
                                            <div class=""><img src="{{ asset('admin/images/icons/shipper5.png') }}"
                                                    alt="" srcset="" data-bs-toggle="modal"
                                                    data-bs-target="#Bolesaa{{ $shipp->id }}" type="button"></div>
                                        @endif
                                    </div>
                                </div>


                                @push('modals')
                                    {{-- modal 1 --}}
                                    <div class="modal fade shippingModals" id="shippingEdit{{ $shipp->id }}"
                                        tabindex="-1" aria-labelledby="shippingEditLabel" aria-hidden="true">
                                        <div class="modal-dialog ShippingForms in-progress modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <div class="title">Delivery Details</div>

                                                    <div class="disheader">
                                                        <div class="dot"></div>
                                                        <div class="dis">Product information</div>
                                                    </div>
                                                    <div class="cards">
                                                        <div class="headerCard">
                                                            <div class="logo"><img
                                                                    src="{{ asset('admin/images/icons/flash-cards.png') }}"
                                                                    alt=""></div>
                                                            <div class="numAndTxt">
                                                                <div class="num">{{ $shipp?->shipping_cards?->count() }}
                                                                </div>
                                                                <div class="txt">Total Card</div>
                                                            </div>
                                                        </div>

                                                        <div class="headerCard">
                                                            <div class="logo"><img
                                                                    src="{{ asset('admin/images/icons/flash-cards.png') }}"
                                                                    alt=""></div>
                                                            <div class="numAndTxt">
                                                                <div class="num">
                                                                    {{ $shipp->cost }} EGP
                                                                </div>
                                                                <div class="txt">Total price</div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="w-100">
                                                        @forelse($shipp?->shipping_cards as $card)
                                                        <form>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="customerName{{ $card->id }}">Card Name </label>
                                                                    <div class="form-control" id="customerName{{ $card->id }}">
                                                                        {{ $card->customer_name }}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="customerPhone{{ $card->id }}">Phone Number </label>
                                                                    <div class="form-control" id="customerPhone{{ $card->id }}">
                                                                        {{ $card->customer_phone }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        @empty
                                                        <div>No shipping cards available.</div>
                                                        @endforelse

                                                    </div>
                                                </div>
                                                @if ($shipp->shipping_status == 'new')
                                                    <form action="{{ route('shippings.save_delvery_boy', $shipp->id) }}"
                                                        method="post" class="">
                                                        <div class="modal-body">
                                                            <div class="disheader mb-2">
                                                                <div class="dot"></div>
                                                                <div class="dis">Check Delivery boy / Shipping Company</div>
                                                            </div>
                                                            <div class="selection">
                                                                <div class="row">
                                                                    @csrf
                                                                    @forelse ($delivryBoys as $boy)
                                                                        <div class="col-md-6">
                                                                            <div class="cardSelection ">
                                                                                <input type="radio" name="delviery_boys"
                                                                                    value="{{ $boy->id }}"
                                                                                    id="CardCheckbox{{ $shipp->id }}{{ $boy->id }}">
                                                                                <label class="m-0"
                                                                                    for="CardCheckbox{{ $shipp->id }}{{ $boy->id }}">
                                                                                    {{ $boy->name }} | {{ $boy->phone }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @empty
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center">
                                                                            <div>No Delivry Boys Exist.</div>
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn close"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn save">Save changes</button>
                                                        </div>
                                                    </form>
                                                @elseif ($shipp->shipping_status == 'unsuccessful')
                                                    <form action="{{ route('shippings.update_delvery_boy', $shipp->id) }}"
                                                        method="post" class="">
                                                        <div class="modal-body">
                                                            <div class="disheader mb-2">
                                                                <div class="dot"></div>
                                                                <div class="dis">Edit Delivery boy / Shipping Company</div>
                                                            </div>
                                                            <div class="selection">
                                                                <div class="row">
                                                                    @csrf
                                                                    @forelse ($delivryBoys as $boy)
                                                                        <div class="col-md-6">
                                                                            <div class="cardSelection ">
                                                                                <input type="radio" name="delviery_boys"
                                                                                    value="{{ $boy->id }}"
                                                                                    id="CardCheckbox{{ $shipp->id }}{{ $boy->id }}"
                                                                                    {{ $shipp->users[0]->id == $boy->id ? 'checked' : '' }}>
                                                                                <label class="m-0"
                                                                                    for="CardCheckbox{{ $shipp->id }}{{ $boy->id }}">
                                                                                    {{ $boy->name }} | {{ $boy->phone }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @empty
                                                                        <div
                                                                            class="d-flex justify-content-around align-items-center">
                                                                            <div>No Delivry Boys Exist.</div>
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn close"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn save">Update changes</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- modal 2 --}}
                                    <div class="modal fade shippingModalsBolesaa" id="Bolesaa{{ $shipp->id }}"
                                        tabindex="-1" aria-labelledby="BolesaaLabel" aria-hidden="true">
                                        <div class="modal-dialog ShippingForms">
                                            <div class="modal-content">
                                                <div class="modal-body">

                                                    <div class="logos">
                                                        <img src="{{ asset('admin/images/nassar.png') }}" />
                                                        <img src="{{ asset('admin/images/qr.png') }}" />
                                                    </div>
                                                    <div class="rewsetNum ">
                                                        <div>Shipper: Egypt</div>
                                                        <div>465635264524</div>
                                                    </div>
                                                    <div class="address borderRest">
                                                        <div>Company Z-Card</div>
                                                        <div>Address: October - Sheikh Zayed</div>
                                                    </div>
                                                    <div class="ToAndData borderRest">
                                                        <div>الي : مصر</div>
                                                        <div class="titles">ملومات المرسل اليه</div>
                                                        <div>الاسم: {{ $shipp->lead->name ?? '' }}</div>
                                                        <div>موبيل +{{ $shipp->lead->phone ?? ''}}</div>
                                                        @php
    $lead = Lead::with('addresses')->find($shipp->lead_id);
@endphp

@if ($lead && $lead->addresses->isNotEmpty())
    @forelse ($lead->addresses as $key => $address)
        <hr class="m-0">
        <div>
            <span>العنوان: {{ ++$key }}:
                {{ $address->address }}</span>
            | <span>مبني: {{ $address->building }}</span>
            | <span>الدور: {{ $address->floor }}</span>
            | <span>شقة رقم: {{ $address->flat_number }}</span>
            | <span>شارع: {{ $address->state }}</span>
            | <span>مدينة: {{ $address->city }}</span>
            | <span>علامة مميزه: {{ $address->landmark }}</span>
        </div>
        @empty
                                            <option>Address: No Address Exist</option>
                                        @endforelse
@else
    <div>Address: No Address Exist</div>
@endif

                                                    </div>

                                                    <div class="cash borderRest">
                                                        <div class="titles">معلومات النقدية</div>
                                                        <div>الكروت({{ $shipp?->shipping_cards?->count() }})</div>
                                                        <div>السعر: {{ $shipp->cost }} EGP
                                                        </div>
                                                    </div>

                                                    <div class="information borderRest">
                                                        <div class="titles">بيانات الشحنة</div>
                                                        <div>الاسم: {{ $shipp->defaultname ??''}}</div>
                                                        <div>موبيل: +{{ $shipp->defaultphone ??''}}</div>
                                                        <div>
                                                            <span>العنوان: {{ $address->address??'' }}</span>
                                                            | <span>مبني: {{ $address->building ??''}}</span>
                                                            | <span>الدور: {{ $address->floor??'' }}</span>
                                                            | <span>رقم الشقه: {{ $address->flat_number ??''}}</span>
                                                            | <span>شارع: {{ $address->state ??''}}</span>
                                                            | <span>مدينة: {{ $address->city??'' }}</span>
                                                            | <span>علامة مميزة: {{ $address->landmark??'' }}</span>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button role="button" type="submit"
                                                        class="btn print btnprint">Print</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    {{-- model 3 --}}
                                    <div class="modal fade" id="shippingDelay{{ $shipp->id }}" tabindex="-1"
                                        aria-labelledby="#Delay" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="codeConfirm">
                                                        <!-- start confirm printing form -->
                                                        <div class="animate__animated PrintingPlanForm ">
                                                            <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                                alt="">
                                                            <div class="container">
                                                                <form action="{{ route('Delay', $shipp->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="deal_id"
                                                                        value="{{ $shipp->deal_id }}">

                                                                    <h2>Make Delay</h2>
                                                                    <div class="form-row row mt-2">
                                                                        <div
                                                                            class="form-group col-md-12 doneBtn searchbyDates">
                                                                            <label class="m-0">Delay
                                                                                Time</label>

                                                                            <div class="conInput">
                                                                                <input type="date" name="delay_time"
                                                                                    id="deal_date_from"
                                                                                    value="{{ $dealDateFrom ?? null }}"
                                                                                    placeholder="Create Date From">
                                                                                <img src="{{ asset('admin/images/icons/calendar.png') }}"
                                                                                    alt="" srcset="">
                                                                            </div>
                                                                        </div>


                                                                        <div>
                                                                            <label for="reason" class="animate__animated">
                                                                                Reason for Delay:
                                                                                <textarea name="comment" rows="4" cols="25" style="width: 80%" require></textarea>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="btns mt-4">
                                                                        <div class="d-flex justify-content-center">
                                                                            <button type="submit"
                                                                                class="btn mx-4 dark">Accept</button>
                                                                            <button type="button" class="btn lite"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- end confirm printing form -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- model 4 --}}
                                    <div class="modal fade" id="Delay" tabindex="-1" aria-labelledby="#Delay"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="codeConfirm">
                                                        <!-- start confirm printing form -->
                                                        <div class="animate__animated PrintingPlanForm ">
                                                            <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                                alt="">
                                                            <div class="container p-4">
                                                                <table class="w-100 text-center">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Data</th>
                                                                            <th>Reason</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="tableData">
                                                                        @forelse ($shippings as $shipp)
                                                                            @if ($shipp->shipping_delay->isNotEmpty())
                                                                                @foreach ($shipp->shipping_delay as $delay)
                                                                                    <tr>
                                                                                        <td>{{ $shipp->defaultname }}</td>
                                                                                        <td>{{ $delay->date }}</td>
                                                                                        <td>{{ $delay->reason }}</td>
                                                                                        <td>{{ $delay?->status ?? 'Null' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="4">
                                                                                        No shipping Delay information available
                                                                                        for deal :
                                                                                        {{ $shipp->id }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endif


                                                                        @empty

                                                                            <tr>
                                                                                <td colspan="3">No Deals Exist</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- end confirm printing form -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endpush

                            @empty
                                <div class="d-flex justify-content-around align-items-center">
                                    <div>No Shippings Exist.</div>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pagination -->
        <nav aria-label="Page navigation example" class="pagination d-flex justify-content-around align-items-center">
            <ul class="pagination">
                {{ $shippings->links() }}
            </ul>
        </nav>
        <!-- end pagination -->
    </section>
    <!-- end DATA table -->
@endsection

@section('script')
    <script>
        function redirectToShippingPage() {
            var customerName = document.getElementById('customer_name').value.trim();
            var customerPhone = document.getElementById('customer_phone').value.trim();
            var location = document.getElementById('location').value.trim();
            var price = document.getElementById('price').value.trim();
            var delivery_status = document.getElementById('delivery_status').value.trim();
            var attempts = document.getElementById('attempts').value.trim();
            var delivery_date_from = document.getElementById('delivery_date_from').value.trim();
            var delivery_date_to = document.getElementById('delivery_date_to').value.trim();
            var delivery_boy = document.getElementById('delivery_boy').value.trim();
            var sales = document.getElementById('sales').value.trim();

            var newUrl = window.location.pathname;
            var params = [];

            if (customerName) {
                params.push('customer_name=' + encodeURIComponent(customerName));
            }
            if (customerPhone) {
                params.push('customer_phone=' + encodeURIComponent(customerPhone));
            }
            if (location) {
                params.push('location=' + encodeURIComponent(location));
            }
            if (price) {
                params.push('price=' + encodeURIComponent(price));
            }
            if (delivery_status) {
                params.push('delivery_status=' + encodeURIComponent(delivery_status));
            }
            if (attempts) {
                params.push('attempts=' + encodeURIComponent(attempts));
            }
            if (delivery_date_from) {
                params.push('delivery_date_from=' + encodeURIComponent(delivery_date_from));
            }
            if (delivery_date_to) {
                params.push('delivery_date_to=' + encodeURIComponent(delivery_date_to));
            }
            if (delivery_boy) {
                params.push('delivery_boy=' + encodeURIComponent(delivery_boy));
            }
            if (sales) {
                params.push('sales=' + encodeURIComponent(sales));
            }

            if (params.length > 0) {
                newUrl += '?' + params.join('&');
            } else {
                newUrl = '/shippings';
            }

            window.location.href = newUrl;
        }

        // Attach event listeners to both input fields

        document.getElementById('customer_name').addEventListener('keypress', function() {
            (event.key === 'Enter') ? redirectToShippingPage(): false;
        });

        document.getElementById('customer_phone').addEventListener('keypress', function() {
            (event.key === 'Enter') ? redirectToShippingPage(): false;
        });
        document.getElementById('location').addEventListener('keypress', function() {
            (event.key === 'Enter') ? redirectToShippingPage(): false;
        });
        document.getElementById('price').addEventListener('keypress', function(event) {
            (event.key === 'Enter') ? redirectToShippingPage(): false;
        });
        document.getElementById('delivery_status').addEventListener('change', function(event) {
            redirectToShippingPage();
        });
        document.getElementById('attempts').addEventListener('change', function(event) {
            redirectToShippingPage();
        });
        document.getElementById('delivery_date_from').addEventListener('change', function(event) {
            redirectToShippingPage();
        });
        document.getElementById('delivery_date_to').addEventListener('change', function(event) {
            redirectToShippingPage();
        });
        document.getElementById('delivery_boy').addEventListener('change', function(event) {
            redirectToShippingPage();
        });
        document.getElementById('sales').addEventListener('change', function(event) {
            redirectToShippingPage();
        });
    </script>
    <script>
        $('#shipping').addClass('sidebar_active rounded-pill');
    </script>
@endsection
