@extends('layouts.app')
@section('titlePage')
Manage CRM
@endsection
@section('path')
<span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
        class="fa-solid fa-chevron-right"></i></span>
<span><a class="text-decoration-none text-body" href="{{ route('leads.index') }}">Leads</a> <i
        class="fa-solid fa-chevron-right"></i></span>
@endsection

@section('search')
@endsection

@section('content')

<h5>Customer Name : {{ $lead->name }} </h5>
@can('update', $lead)
<a href="{{ route('leads.edit', $lead) }}" class="editStageLead">
    <button type="button" class="btn btn-light">
        <div class="tdContent">
            <img src="{{ asset('admin/images/icons/edit.png') }}"
                alt="">
        </div>
    </button>
</a>
@endcan
<!-- section 1 => contacts informations -->
<div class="leadPage ">

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show w-75" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show w-75" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session('error') }}
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

    <div class="container s2-1">
        <section class="section1">
            <div class="row">
                <div class="phoneNum col-md-4">
                    <div class="conn">
                        <div><img src="{{ asset('admin/images/icons/phone-call 1.png') }}" alt=""></div>
                        <div class="contents">
                            <div class="title">Phone Nubmer</div>
                            <div class="contact">{{ $lead->phone }}</div>
                        </div>
                    </div>
                </div>
                <div class="phoneNum col-md-4">
                    <div class="conn">

                        <div><img src="{{ asset('admin/images/icons/phone-call 1.png') }}" alt=""></div>
                        <div class="contents">
                            <div class="title">Phone Nubmer</div>
                            <div class="contact">{{ $lead->phone2 }}</div>
                        </div>
                    </div>
                </div>
                <div class="whats col-md-4">
                    <div class="conn" id="whatsapp-link">

                        <div><img src="{{ asset('admin/images/icons/whatsapp 2.png') }}" alt=""></div>
                        <div class="contents">
                            <div class="title">whats App</div>
                            <div class="contact">{{ $lead->phone }}</div>
                        </div>
                    </div>
                </div>
                <script>
                    document.getElementById('whatsapp-link').addEventListener('click', function() {
                        var phoneNumber = "+2{{ $lead->phone }}"; // Get the phone number from your Laravel variable
                        var whatsappUrl = "https://wa.me/" + phoneNumber; // Construct the WhatsApp URL

                        // Open WhatsApp in a new tab with the generated URL
                        window.open(whatsappUrl, '_blank');
                    });
                </script>
                <div class="returned col-md-4">
                    <div class="conn">

                        <div><img src="{{ asset('admin/images/icons/status 1.png') }}" alt=""></div>
                        <div class="contents">
                            <div class="title">Source</div>
                            <div class="contact">{{ optional($lead->source)->name ?? '-' }}</div>

                        </div>
                    </div>
                </div>
                <div class="signIn col-md-4">
                    <div class="conn">

                        <div><img src="{{ asset('admin/images/icons/log-in 1.png') }}" alt=""></div>
                        <div class="contents">
                            <div class="title">Follow up</div>
                            <div class="contact">
                                {{ !!$lead->follow_date ? \Carbon\Carbon::parse($lead->follow_date)->format('Y-m-d') : null }}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="status col-md-4">
                    <div class="conn">

                        <div><img src="{{ asset('admin/images/icons/quote-request 1.png') }}" alt=""></div>
                        <div class="contents">
                            <div class="title">Stage</div>
                            <div class="contact"> {{ optional($lead->stage)->name ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- status section -->
            <div class="StatusSection row">

                <div class="col-md-7">

                    <div class="StatusSection row">
                        <div class="way ">
                            <div class="crecalC">
                                <div class="request crecal"></div>
                                <div class="statu">Request</div>
                            </div>
                            <div class="crecalC">
                                <div class="confirmation crecal"></div>
                                <div class="statu">Confirmation</div>
                            </div>
                            <div class="crecalC">
                                <div class="print crecal"></div>
                                <div class="statu">Print</div>
                            </div>
                            <div class="crecalC">
                                <div class="shipping crecal"></div>
                                <div class="statu">Shipping</div>
                            </div>
                            <div class="crecalC">
                                <div class="reception crecal"></div>
                                <div class="statu">Reception</div>
                            </div>

                        </div>
                        <script>
                            var stu = @json($lastDeal);
                            var test = stu.status_id;
                            console.log(test);
                        </script>

                    </div>
                </div>

            </div>


        </section>
    </div>
    <section class="leadSales">
        <div class="container">
            <div class="row row1">
                <div class="col-md-9 row">
                    <div class="cardd col">
                        <div class="img"><img src="{{ asset('admin/images/icons/Group1.png') }}" alt="">
                        </div>
                        <div class="dis">
                            <div class="title">Cards</div>
                            <div class="content">{{ $allCards }}</div>
                        </div>
                    </div>

                    <div class="cardd col">
                        <div class="img"><img src="{{ asset('admin/images/icons/Group2.png') }}" alt="">
                        </div>
                        <div class="dis">
                            <div class="title">Shipping Number</div>
                            <div class="content">{{ $shippingNum }}</div>
                        </div>
                    </div>

                    <div class="cardd col">
                        <div class="img"><img src="{{ asset('admin/images/icons/Group11.png') }}" alt="">
                        </div>
                        <div class="dis">
                            <div class="title">Receptions Number</div>
                            <div class="content">{{ $receptionsNum }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="img"><img src="{{ asset('admin/images/icons/all1.png') }}" alt=""></div>
                    <div class="titleAndPrice">
                        <div class="title">Total Price</div>
                        <div class="price">LE {{ $totalPrice }}</div>
                    </div>

                </div>
            </div>
            <div class="row row2">
                <div class="main col-md-6">
                    <div class="comment customC row">
                        <div class="col-md-12">
                            <div class="title">Comments</div>
                            @if (!Auth::user()->hasRole('Viewer Admin'))
                            <div class="icon AddNComments">+</div>
                            @endif
                        </div>

                        <div class="commentS">
                            @forelse ($lead->comments as $comment)
                            <div class="commentes">
                                <strong>{{ $comment->user->name ?? 'Anonymous' }} :
                                    {{ $comment->comment }}</strong>
                                <span
                                    class="text-muted"><br>{{ $comment->created_at->format('Y-m-d H:i:s') }}</span>

                            </div>
                            @empty
                            <p>No comments yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>






                <div class="main col-md-6">
                    <div class="comment address row">
                        <div class="col-md-12">
                            <div class="title">Address</div>
                            @if (!Auth::user()->hasRole('Viewer Admin'))
                            <div class="icon AddNAddress">+</div>
                            @endif
                        </div>

                        <div class="addresesS">
                            @forelse ($lead->addresses as $address)
                            <div class="addreses my-2">
                                <strong>Address ({{ $loop->iteration }}): {{ $address->address }} <br>
                                    Building: {{ $address->building }}<br>
                                    Flat Number: {{ $address->flat_number }}<br>
                                    Floor: {{ $address->floor }}<br>
                                    State: {{ $address->state }}<br>
                                    City: {{ $address->city }}<br>
                                    Landmark: {{ $address->landmark }}<br>
                                    <br>
                            </div>

                            @empty
                            <p>No addresses yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row3">
                <div class=" col-md-12">
                    <div class="order row">
                        <div class="col-md-12 d-flex">
                            <div class="title">Deals</div>
                            @if (!Auth::user()->hasRole('Viewer Admin') && !Auth::user()->hasRole('Confirmation Deal'))
                            <div class="d-flex gap-2">
                                {{-- <div class="icon delay">Delay</div> --}}
                                <div class="icon AddNOrders">+</div>
                            </div>
                            @endif
                        </div>
                        <div class="Deals">
                            <div class="tableEdit">
                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>

                                            <th scope="col">Recipient</th>
                                            <th scope="col">Mobile </th>
                                            <th scope="col">Card</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Shipping Address</th>
                                            <th scope="col">Create Date</th>
                                            <th scope="col">Receipt Date</th>
                                            <th scope="col">Sales</th>
                                            {{-- <th scope="col">Delay</th> --}}
                                            <th scope="col">Status</th>
                                            {{-- <th scope="col">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ddeals as $deal)
                                        <tr class="">

                                            <td>
                                                <div class="tdContent">{{ $loop->iteration }}</div>
                                            </td>


                                            <td>
                                                <div class="tdContent">{{ $deal->defaultname }}</div>
                                            </td>
                                            <td>
                                                <div class="tdContent">{{ $deal->defaultphone }}</div>
                                            </td>
                                            <td>
                                                <div class="tdContent">
                                                    @if ($deal->deal_cards->isNotEmpty())
                                                    <div class="tdContent">
                                                        {{ $deal->deal_cards->first()->card_name }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="tdContent">EGP{{ $deal->cost }}</div>
                                            </td>

                                            <td>
                                                <div class="tdContent">{{ $deal->customer_address }}</div>
                                            </td>
                                            <td>
                                                <div class="tdContent text-center">
                                                    {{ $deal->deal_date ? $deal->deal_date->format('Y-m-d') : '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="tdContent text-center">
                                                    {{ $deal?->delivery_date->format('Y-m-d') ?? '' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="tdContent">
                                                    {{ $deal?->lead->users[0]->name ?? '-' }}
                                                </div>
                                            </td>
                                            {{-- <td>
                                                        <div class="tdContent">
                                                            {{ optional($deal?->deal_delay)->last()->status ?? 'Null' }}
                            </div>
                            </td> --}}
                            <td>
                                <div class="tdContent">
                                    @switch($deal->status_id)
                                    @case(1)
                                    Request
                                    @break

                                    @case(2)
                                    Confirmation
                                    @break

                                    @case(3)
                                    Print
                                    @break

                                    @case(4)
                                    Shipping
                                    @break

                                    @case(5)
                                    Reception
                                    @break

                                    @default
                                    NO Status
                                    @endswitch
                                </div>
                            </td>
                            {{-- <td>
                                                        <div class="tdContent">
                                                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                                                <button data-bs-toggle="modal"
                                                                    data-bs-target="#Delay{{ $deal->id }}"
                            class="bulid"
                            {{ $deal->deal_delay->count() >= 3 ? 'disabled' : '' }}>
                            Delay
                            </button>
                            @endif

                            @push('modals')
                            <div class="modal fade" id="Delay{{ $deal->id }}"
                                tabindex="-1" aria-labelledby="#Delay"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="codeConfirm">
                                                <!-- start confirm printing form -->
                                                <div
                                                    class="animate__animated PrintingPlanForm ">
                                                    <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                        alt="">
                                                    <div class="container">
                                                        <form
                                                            action="{{ route('Delay', $deal->id) }}"
                                                            method="POST">
                                                            @csrf


                                                            <h2>Make Delay</h2>
                                                            <div class="form-row row mt-2">
                                                                <div
                                                                    class="form-group col-md-12 doneBtn searchbyDates">
                                                                    <label
                                                                        class="m-0">Delay
                                                                        Time</label>

                                                                    <div class="conInput">
                                                                        <input
                                                                            type="date"
                                                                            name="delay_time"
                                                                            id="deal_date_from"
                                                                            value="{{ $dealDateFrom ?? null }}"
                                                                            placeholder="Create Date From">
                                                                        <img src="{{ asset('admin/images/icons/calendar.png') }}"
                                                                            alt=""
                                                                            srcset="">
                                                                    </div>
                                                                </div>


                                                                <div>
                                                                    <label for="reason"
                                                                        class="animate__animated">
                                                                        Reason for Delay:
                                                                        <textarea name="comment" rows="4" cols="25" style="width: 80%" require></textarea>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="btns mt-4">
                                                                <div
                                                                    class="d-flex justify-content-center">
                                                                    <button type="submit"
                                                                        class="btn mx-4 dark">Accept</button>
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
                            @endpush

                        </div>
                        </td> --}}

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

                    </div>
                </div>

            </div>
        </div>


</div>
</section>

{{-- <div class="row row3">
                    <div class=" col-md-12">
                        <div class="order row">
                            <div class="col-md-12">
                                <div class="title">Deals</div>
                                <div class="icon AddNOrders">+</div>
                            </div>
                            <div class="Deals">
                                <div class="tableEdit">

                                    <div class="row1">
                                        <div class="group">
                                            <div class="title">Number of orders</div>
                                            <div class="num">1</div>
                                        </div>
                                        <div class="group">
                                            <div class="title">Receiving number</div>
                                            <div class="num">0</div>
                                        </div>
                                        <div class="group">
                                            <div class="title">Number of rejections</div>
                                            <div class="num">0</div>
                                        </div>

                                    </div>
                                    <div class="row2">
                                        <div class="history">
                                            <label for="icon"><img
                                                    src="{{ asset('fro/images/icons/calendarW.png') }}"
alt=""></label>
<div class="txtAndInput">
    <div class="txt">History</div>
    <input type="date" id="icon" placeholder="17-12-2024">
</div>
</div>
<div class="history">
    <label for="Statu"><img
            src="{{ asset('fro/images/icons/processing-time 1.png') }}"
            alt=""></label>
    <div class="txtAndInput">
        <div class="txt">Status</div>
        <span>Reception</span>
    </div>
</div>
</div>
</div>
</div>

</div>
</div>


</div> --}}

</section>
<!-- end section2 -->
</div>


</div>
</main>
</div>
<!-- address Form -->
{{-- 
<div class="bg-mian-dark animate__animated AddAddress">

    <div class="cickMe"></div>
    <div class="addForm container">
        <div class="cickMe"></div>
        <form action="{{ route('addresses.store') }}" method="POST">
            @csrf
            <h2>Add Address</h2>
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            <div class="form-row ">
                <div class="form-group col-md-12">
                    <label for="inputPassword99">Address</label>
                    <span class="AddressSection">
                        <input name="address" type="text" class="form-control" id="inputPassword99">
                    </span>

                </div>
            </div>


            <div class="form-row">

                <div class="form-group col-md-6 flowr">
                    <label for="inputPassword9">Building</label>
                    <input name="building" type="text" class="form-control" id="inputPassword9">
                </div>


                <div class="form-group col-md-6 flowr">
                    <label for="inputPassword9">Floor</label>
                    <input name="floor" type="text" class="form-control" id="inputPassword9">
                </div>


            </div>


            <div class="form-row">
                <div class="form-group col-md-6 flat">
                    <label for="inputEmail10">Flat Nubmer</label>
                    <input name="flat_number" type="text" class="form-control" id="inputEmail10">
                </div>

                <div class="form-group col-md-6 state">
                    <label for="inputPassword11">State</label>
                    <input name="state" type="text" class="form-control" id="inputPassword11">
                </div>


            </div>

            <div class="form-row">
                <div class="form-group col-md-6 flat">
                    <label for="inputEmail10">City</label>
                    <input name="city" type="text" class="form-control" id="inputEmail10">
                </div>

                <div class="form-group col-md-6 state">
                    <label for="inputPassword11">Land Mark</label>
                    <input name="landmark" type="text" class="form-control" id="inputPassword11">
                </div>


            </div>
            <div class="form-row">


            </div>
            <div class="btns">
                <button type="submit" class="btn dark">Create</button>
                <button type="submit" class="btn lite">Close</button>
            </div>
        </form>
    </div>
</div> --}}
<div class="bg-mian-dark animate__animated AddAddress">

    <div class="cickMe"></div>
    <div class="addForm container">
        <div class="cickMe"></div>
        <form action="{{ route('addresses.store') }}" method="POST">
            @csrf
            <h2>Add Address</h2>
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            <div class="form-row ">
                <div class="form-group col-md-12">
                    <label for="inputPassword99">Address</label>
                    <span class="AddressSection">
                        <input name="address" required type="text" class="form-control" id="inputPassword99">
                    </span>

                </div>
            </div>


            <div class="form-row">

                <div class="form-group col-md-6 flowr">
                    <label for="inputPassword9">Building</label>
                    <input name="building" required type="text" class="form-control" id="inputPassword9">
                </div>


                <div class="form-group col-md-6 flowr">
                    <label for="inputPassword9">Floor</label>
                    <input name="floor" required type="text" class="form-control" id="inputPassword9">
                </div>


            </div>


            <div class="form-row">
                <div class="form-group col-md-6 flat">
                    <label for="inputEmail10">Flat Nubmer</label>
                    <input name="flat_number" required type="text" class="form-control" id="inputEmail10">
                </div>

                <div class="form-group col-md-6 state">
                    <label for="inputPassword11">State</label>
                    <input name="state" type="text" required class="form-control" id="inputPassword11">
                </div>


            </div>

            <div class="form-row">
                <div class="form-group col-md-6 flat">
                    <label for="CitySelection">City</label>
                    {{-- <input name="city" type="text" class="form-control" id="inputEmail10"> --}}
                    <select name="city" id="CitySelection" class="form-select"
                        aria-label="Default select example" required>
                        <option value="Cairo">Cairo</option>
                        <option value="Alexandria">Alexandria</option>
                        <option value="Giza">Giza</option>
                        <option value="Aswan">Aswan</option>
                        <option value="Asyut">Asyut</option>
                        <option value="Beheira">Beheira</option>
                        <option value="Beni Suef">Beni Suef</option>
                        <option value="Dakahlia">Dakahlia</option>
                        <option value="Damietta">Damietta</option>
                        <option value="Fayoum">Fayoum</option>
                        <option value="Gharbia">Gharbia</option>
                        <option value="Gharbia">Gharbia</option>
                        <option value="Kafr El Sheikh">Kafr El Sheikh</option>
                        <option value="Luxor">Luxor</option>
                        <option value="Matrouh">Matrouh</option>
                        <option value="Minya">Minya</option>
                        <option value="Monufia">Monufia</option>
                        <option value="New Valley">New Valley</option>
                        <option value="North Sinai">North Sinai</option>
                        <option value="Port Said">Port Said</option>
                        <option value="Qena">Qena</option>
                        <option value="Red Sea">Red Sea</option>
                        <option value="Sharqia">Sharqia</option>
                        <option value="Sohag">Sohag</option>
                        <option value="South Sinai">South Sinai</option>
                        <option value="Suez">Suez</option>
                        <option value="Minya">Minya</option>


                    </select>
                </div>

                <div class="form-group col-md-6 state">
                    <label for="inputPassword11">Land Mark</label>
                    <input name="landmark" type="text" required class="form-control" id="inputPassword11">
                </div>


            </div>
            <div class="form-row">


            </div>
            <div class="btns">
                <button type="submit" class="btn dark">Create</button>
                <button type="submit" class="btn lite">Close</button>
            </div>
        </form>
    </div>
</div>
<!--end address Form -->
<!-- order From -->

<div class="bg-mian-dark animate__animated AddOrders">

    <div class="cickMe"></div>
    <div class="addForm container">
        <div class="cickMe"></div>
        <form action="{{ route('deals.store', $lead->id) }}" method="POST">
            @csrf
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            <h2>Create Deal</h2>
            <div class="header">
                <div class="HeaderCard">
                    <div class="icon"><img src="{{ asset('admin/images/icons/credit-card1.png') }}"
                            alt=""></div>
                    <div class="contents">
                        <div class="title">
                            <select class="form-control" name="card_name" id="keyupForNum">
                                <option selected>Select Card</option>
                                @foreach ($cards as $card)
                                <option value="{{ $card->id }}" data-cost="{{ $card->cost }}"
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
                    <div class="icon"><img src="{{ asset('admin/images/icons/finance1.png') }}" alt="">
                    </div>
                    <div class="contents">
                        <!-- <div class="title"><span class="cardCost" custom-attr="">0</span> EGP</div> -->
                        <!-- <div class="title">
  <span class="cardCost" contenteditable="true">0</span> EGP
</div> -->
<div class="title">
    <input type="number" class="cardCost" value="0" custom-attr="" /> EGP
</div>


                        <input type="hidden" class="finalPrice" name="finalPrice">
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
                            <input name="defaultname" type="text" class="form-control" id="defaultname"
                                placeholder="please enter data">
                            <div class="input-group-append">

                                <span class="input-group-text"
                                    onclick="populateInput('defaultname', '{{ $lead->name }}')">
                                    <i class="fas fa-user "></i>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="defaultphone">Customer Phone Number</label>
                        <div class="input-group">
                            <input name="defaultphone" type="text" class="form-control" id="defaultphone"
                                placeholder="please enter data">
                            <div class="input-group-append">

                                <span class="input-group-text"
                                    onclick="populateInput('defaultphone', '{{ $lead->phone }}')">
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
                <div class="customer-data-entry coustemID-{{ $lead->id }}">
                    <input type="hidden" class="valOfCustomID"
                        value="coustemID-{{ $lead->id }}">
                    <div class="form-row ">
                        <div class="form-group col-md-6 customInputsCards">
                            <label for="inputName">Card Name</label>
                            <input type="text" class="form-control" name="customer_name[]"
                                placeholder="Please enter data" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPhone">Card Phone</label>
                            <input type="text" class="form-control" name="customer_phone[]"
                                placeholder="Please enter data" required>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary addCustomerButton">Add Another Card Data</button>

            <div class="Formline">
                <div></div>
            </div>
            <div class="row">
                <div class="EXAddress col-12">
                    <span class="icon"><i class="fa-solid fa-chevron-down" style="color: #ffffff;"></i></span>
                    <select name="address" id="address" class="form-select" aria-label="Default select example"
                        required>
                        @foreach ($lead->addresses as $address)
                        <option value="{{ $address->state }}">{{ $address->address . ' - ' . $address->state }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <input type="hidden" name="cost" id="cost" value="{{ $cards[0]->cost ?? 0 }}">


            <div class="row date">
                <div class="orderDate col-md-6">
                    <div class="mainCardd">
                        <div class="title">Date of receipt</div>
                        <div class="card1">
                            <div class="inputAndValue">
                                <div class="enter">Date of receipt</div>
                                <input type="date" name="date_of_receipt" id="Calendar"
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
                                <div class="enter">Time of receipt</div>
                                <input type="time" name="time" id="Calendar"
                                    style="background: #faebd700 url('{{ asset('admin/images/icons/clock.png') }}');"
                                    required>
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
</div>
<!-- end order From -->
<!-- commente form -->
<div class="bg-mian-dark animate__animated AddComments renewCard">

    <div class="cickMe"></div>
    <div class="addForm container">
        <div class="cickMe"></div>
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <h2>Add Comments</h2>

            <div class="form-row ">
                <div class="form-group col-md-12">

                    <div class="mb-3">

                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="10"
                            placeholder="Please Data 🙏"></textarea>
                    </div>
                </div>
            </div>
            <div class="btns">
                <button type="submit" class="btn dark">Create</button>
                <button type="submit" class="btn lite">Close</button>
            </div>
        </form>
    </div>
</div>
{{-- <div class="bg-mian-dark animate__animated delay ">

            <div class="cickMe"></div>
            <div class="addForm modal printingdeliveryBoyReason container">
                <div class="cickMe"></div>
                <div class="modal-content">
                    <img src="{{ asset('admin/images/Ellipse19.png') }}" alt="">
<div class="modal-body d-flex flex-column">
    <h3 class="mainTitleView">View Delay for Lead </h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Data</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="tableData">
            @forelse ($ddeals as $deal)
            @if ($deal->deal_delay->isNotEmpty())
            @foreach ($deal->deal_delay as $delay)
            <tr>
                <td>{{ $deal->defaultname }}</td>
                <td>{{ $delay->date }}</td>
                <td>{{ $delay->reason }}</td>
                <td>{{ $delay?->status ?? 'Null' }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">
                    No shipping information available for deal :
                    {{ $deal->defaultname }}
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
</div>
</div> --}}
@endsection
