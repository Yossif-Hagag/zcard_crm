@php
use App\Models\Address;
@endphp
@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')

@section('titlePage')
    Manage Management System
@endsection

@section('style')
    <style>
        .table-data,
        .header__item {
            flex: 1 1 0% !important;
            text-align: center;
            position: relative;
            white-space: nowrap;
        }

        .black {
            width: 50%;
            background-color: black;
            border-radius: 12px;
            font-size: small;
            color: white;
            transition: 1s;
        }
    </style>
@endsection
@section('path')
    <span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashboard</a> <i
            class="fa-solid fa-chevron-right"></i></span>
    <span><a class="text-decoration-none text-body" href="{{ route('renew.index') }}">Renew</a> <i
            class="fa-solid fa-chevron-right"></i></span>
@endsection

@section('content')
    <!-- DATA table -->
    <section class="section3 PrintingPage RenewPage">
        <div class="tableData  ">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <div class="">
                <!-- Customer data -->
                <div class="customerData">
                    <div class="titles">
                        <h5 class="fw-bold">Renew Plan</h5>
                    </div>
                </div>

                <div class="table">
                    <div class="table-header">
                        <div class="header__item"><a id="name" class="filter__link">Recipient</a></div>
                        <div class="header__item"><a id="name" class="filter__link">Mobile</a></div>
                        <div class="header__item"><a id="wins" class="filter__link filter__link--number">Card</a></div>
                        <div class="header__item"><a id="wins" class="filter__link filter__link--number">Renew Time</a>
                        </div>
                        <div class="header__item"><a id="draws" class="filter__link filter__link--number">New Price</a>
                        </div>
                        <div class="header__item"><a id="total" class="filter__link filter__link--number ">Shipping
                                Address</a></div>
                        <div class="header__item"><a href="#" class="filter__link filter__link--number ">Renew</a>
                        </div>
                    </div>

                    <div class="table-content">
                        @forelse ($renews as $renew)
                            <div class="table-row">
                                <div class="table-data">{{ $renew->defaultname }}</div>
                                <div class="table-data">{{ $renew->defaultphone }}</div>

                                <div class="table-data">
                                    @if ($renew->deal_cards->isNotEmpty())
                                        <div class="tdContent">{{ $renew->deal_cards->first()->card_name }}</div>
                                    @else
                                        <span>No Card</span>
                                    @endif
                                </div>

                                {{-- @php
                                $firstRenew = $renew;
                                $oneYearLater = null;
                                $isPassed = false;
                                if ($firstRenew->created_at) {
                                    $createdAt = \Carbon\Carbon::parse($firstRenew->created_at);
                                    $oneYearLater = $createdAt->addYear();
                                    $isLessThanOneMonthToExpire = now()->greaterThanOrEqualTo($oneYearLater->subMonth()) ;
                                }
                            @endphp
                            <div class="table-data" style="color: {{  $isLessThanOneMonthToExpire   ? 'red' : 'black' }};">
                                {{ $oneYearLater ? $oneYearLater->format('Y-m-d H:i:s') : '-' }}
                            </div> --}}

                                @php
                                    $firstRenew = $renew;
                                    $oneYearLater = null;
                                    $isLessThanOneMonthToExpire = false;

                                    if ($firstRenew->delivery_date) {
                                        $createdAt = \Carbon\Carbon::parse($firstRenew->delivery_date);
                                        $oneYearLater = $createdAt->copy()->addYear(); // استخدم copy لتجنب تعديل $createdAt الأصلي
                                        // تحقق مما إذا كان التاريخ أقل من شهر من انتهاء المدة
                                        $isLessThanOneMonthToExpire = now()->greaterThanOrEqualTo(
                                            $oneYearLater->subMonth(),
                                        );
                                    }
                                @endphp

                                <div class="table-data" style="color: {{ $isLessThanOneMonthToExpire ? 'red' : 'black' }};">
                                    {{ $firstRenew->delivery_date ? \Carbon\Carbon::parse($firstRenew->delivery_date)->format('Y-m-d H:i:s') : '-' }}
                                </div>


                                <div class="table-data">EGP{{ $renew->cost }}</div>

                                @php
                                $address = Address::where('id',$renew->customer_address)->first();
                                @endphp
                                <div class="table-data">{{ $address->state ?? '' }}</div>

                                <div class="table-data">

                                    @php

                                        $lastRenew = $renew->renews->last();
                                        $disableButton = false;

                                        if ($lastRenew && $lastRenew->renew_time) {
                                            $renewDate = Carbon::parse($lastRenew->renew_time);
                                            $disableButton = $renewDate->diffInDays(Carbon::now()) >= 30;
                                        }
                                    @endphp

                                    <button name="Renew"
                                        class="bulid renewCreate btnActionBlack {{ $isLessThanOneMonthToExpire ? '' : 'disabledcolor' }}"
                                        {{ $isLessThanOneMonthToExpire ? '' : 'disabled' }}>
                                        Renew
                                    </button>
                                    @push('modals')
                                        {{-- <div class="modal fade" id="Renew{{ $renew->id }}" tabindex="-1"
                                            aria-labelledby="shippingEditLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="codeConfirm">
                                                            <!-- Start confirm printing form -->
                                                            <div class="animate__animated PrintingPlanForm">
                                                                <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                                    alt="">
                                                                <div class="container">
                                                                    <form action="{{ route('renew.store') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="lead_id"
                                                                            value="{{ $renew->lead->id }}">
                                                                        <input type="hidden" name="dealRenew"
                                                                            value="{{ $renew->id }}">
                                                                        <h2>Create Deal</h2>
                                                                        <div class="header">
                                                                            <div class="HeaderCard">
                                                                                <div class="icon"><img
                                                                                        src="{{ asset('admin/images/icons/credit-card1.png') }}"
                                                                                        alt=""></div>
                                                                                <div class="contents">
                                                                                    <div class="title">
                                                                                        <select class="form-control"
                                                                                            name="card_name" id="keyupForNum">
                                                                                            <option selected>Select Card
                                                                                            </option>

                                                                                            @foreach ($cards as $card)
                                                                                                <option
                                                                                                    value="{{ $card->id }}"
                                                                                                    data-cost="{{ $card->cost }}"
                                                                                                    data-name="{{ $card->customer_name }}"
                                                                                                    data-phone="{{ $card->customer_phone }}">
                                                                                                    {{ $card->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="content">Cards</div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="HeaderCard">
                                                                                <div class="icon"><img
                                                                                        src="{{ asset('admin/images/icons/finance1.png') }}"
                                                                                        alt="">
                                                                                </div>
                                                                                <div class="contents">
                                                                                    <div class="title"><span
                                                                                            id="cardCost">0</span>
                                                                                        EGP</div>
                                                                                    <div class="content">Total price</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <h3>Customer Data</h3>
                                                                        <div class="cardHeader">
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="defaultname">Customer
                                                                                        Name</label>
                                                                                    <div class="input-group">
                                                                                        <input name="defaultname"
                                                                                            type="text"
                                                                                            class="form-control"
                                                                                            id="defaultname"
                                                                                            placeholder="please enter data">
                                                                                        <div class="input-group-append">

                                                                                            <span class="input-group-text"
                                                                                                onclick="populateInput('defaultname', '{{ $renew->lead->name }}')">
                                                                                                <i class="fas fa-user "></i>

                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="defaultphone">Customer Phone
                                                                                        Number</label>
                                                                                    <div class="input-group">
                                                                                        <input name="defaultphone"
                                                                                            type="text"
                                                                                            class="form-control"
                                                                                            id="defaultphone"
                                                                                            placeholder="please enter data">
                                                                                        <div class="input-group-append">

                                                                                            <span class="input-group-text"
                                                                                                onclick="populateInput('defaultphone', '{{ $renew->lead->phone }}')">
                                                                                                <i class="fas fa-phone "></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <script>
                                                                            function populateInput(inputId, value) {
                                                                                document.getElementById(inputId).value = value;
                                                                            }
                                                                        </script>

                                                                        <hr>
                                                                        <div id="customerDataContainer">
                                                                            <div class="customer-data-entry">
                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md-6">
                                                                                        <label for="inputName">Card
                                                                                            Name</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            name="customer_name[]"
                                                                                            placeholder="Please enter data"
                                                                                            required>
                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <label for="inputPhone">Card
                                                                                            Phone</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            name="customer_phone[]"
                                                                                            placeholder="Please enter data"
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                        <button type="button" id="addCustomerButton"
                                                                            class="btn btn-secondary">Add Another Card
                                                                            Data</button>

                                                                        <div class="Formline">
                                                                            <div></div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="EXAddress col-12">
                                                                                <span class="icon"><i
                                                                                        class="fa-solid fa-chevron-down"
                                                                                        style="color: #ffffff;"></i></span>
                                                                                <select name="address" id="address"
                                                                                    class="form-select"
                                                                                    aria-label="Default select example"
                                                                                    required>
                                                                                    @foreach ($renew->lead->addresses as $address)
                                                                                        <option value="{{ $address->state }}">
                                                                                            {{ $address->address . ' - ' . $address->state }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="cost" id="cost"
                                                                            value="{{ $cards[0]->cost }}">

                                                                        <div class="row date">
                                                                            <div class="orderDate col-md-6">
                                                                                <div class="mainCardd">
                                                                                    <div class="title">Date of receipt</div>
                                                                                    <div class="card1">
                                                                                        <div class="inputAndValue">
                                                                                            <div class="enter">Date of receipt
                                                                                            </div>
                                                                                            <input type="date"
                                                                                                name="date_of_receipt"
                                                                                                id="Calendar"
                                                                                                style="background: #faebd700 url('{{ asset('admin/images/icons/calendar.png') }}');"
                                                                                                required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="orderDate col-md-6">
                                                                                <div class="mainCardd">
                                                                                    <div class="title">Time of receipt</div>
                                                                                    <div class="card1">
                                                                                        <div class="inputAndValue">
                                                                                            <div class="enter">Time of receipt
                                                                                            </div>
                                                                                            <input type="time"
                                                                                                name="time" id="Calendar"
                                                                                                style="background: #faebd700 url('{{ asset('admin/images/icons/clock.png') }}');"
                                                                                                required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="btns">
                                                                            <button type="submit"
                                                                                class="btn dark">Accept</button>
                                                                            <button type="button"
                                                                                class="btn lite">Close</button>
                                                                        </div>
                                                                </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- End confirm printing form -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="bg-mian-dark animate__animated AddOrders renewCard">

                                            <div class="cickMe"></div>
                                            <div class="addForm container">
                                                <div class="cickMe"></div>
                                                <form action="{{ route('renew.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="finalPrice" name="finalPrice" value="{{$renew->cost}}">
                                              
                                                    <input type="hidden" name="dealRenew"
                                                    value="{{ $renew->id }}">
                                                    <input type="hidden" name="lead_id" value="{{ $renew->lead->id }}">
                                                    <h2>Edit Deal</h2>
                                                    <div class="header">
                                                        <div class="HeaderCard"> 

                                                            <div class="icon"><img
                                                                    src="{{ asset('admin/images/icons/credit-card1.png') }}"
                                                                    alt=""></div>
                                                            <div class="contents">
                                                                <div class="title">
                                                                    <select class="form-control" name="card_name"
                                                                        id="keyupForNum" required>
                                                                        <option value="" disabled selected>Select
                                                                            Card</option>

                                                                        @foreach ($cards as $card)
                                                                            <option value="{{ $card->id }}"
                                                                                data-cost="{{ $card->cost }}"
                                                                                data-name="{{ $card->customer_name }}"
                                                                                data-phone="{{ $card->customer_phone }}"
                                                                                @if (old('card_name') == $card->id ||
                                                                                        ($renew->deal_cards->isNotEmpty() && $renew->deal_cards->first()->card_name == $card->name)) selected @endif>
                                                                                {{ $card->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="content">Cards</div>
                                                            </div>
                                                        </div>
                                                        <div class="HeaderCard">
                                                            <div class="icon"><img
                                                                    src="{{ asset('admin/images/icons/finance1.png') }}"
                                                                    alt="">
                                                            </div>
                                                            <div class="contents">
                                                                <div class="title"><span class="cardCost"
                                                                        custom-attr="">{{ $renew->cost ?? '0' }}</span> EGP
                                                                </div>
                                                                <div class="content">Total price</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h3>Customer Data</h3>
                                                    <div class="cardHeader">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="defaultname">Customer Name</label>
                                                                <div class="input-group">
                                                                    <input name="defaultname" type="text"
                                                                        class="form-control" id="defaultname"
                                                                        placeholder="please enter data"
                                                                        value="{{ old('defaultname', $renew->defaultname ?? '') }}">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"
                                                                            onclick="populateInput('defaultname', '{{ $renew->name }}')">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label for="defaultphone">Customer Phone Number</label>
                                                                <div class="input-group">
                                                                    <input name="defaultphone" type="text"
                                                                        class="form-control" id="defaultphone"
                                                                        placeholder="please enter data"
                                                                        value="{{ old('defaultphone', $renew->defaultphone ?? '') }}">
                                                                    <div class="input-group-append">

                                                                        <span class="input-group-text"
                                                                            onclick="populateInput('defaultphone', '{{ $renew->phone }}')">
                                                                            <i class="fas fa-phone "></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        function populateInput(inputId, value) {
                                                            document.getElementById(inputId).value = value;
                                                        }
                                                    </script>

                                                    <hr>
                                                    <div id="customerDataContainer">
                                                        <div class="customer-data-entry coustemID-{{ $renew->id }}">
                                                            <input type="hidden" class="valOfCustomID"
                                                                value="coustemID-{{ $renew->id }}">
                                                            <div class="form-row">
                                                                @foreach ($renew->deal_cards as $deal_card)
                                                                    <div class="form-group col-md-6">
                                                                        <label for="customerName{{ $deal_card->id }}">Card
                                                                            Name</label>
                                                                        <input type="text" class="form-control"
                                                                            name="customer_name[]"
                                                                            placeholder="Please enter data"
                                                                            value="{{ old('customer_name.' . $loop->index, $deal_card->customer_name) }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="customerPhone{{ $deal_card->id }}">Card
                                                                            Phone</label>
                                                                        <input type="text" class="form-control"
                                                                            name="customer_phone[]"
                                                                            placeholder="Please enter data"
                                                                            value="{{ old('customer_phone.' . $loop->index, $deal_card->customer_phone) }}"
                                                                            required>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary addCustomerButton">Add
                                                        Another Card Data</button>

                                                    <div class="Formline">
                                                        <div></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="EXAddress col-12">
                                                            <span class="icon"><i class="fa-solid fa-chevron-down"
                                                                    style="color: #ffffff;"></i></span>
                                                            <select name="address" id="address" class="form-select"
                                                                aria-label="Default select example" required>

                                                                @if ($renew->lead && $renew->lead->addresses && $renew->lead->addresses->isNotEmpty())
                                                                    @foreach ($renew->lead->addresses as $address)
                                                                        <option value="{{ $address->id }}"
                                                                            @if ($renew->customer_address == $address->state) selected @endif>
                                                                            {{ $address->address . ' - ' . $address->state }}
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No addresses available</option>
                                                                @endif



                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="cost" id="cost"
                                                        value="{{ $cards[0]->cost }}">

                                                    <div class="row date">
                                                        <div class="orderDate col-md-6">
                                                            <div class="mainCardd">
                                                                <div class="title">Date of receipt</div>
                                                                <div class="card1">
                                                                    <div class="inputAndValue">
                                                                        <div class="enter">Date of receipt</div>
                                                                        <input type="date" name="date_of_receipt"
                                                                            id="Calendar"
                                                                            style="background: #faebd700 url('{{ asset('admin/images/icons/calendar.png') }}');"
                                                                            required
                                                                            value="{{ old('date_of_receipt', $renew->delivery_date->format('Y-m-d') ?? '') }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="orderDate col-md-6">
                                                            <div class="mainCardd">
                                                                <div class="title">Time of receipt</div>
                                                                <div class="card1">
                                                                    <div class="inputAndValue">
                                                                        <div class="enter">Time of receipt</div>
                                                                        <input type="time" name="time" id="Calendar"
                                                                            style="background: #faebd700 url('{{ asset('admin/images/icons/clock.png') }}');"
                                                                            required
                                                                            value="{{ old('time', isset($deal->time) ? \Carbon\Carbon::parse($deal->time)->format('H:i') : '') }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="btns">
                                                        <button type="submit" class="btn dark">Accept</button>
                                                        <button type="button" class="btn lite">Close</button>
                                                    </div>
                                            </div>

                                            </form>



                                        </div>
                                    @endpush

                                </div>
                            </div>



                        @empty
                            <div class="d-flex justify-content-around align-items-center">
                                <div>No Renew Exists.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation example" class="pagination d-flex justify-content-around align-content-around">
            <ul class="pagination">
                {{ $renews->links() }}
            </ul>
        </nav>
        <!-- End pagination -->
    </section>
    <!-- End DATA table -->
@endsection
