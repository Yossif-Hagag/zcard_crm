@extends('layouts.app')
@section('style')
@endsection
@section('titlePage')
    Manage Management System
@endsection
@section('path')
    <span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
            class="fa-solid fa-chevron-right"></i></span>
    <span><a class="text-decoration-none text-body" href="{{ route('accounting.index') }}">Accounting</a> <i
            class="fa-solid fa-chevron-right"></i></span>
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
    <!-- DATA table -->
    <section class="section3 AccountingPage">
        <div class="totals">
            <div class="row bigTotals">
                <div class="col-md-3 color1">
                    <div class="totla">
                        <div class="disAndNum">
                            <div class="dis">Total Sales</div>
                            <div class="num">100EGP</div>
                        </div>
                        <div class="image"><img src="{{ asset('admin/images/accounting/stock-market.png') }}"
                                alt=""></div>
                        <div class="shap"></div>
                    </div>
                </div>
                <div class="col-md-3 color2">
                    <div class="totla">
                        <div class="disAndNum">
                            <div class="dis">Total Exit</div>
                            <div class="num">100EGP</div>
                        </div>
                        <div class="image"><img src="{{ asset('admin/images/accounting/sign-out-option1.png') }}"
                                alt=""></div>
                        <div class="shap"></div>
                    </div>
                </div>

                <div class="col-md-3 color4">
                    <div class="totla">
                        <div class="disAndNum">
                            <div class="dis">Total income</div>
                            <div class="num">100EGP</div>
                        </div>
                        <div class="image"><img src="{{ asset('admin/images/accounting/login1.png') }}" alt="">
                        </div>
                        <div class="shap"></div>
                    </div>
                </div>
                <div class="col-md-3 color3">
                    <div class="totla">
                        <div class="disAndNum">
                            <div class="dis">Net profit</div>
                            <div class="num">100EGP</div>
                        </div>
                        <div class="image"><img src="{{ asset('admin/images/accounting/money1.png') }}" alt="">
                        </div>
                        <div class="shap"></div>
                    </div>
                </div>
            </div>
            {{-- smallTotals --}}
            <div class="row smallTotals">
                <div class="col-md-4">
                    <div class="line"></div>
                    <div class="totla">
                        <div class="disAndNum">
                            <div class="num">2000EGP</div>
                            <div class="dis">Total salaries</div>
                        </div>
                        <div class="image"><img src="{{ asset('admin/images/accounting/$.png') }}" alt=""></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="line"></div>
                    <div class="totla">
                        <div class="disAndNum">
                            <div class="num">2000EGP</div>
                            <div class="dis">Total Advances</div>
                        </div>
                        <div class="image"><img src="{{ asset('admin/images/accounting/expenses1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="line"></div>
                    <div class="totla">
                        <div class="disAndNum">
                            <div class="num">2000EGP</div>
                            <div class="dis">Current Expense</div>
                        </div>
                        <div class="image"><img src="{{ asset('admin/images/accounting/family1.png') }}" alt="">
                        </div>
                    </div>
                </div>

            </div>
            {{-- end smallTotals --}}
            <div class="row">
                <div class="col-md-7 chartAndBalance">
                    <div class="chart1">
                        <div class="titles">
                            <div class="title1">Statistics</div>
                            <div class="title2">Sales report</div>
                        </div>
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="balance">
                        <div class="title">Account Balance</div>
                        <div class="table">
                            <div class="header row">
                                <div class="item col-md-1">Bank</div>
                                <div class="item col-md-4">HolderName</div>
                                <div class="item col-md-4">Balanec</div>

                            </div>
                            <div class="TableBody">
                                <div class="tableRow row">
                                    <div class="item col-md-1">CIB</div>
                                    <div class="item col-md-4">Work CIB</div>
                                    <div class="item col-md-4 greenItem">EGP 20.000</div>
                                </div>
                                <div class="tableRow row">
                                    <div class="item col-md-1">CIB</div>
                                    <div class="item col-md-4">Work CIB</div>
                                    <div class="item col-md-4 greenItem">EGP 20.000</div>
                                </div>
                                <div class="tableRow row">
                                    <div class="item col-md-1">CIB</div>
                                    <div class="item col-md-4">Work CIB</div>
                                    <div class="item col-md-4 greenItem">EGP 20.000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 incomeAndExpenses">
                    <div class="income">
                        <div class="mainTitle">Income Vs Expense</div>
                        <div class="content row">
                            <div class="cardItem col-md-6">
                                <img src="{{ asset('admin/images/icons/Group1000002588.png') }}" alt="">
                                <div class="titleAndPrice">
                                    <div class="title">Income Today</div>
                                    <div class="price">250EGP</div>
                                </div>
                            </div>
                            <div class="cardItem col-md-6">
                                <img src="{{ asset('admin/images/icons/Group1000002588.png') }}" alt="">
                                <div class="titleAndPrice">
                                    <div class="title">Income This Month</div>
                                    <div class="price">250EGP</div>
                                </div>
                            </div>
                            <div class="cardItem col-md-6">
                                <img src="{{ asset('admin/images/icons/Group1000002589.png') }}" alt="">
                                <div class="titleAndPrice">
                                    <div class="title">Expense Today</div>
                                    <div class="price">250EGP</div>
                                </div>
                            </div>
                            <div class="cardItem col-md-6">
                                <img src="{{ asset('admin/images/icons/Group1000002589.png') }}" alt="">
                                <div class="titleAndPrice">
                                    <div class="title">Expense This Month</div>
                                    <div class="price">250EGP</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="Expenses">
                        <div class="mainTitle">Expenses</div>
                        <div class="totalMonth">
                            <div>Total expenses for the month</div>
                            <div class="num">200EGP</div>
                        </div>
                        <div class="total">
                            <div class="dis">Total operating expenses</div>
                            <div class="header">
                                <div>type</div>
                                <div>Price</div>
                            </div>
                            <div class="totalBody">
                                <div class="bodyRow">
                                    <div>Print</div>
                                    <div>100EGP</div>
                                </div>
                            </div>
                        </div>
                        <div class="total">
                            <div class="dis">Total General Expenses</div>
                            <div class="header">
                                <div>type</div>
                                <div>Price</div>
                            </div>
                            <div class="totalBody">
                                <div class="bodyRow">
                                    <div>electricity</div>
                                    <div>100EGP</div>
                                </div>
                                <div class="bodyRow">
                                    <div>Honors</div>
                                    <div>100EGP</div>
                                </div>
                                <div class="bodyRow">
                                    <div>salaries</div>
                                    <div>100EGP</div>
                                </div>
                            </div>
                        </div>
                        <div class="total">
                            <div class="dis">Total fixed asset expenses </div>
                            <div class="header">
                                <div>type</div>
                                <div>Price</div>
                            </div>
                            <div class="totalBody">
                                <div class="bodyRow">
                                    <div>Mobiles</div>
                                    <div>100EGP</div>
                                </div>
                                <div class="bodyRow">
                                    <div>furniture</div>
                                    <div>100EGP</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- end DATA table -->
@endsection

@section('script')
@endsection
