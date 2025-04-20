@php
use App\Models\Address;
@endphp
@extends('layouts.app')
@section('titlePage')
Manage Management System
@endsection
@section('path')
<span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
        class="fa-solid fa-chevron-right"></i></span>
<span><a class="text-decoration-none text-body" href="{{ route('deals.index') }}">Deals</a> <i
        class="fa-solid fa-chevron-right"></i></span>
@endsection
@section('style')
<style>
    .black {
        width: 50%;
        background-color: black;
        border-radius: 12px;
        font-size: small;
        color: white;
        transition: 1s;
    }

    .cancel {
        background-color: rgb(117 8 21);
        color: white;
    }

    .not_answered {
        background-color: yellow !important;
    }
</style>
@endsection

@section('search')
<form class="fromMainSearch">
    <div class="input-group-append">
        <button type="submit" class="btn btn-primary">
            <i class="icon ion-md-search"></i>
        </button>
    </div>
    <div class="input-group">
        <input id="indexSearch" type="text" name="search" placeholder="{{ __('crud.common.search') }}"
            value="{{ $search ?? '' }}" class="form-control" autocomplete="off" />

    </div>
</form>
@endsection

@section('content')
<main class="TableLead dealsPage">
    <div class="">
        <div class="searchbyDates ">
            <div class="Fillter ">Fillter: </div>
            <div class="ReceiptDateTo animate__animated">
                <div class="d-flex gap-2">
                    <div class="from">From</div>
                    <div class="conInput">
                        <input type="date" name="deal_date_from" id="deal_date_from"
                            value="{{ $dealDateFrom ?? null }}" placeholder="Create Date From">
                        <img src="{{ asset('admin/images/icons/calendar.png') }}" alt="" srcset="">
                    </div>
                    <div class="to">To</div>
                    <div class="conInput">
                        <input type="date" name="deal_date_to" id="deal_date_to" value="{{ $dealDateTo ?? null }}"
                            placeholder="Create Date To">
                        <img src="{{ asset('admin/images/icons/calendar.png') }}" alt="" srcset="">
                    </div>
                </div>
            </div>
            <div class="DealDateTo animate__animated">
                <div class="d-flex gap-2">
                    <div class="from">From</div>
                    <div class="conInput">
                        <input type="date" name="receipt_date_from" id="receipt_date_from"
                            value="{{ $receiptDateFrom ?? null }}" placeholder="Create Date From">
                        <img src="{{ asset('admin/images/icons/calendar.png') }}" alt="" srcset="">
                    </div>
                    <div class="to">To</div>
                    <div class="conInput">
                        <input type="date" name="receipt_date_to" id="receipt_date_to"
                            value="{{ $receiptDateTo ?? null }}" placeholder="Create Date To">
                        <img src="{{ asset('admin/images/icons/calendar.png') }}" alt="" srcset="">
                    </div>
                </div>
            </div>

            <div class="">
                <select name="" id="" class="">
                    <option value="">Deal Date</option>
                    <option value="">Receipt Date</option>
                </select>
            </div>
        </div>
        <!-- DATA table -->
        <section class="section3">
            <div class="tableData">
                <!-- Customer data -->
                <div class="customerData">
                    <div class="titles">
                        {{-- <h5 class="mx-5 fw-bold">Customer data</h5> --}}
                        <h5 class="px-3 fw-bold">Shipping Data</h5>
                    </div>
                    <div class="test">
                        <div class="half-arc" style="--percentage:{{ $dealsTotal }}%;">
                            <span class="label">{{ $dealsTotal }}</span>
                            <span class="label2">Total Deals</span>
                        </div>

                        <div class="half-arc" style="--percentage:{{ $dealsConfirmed }}%;">
                            <span class="label">{{ $dealsConfirmed }}</span>
                            <span class="label2">Confirmed</span>
                        </div>

                        <div class="half-arc" style="--percentage:{{ $dealsPending }}%;">
                            <span class="label">{{ $dealsPending }}</span>
                            <span class="label2">Pending</span>
                        </div>

                    </div>

                </div>
                <!-- Customer data -->
                <div class="tableEdit">
                    <table class="table">

                        <thead>
                            <tr>
                                <th scope="col">Recipient</th>
                                <th scope="col">Mobile </th>
                                <th scope="col">Card</th>
                                <th scope="col">Price</th>
                                <th scope="col">Card name</th>
                                <th scope="col">Shipping Address</th>
                                <th scope="col" class="text-left">
                                    <div class="d-flex flex-column align-items-center">
                                        <div>Deal Date</div>

                                    </div>
                                </th>
                                <th scope="col" class="text-left">
                                    <div class="d-flex flex-column align-items-center">
                                        <div>Receipt Date</div>

                                    </div>
                                </th>
                                <th scope="col">Sales</th>
                                <th scope="col">View</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Action</th>
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
                                <td>
                                    <div class="tdContent">
                                        @if ($deal->deal_cards->isNotEmpty())
                                        <div class="tdContent">{{ $deal->deal_cards->first()->card_name }}
                                        </div>
                                        @else
                                        <span>No Card</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="tdContent">EGP{{ $deal->cost }}</div>
                                </td>
                                <td>
                                    <div class="tdContent">{{ $deal->deal_cards()->first()->customer_name ??'' }}</div>
                                </td>
                                @php
                                $address = Address::where('id',$deal->customer_address)->first();
                                @endphp
                                <td>
                                    <div class="tdContent">{{ $address?$address->state:'' }}</div>
                                </td>
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
                                @if ($deal->lead && $deal->lead->users->count() > 0)
                                <td data-bs-toggle="modal" data-bs-target="#userModal{{ $deal->id }}"
                                    style="cursor: pointer">
                                    {{ $deal?->lead?->users->first()->name ?? '-' }}
                                </td>
                                @else
                                <td>{{ $deal?->lead?->users->first()->name ?? '-' }}</td>
                                @endif

                                @can('view deals')
                                <td class="viewDis" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $deal->id }}">
                                    <img src="{{ asset('admin/images/icons/view.png') }}" alt="">
                                </td>
                                @endcan

                                @can('edit deals')
                                <td class="viewDis editDealsBtn">
                                    <img src="{{ asset('admin/images/icons/edit.png') }}" alt="">
                                </td>

                                @push('modals')
                                <div class="bg-mian-dark animate__animated AddOrders editDealsModals">

                                    <div class="cickMe"></div>
                                    <div class="addForm container">
                                        <div class="cickMe"></div>
                                        <form action="{{ route('deals.update', $deal->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="lead_id" value="{{ $deal->lead->id ?? '' }}">

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
                                                                    @if (old('card_name')==$card->id ||
                                                                    ($deal->deal_cards->isNotEmpty() && $deal->deal_cards->first()->card_name == $card->name)) selected @endif>
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
                                                                custom-attr="">{{ $deal->cost ?? '0' }}</span> EGP
                                                        </div>
                                                        <input type="hidden" class="finalPrice" name="finalPrice"  value="{{$deal->cost}}">
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
                                                                value="{{ old('defaultname', $deal->defaultname ?? '') }}">
                                                            <div class="input-group-append">
                                                            <span class="input-group-text"
      onclick="populateInput('defaultname', {{ json_encode($deal->name ?? '') }})">
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
                                                                value="{{ old('defaultphone', $deal->defaultphone ?? '') }}">
                                                            <div class="input-group-append">

                                                                <span class="input-group-text"
                                                                    onclick="populateInput('defaultphone', '{{ $deal->phone }}')">
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
                                                <div class="customer-data-entry coustemID-{{ $deal->id }}">
                                                    <input type="hidden" class="valOfCustomID"
                                                        value="coustemID-{{ $deal->id }}">

                                                    {{-- <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="inputName">Card Name</label>
                                                                            <input type="text" class="form-control"
                                                                                name="customer_name[]"
                                                                                placeholder="Please enter data"
                                                                                value="{{ old('customer_name[]', $deal->lead->name ?? '') }}"
                                                    required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPhone">Card Phone</label>
                                                    <input type="text" class="form-control"
                                                        name="customer_phone[]"
                                                        placeholder="Please enter data"
                                                        value="{{ old('customer_phone[]', $deal->customer_phone ?? '') }}"
                                                        required>
                                                </div>
                                            </div> --}}

                                            @foreach ($deal->deal_cards as $deal_card)
                                            <div class="form-row ">
                                                <div class="form-group col-md-6 customInputsCards">
                                                    <label for="customerName{{ $deal_card->id }}">Card
                                                        Name</label>
                                                    <input type="text" class="form-control"
                                                        name="customer_name[]"
                                                        placeholder="Please enter data"
                                                        value="{{ old('customer_name.' . $loop->index, $deal_card->customer_name) }}"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label
                                                        for="customerPhone{{ $deal_card->id }}">Card
                                                        Phone</label>
                                                    <input type="text" class="form-control"
                                                        name="customer_phone[]"
                                                        placeholder="Please enter data"
                                                        value="{{ old('customer_phone.' . $loop->index, $deal_card->customer_phone) }}"
                                                        required>
                                                </div>
                                            </div>
                                            @endforeach

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

                                            @if ($deal->lead && $deal->lead->addresses && $deal->lead->addresses->isNotEmpty())
                                            @foreach ($deal->lead->addresses as $address)
                                            <option value="{{ $address->id }}"
                                                @if ($deal->customer_address == $address->state) selected @endif>
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
                                                        value="{{ old('date_of_receipt', $deal->delivery_date->format('Y-m-d') ?? '') }}">
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
                                                    <input type="time" name="time"
                                                        id="Calendar"
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

            {{-- end --}}
            @endcan





            <td class="action">
                @if (!Auth::user()->hasRole('Viewer Admin'))
                <div class="tdContent">
                    @php

                    $varcss = '';
                    if ($deal->status == 'canceled') {
                    $varcss = 'cancel';
                    }
                    if ($deal->status == 'not answered') {
                    $varcss = 'not_answered';
                    }
                    @endphp

                    <button name="status_id" value="2" data-bs-toggle="modal"
                        data-bs-target="#shippingEdit{{ $deal->id }}"
                        class="bulid {{ $varcss }}">
                        {{ $deal->status }}
                    </button>

                    @push('modals')
                    <div class="modal fade dealconfirmStatus"
                        id="shippingEdit{{ $deal->id }}" tabindex="-1"
                        aria-labelledby="shippingEditLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="codeConfirm">
                                        <!-- start confirm printing form -->
                                        <div class="animate__animated PrintingPlanForm">
                                            <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                alt="">
                                            <div class="container">
                                                <form
                                                    action="{{ route('deals.updateStatus', $deal->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <h2>Enter Status</h2>
                                                    <div class="form-row row mt-2">
                                                        <div
                                                            class="form-group col-md-12 doneBtn">
                                                            <input type="radio"
                                                                name="cancelOrDone"
                                                                value="done"
                                                                id="inputDone{{ $deal->id }}"
                                                                required>
                                                            <label class="m-0"
                                                                for="inputDone{{ $deal->id }}">Done</label>
                                                        </div>

                                                        <div
                                                            class="form-group col-md-12 cancelBtn">
                                                            <input type="radio"
                                                                name="cancelOrDone"
                                                                value="cancel"
                                                                id="inputCancel{{ $deal->id }}"
                                                                required
                                                                {{ $deal->status == 'canceled' ? 'checked' : '' }}>
                                                            <label class="m-0"
                                                                for="inputCancel{{ $deal->id }}">Cancel</label>
                                                        </div>
                                                        @if ($deal->status == 'canceled')
                                                        @section('script')
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#inputDone{{ $deal->id }}')
                                                                    .click();
                                                                $('#inputCancel{{ $deal->id }}')
                                                                    .click();
                                                            });
                                                        </script>
                                                        @endsection
                                                        @endif


                                                        <div class="form-group col-md-12 textareaForm"
                                                            id="cancellationReason{{ $deal->id }}"
                                                            style="display: none;">
                                                            <label for="reason"
                                                                class="animate__animated">
                                                                Reason for cancellation:
                                                                <textarea name="comment" id="reason" rows="4" cols="25" style="width: 80%">{{ $deal->comment }}</textarea>
                                                            </label>
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <input type="radio"
                                                                name="cancelOrDone"
                                                                value="not answered"
                                                                id="inputNotAnswered{{ $deal->id }}"
                                                                required
                                                                {{ $deal->status == 'not answered' ? 'checked' : '' }}>
                                                            <label class="m-0"
                                                                for="inputNotAnswered{{ $deal->id }}">Not
                                                                Answered</label>
                                                        </div>


                                                    </div>

                                                    <div class="btns mt-4">
                                                        <div
                                                            class="d-flex justify-content-center">
                                                            <button type="submit"
                                                                class="btn mx-4 black">Accept</button>
                                                            <button type="button"
                                                                class="btn lite"
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

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const cancelRadio = document.getElementById(
                                'inputCancel{{ $deal->id }}');
                            const doneRadio = document.getElementById(
                                'inputDone{{ $deal->id }}');
                            const notAnsRadio = document.getElementById(
                                'inputNotAnswered{{ $deal->id }}');
                            const cancellationReason = document.getElementById(
                                'cancellationReason{{ $deal->id }}');

                            // Initially hide the cancellation reason
                            cancellationReason.style.display = 'none';

                            // Show cancellation reason if 'Cancel' is selected
                            cancelRadio.addEventListener('change', function() {
                                if (cancelRadio.checked) {
                                    cancellationReason.style.display = 'block';
                                }
                            });

                            // Hide cancellation reason if 'Done' is selected
                            doneRadio.addEventListener('change', function() {
                                if (doneRadio.checked) {
                                    cancellationReason.style.display = 'none';
                                }
                            });
                            notAnsRadio.addEventListener('change', function() {
                                if (notAnsRadio.checked) {
                                    cancellationReason.style.display = 'none';
                                }
                            });
                        });
                    </script>
                    @endpush
                    {{-- </form> --}}

                    {{-- <div>
                                                        <form action="{{ route('deals.destroy', $deal->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this deal?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: none; border: none; padding: 0;">
                        <img src="{{ asset('admin/images/icons/delete.png') }}" alt="Delete">
                    </button>
                    </form>
                </div> --}}
    </div>
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
    <div class="pagination d-flex justify-content-around align-content-around">
        {{ $deals->links() }}
    </div>
    </div>
    <!-- pagination -->
    <!-- end pagination -->
    </div>
    </section>
    <!-- end DATA table -->

    </div>
