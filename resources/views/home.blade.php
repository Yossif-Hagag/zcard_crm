@extends('layouts.app')
@section('titlePage')
    Manage Management System
@endsection
@section('path')
    <span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
            class="fa-solid fa-chevron-right"></i></span>
@endsection
@section('active')

@endsection
@section('content')
    <section class="sectionStaff">

        <div class="titlePage">
            <div class="title">STAFF</div>
        </div>
        <div class="row justify-content-around">
            <div class="col-md-3">
                <div class="totalUsers">
                    <div class="title">Total User</div>
                    <div class="num">{{ $total }}</div>
                    <div class="dis">Customers that
                        buy products</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class=" col col-sm-5 col-md-4 ">
                        <div class="con">
                            <dov class="icon"><img src="{{ asset('admin/images/icons/Group10.png') }}" alt="">
                            </dov>
                            <div class="position">Sales</div>
                            <div class="num">{{ $totalSales }}</div>
                        </div>
                    </div>
                    <div class="col col-sm-5 col-md-4">
                        <div class="con">
                            <dov class="icon"><img src="{{ asset('admin/images/icons/Group10.png') }}" alt="">
                            </dov>
                            <div class="position">Accounts</div>
                            <div class="num">100</div>
                        </div>
                    </div>
                    <div class="col col-sm-5 col-md-4">
                        <div class="con">
                            <dov class="icon"><img src="{{ asset('admin/images/icons/Group10.png') }}" alt="">
                            </dov>
                            <div class="position">Staff</div>
                            <div class="num">{{ $totalStafe }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="totalOrdersGraph">
                    <div class="totalOrders">Total Order</div>
                    <div class="totalOrdersTxt">Order have been received</div>
                    <div class="chart" id="graph" data-percent="{{ $totalOrder }}">

                        <span class="dis">Orders within a month</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- clients -->
    <section class="clients">
        <div class="titlePage">
            <div class="title">Leads</div>
        </div>
        <div class="row">
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <div class="image"><img src="{{ asset('admin/images/icons/Group1000002576.png') }}" alt=""></div>
                <div class="content">
                    <div class="title">New</div>
                    <div class="num">{{ $newLeads }}</div>
                </div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <div class="image"><img src="{{ asset('admin/images/icons/Group1000002577.png') }}" alt=""></div>
                <div class="content">
                    <div class="title">Not Answered</div>
                    <div class="num">{{ $notAnsweredLeads }}</div>
                </div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <div class="image"><img src="{{ asset('admin/images/icons/telephone-call1.png') }}" alt=""></div>
                <div class="content">
                    <div class="title">Follow Up</div>
                    <div class="num">{{ $followUpLeads }}</div>
                </div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <div class="image"><img src="{{ asset('admin/images/icons/Group1000002578.png') }}" alt=""></div>
                <div class="content">
                    <div class="title">Cold</div>
                    <div class="num">{{ $coldLeads }}</div>
                </div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <div class="image"><img src="{{ asset('admin/images/icons/forbidden-sign1.png') }}" alt=""></div>
                <div class="content">
                    <div class="title">Not Interested</div>
                    <div class="num">{{ $notInterestedLeads }}</div>
                </div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <div class="image"><img src="{{ asset('admin/images/icons/hot-line1.png') }}" alt=""></div>
                <div class="content">
                    <div class="title">Hot</div>
                    <div class="num">{{ $hotLeads }}</div>
                </div>
            </div>
        </div>
    </section>

    <!--end clients -->
    {{-- Deals section --}}
    <section class="clients Deals">
        <div class="titlePage">
            <div class="title">Deals</div>
        </div>
        <div class="row">
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <img src="{{asset('admin/images/icons/pull1.png')}}" alt="">
                <div class="content">
                    <div class="title">Request </div>
                    <div class="num">{{ $Request }}</div>
                </div>
                <div class="line"></div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <img src="{{asset('admin/images/icons/check3.png')}}" alt="">
                <div class="content">
                    <div class="title">Confirmation</div>
                    <div class="num">{{ $Confirmation }}</div>
                </div>
                <div class="line"></div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <img src="{{asset('admin/images/icons/printer.png')}}" alt="">
                <div class="content">
                    <div class="title">Print </div>
                    <div class="num">{{ $Print }}</div>
                </div>
                <div class="line"></div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <img src="{{asset('admin/images/icons/truck.png')}}" alt="">
                <div class="content">
                    <div class="title">Shipping</div>
                    <div class="num">{{ $Shipping }}</div>
                </div>
                <div class="line"></div>
            </div>
            <div class="cards col col-lg-2 col-md-3 col-sm-5">
                <img src="{{asset('admin/images/icons/reception.png')}}" alt="">
                <div class="content">
                    <div class="title">Reception</div>
                    <div class="num">{{ $Reception }}</div>
                </div>

            </div>

        </div>
    </section>
    {{-- end Deals section --}}
    <!-- Print analytics -->
    <section class="PrintAnalytics">
        <div class="titlePage">
            <div class="title">Printing </div>
        </div>
        <div class="row">
            <div class="cards col-md-3">
                <div class="content">
                    <div class="title">Total</div>
                    <div class="num">{{ $allPrintings }}</div>
                </div>
                <div class="image"><img src="{{ asset('admin/images/icons/all.png') }}" alt=""></div>

            </div>
            <div class="cards col-md-3">
                <div class="content">
                    <div class="title">Cancel</div>
                    <div class="num">{{ $cancelPrintings }}</div>
                </div>
                <div class="image"><img src="{{ asset('admin/images/icons/cancel1.png') }}" alt=""></div>

            </div>
            <div class="cards col-md-3">
                <div class="content">
                    <div class="title">Done</div>
                    <div class="num">{{ $donePrintings }}</div>
                </div>
                <div class="image"><img src="{{ asset('admin/images/icons/checkmark1.png') }}" alt=""></div>

            </div>

        </div>
    </section>
    <!--end Print analytics -->
    <!-- Shipping analytics -->
    <section class="shippingAnalytics">

        <div class="row mainShipping">
            <div class="titlePage col-md-12">
                <div class="title">Shipping Analytics</div>
            </div>
            <div class="col-md-6 linesh">

                <div class="cardShipping">
                    <div class="image"><img src="{{ asset('admin/images/icons/Group1000002579.png') }}" alt="">
                    </div>
                    <!-- progress -->
                    <div class="content">
                        <div class="iconTitleAndPar ">
                            <div class="title">All</div>
                            <div class="per">100%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar animate__animated animate__lightSpeedInLeft color-1"
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="cardShipping">
                    <div class="image"><img src="{{ asset('admin/images/icons/Group1000002580.png') }}" alt="">
                    </div>
                    <!-- progress -->
                    <div class="content">
                        <div class="iconTitleAndPar ">
                            <div class="title">New</div>
                            <div class="per">{{ $newpersent }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar color-2 animate__animated animate__lightSpeedInLeft "
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $newpersent }}%;"></div>
                        </div>
                    </div>
                </div>
                <!--  -->

                <div class="cardShipping">
                    <div class="image"><img src="{{ asset('admin/images/icons/Group1000002581.png') }}" alt="">
                    </div>
                    <!-- progress -->
                    <div class="content">
                        <div class="iconTitleAndPar ">
                            <div class="title">In progress</div>
                            <div class="per">{{ $inprogresspersent }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar color-3 animate__animated animate__lightSpeedInLeft "
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $inprogresspersent }}%;"></div>
                        </div>
                    </div>
                </div>
                <!--  -->

                <div class="cardShipping">
                    <div class="image"><img src="{{ asset('admin/images/icons/Group1000002582.png') }}" alt="">
                    </div>
                    <!-- progress -->
                    <div class="content">
                        <div class="iconTitleAndPar ">
                            <div class="title">On the way to the customer</div>
                            <div class="per">{{ $onthewaypersent }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar color-4 animate__animated animate__lightSpeedInLeft "
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $onthewaypersent }}%;"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
            </div>
            <div class="col-md-6">
                <div class="cardShipping">
                    <div class="image"><img src="{{ asset('admin/images/icons/Group1000002583.png') }}" alt="">
                    </div>
                    <!-- progress -->
                    <div class="content">
                        <div class="iconTitleAndPar ">
                            <div class="title">Waiting for follow-up</div>
                            <div class="per">{{ $waiting0forfollowuppersent }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar color-5 animate__animated animate__lightSpeedInLeft "
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $waiting0forfollowuppersent }}%;"></div>
                        </div>
                    </div>
                </div>

                <!--  -->
                <div class="cardShipping">
                    <div class="image"><img src="{{ asset('admin/images/icons/Group1000002584.png') }}" alt="">
                    </div>
                    <!-- progress -->
                    <div class="content">
                        <div class="iconTitleAndPar ">
                            <div class="title">Successfully completed</div>
                            <div class="per">{{ $completedpersent }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar color-6 animate__animated animate__lightSpeedInLeft "
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $completedpersent }}%;"></div>
                        </div>
                    </div>
                </div>

                <!--  -->
                <div class="cardShipping">
                    <div class="image"><img src="{{ asset('admin/images/icons/Group1000002585.png') }}" alt="">
                    </div>
                    <!-- progress -->
                    <div class="content">
                        <div class="iconTitleAndPar ">
                            <div class="title">Unsuccessful completion</div>
                            <div class="per">{{ $unsuccessfulpersent }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar color-7 animate__animated animate__lightSpeedInLeft "
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $unsuccessfulpersent }}%;"></div>
                        </div>
                    </div>
                </div>
                {{--  --}}
                <div class="cardShipping">
                    <div class="image"><img src="{{ asset('admin/images/icons/Group1000002586.png') }}" alt="">
                    </div>
                    <!-- progress -->
                    <div class="content">
                        <div class="iconTitleAndPar ">
                            <div class="title">Returns are rejected</div>
                            <div class="per">{{ $returnsrejectedpersent }}%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar color-7 animate__animated animate__lightSpeedInLeft "
                                role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $returnsrejectedpersent }}%;"></div>
                        </div>
                    </div>
                </div>

                <!--  -->
            </div>
        </div>
    </section>
@endsection