</main>
</div>
@endsection

@forelse($deals as $deal)
<div class="modal fade tableDataForm dealsForm" id="exampleModal{{ $deal->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel{{ $deal->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="CardTitle">Total Card</div>
                <div class="customer">
                    <div class="customerNameAndNum">
                        <div class="imag"><img src="{{ asset('admin/images/icons/id-card.png') }}"
                                alt=""></div>
                        <div class="titleAndDis">
                            <div class="title">Customer Name</div>
                            <div class="dis">{{ $deal->lead->name  ??''}}</div>
                        </div>
                    </div>
                    <div class="customerNameAndNum">
                        <div class="imag"><img src="{{ asset('admin/images/icons/user.png') }}"
                                alt=""></div>
                        <div class="titleAndDis">
                            <div class="title">Customer Number</div>
                            <div class="dis">+{{ $deal->lead->phone ??'' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="shippingData">
                    <div class="Stitle">Shipping Data</div>
                    <div class="shippingCards">
                        <div class="cards">
                            <div class="image"><img src="{{ asset('admin/images/icons/parcel.png') }}"
                                    alt=""></div>
                            <div class="titleAndDis">
                                <div class="title">Recipient</div>
                                <div class="dis">{{ $deal->defaultname ?? ''}}</div>
                            </div>
                        </div>
                        <div class="cards">
                            <div class="image"><img src="{{ asset('admin/images/icons/phone-call.png') }}"
                                    alt=""></div>
                            <div class="titleAndDis">
                                <div class="title">Mobile</div>
                                <div class="dis">+{{ $deal->defaultphone ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="address">
                    <div class="word">Address:</div>
                    <div class="content">{{ $deal->customer_address ?? '' }}</div>
                </div>
                <div class="midSection row">
                    <div class="col-md-4">
                        <div class="cards">
                            <div class="image"><img src="{{ asset('admin/images/icons/Frame1564.png') }}"
                                    alt=""></div>
                            <div class="titleAndDis">
                                <div class="title">{{ $deal?->deal_cards?->count() }}</div>
                                <div class="dis">Number card</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cards">
                            <div class="image"><img src="{{ asset('admin/images/icons/Group100.png') }}"
                                    alt=""></div>
                            <div class="titleAndDis">
                                <div class="title">{{ $deal->cost * $deal?->deal_cards?->count() }}EGP</div>
                                <div class="dis">Price</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cards dark">
                            <div class="titleAndDis">
                                <div class="title">Date of receipt</div>
                                <div class="content">{{ $deal->delivery_date->format('d-m-Y') }}</div>
                                <div class="dis">{{ $deal->delivery_date->format('l') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="DetailsSection">
                    <div class="MainTitle">Details Deal</div>
                    <form>
                        <div class="form-row">
                            @foreach ($deal->deal_cards as $deal_card)
                            <div class="form-group col-md-6">
                                <label for="customerName{{ $deal_card->id }}">Card Name </label>
                                <div class="form-control" id="customerName{{ $deal_card->id }}">
                                    {{ $deal_card->customer_name }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="customerPhone{{ $deal_card->id }}">Phone Number </label>
                                <div class="form-control" id="customerPhone{{ $deal_card->id }}">
                                    {{ $deal_card->customer_phone }}
                                </div>
                            </div>
                            @endforeach
                        </div>


                    </form>
                </div>
            </div>
            <div class="modal-footer btns">
                <button type="button" class="btn lite" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach





@forelse($deals as $deal)
<div class="modal fade tableDataForm dealsForm" id="userModal{{ $deal->id }}" tabindex="-1"
    aria-labelledby="userModalLabel{{ $deal->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content salesInformation PrintingPlanForm">
            <img src="{{ asset('admin/images/Ellipse19.png') }}" alt="">
            <div class="modal-header">
                <div class="CardTitle">Sales Information</div>

            </div>
            <div class="cards modal-body">

                <div class="titleAndDis">
                    <div class="dis">
                        Admin
                    </div>
                    <i class="fa-solid fa-forward"></i>
                    @php
                    // Access the first user
                    $user = $deal->lead->users[0] ?? null;

                    // Access the first parent
                    $firstParent = $user ? $user->parents->first() : null;

                    // Access the second parent of the first parent
                    $secondParent = $firstParent ? $firstParent->parents->first() : null;
                    @endphp

                    <div class="dis">
                        {{ $secondParent ? $secondParent->name : 'No Grandparent' }}
                    </div>
                    <i class="fa-solid fa-forward"></i>
                    <div class="dis">
                        {{ $firstParent ? $firstParent->name : 'No Parent' }}
                    </div>
                    <i class="fa-solid fa-forward"></i>
                    <div class="dis">
                        {{ $user ? $user->name : 'No User' }}
                    </div>
                </div>

            </div>
            <div class="modal-footer btns">
                <button type="button" class="btn lite" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
@endforeach



@section('script')
<script>
    document.getElementById('deal_date_from').addEventListener('change', updateDateFilterdeal_date);
    document.getElementById('deal_date_to').addEventListener('change', updateDateFilterdeal_date);

    function updateDateFilterdeal_date() {
        var fromDate = document.getElementById('deal_date_from').value;
        var toDate = document.getElementById('deal_date_to').value;

        var newUrl = window.location.pathname + '?deal_date_from=' + encodeURIComponent(fromDate) +
            '&deal_date_to=' + encodeURIComponent(toDate);
        window.location.href = newUrl;
    }
    document.getElementById('receipt_date_from').addEventListener('change', updateDateFilterreceipt_date);
    document.getElementById('receipt_date_to').addEventListener('change', updateDateFilterreceipt_date);

    function updateDateFilterreceipt_date() {
        var fromDate = document.getElementById('receipt_date_from').value;
        var toDate = document.getElementById('receipt_date_to').value;

        var newUrl = window.location.pathname + '?receipt_date_from=' + encodeURIComponent(fromDate) +
            '&receipt_date_to=' + encodeURIComponent(toDate);
        window.location.href = newUrl;
    }
</script>
@endsection