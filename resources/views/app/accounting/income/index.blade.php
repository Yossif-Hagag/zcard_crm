@extends('layouts.app')
@section('style')
    <style>
        #accountingTable {
            border: none;
            /* إزالة الحدود من الجدول */
        }

        #accountingTable th,
        #accountingTable td {
            border: none;
            /* إزالة الحدود من العناوين والخلايا */
        }

        .dt-layout-row:first-child {
            display: flex;
            flex-direction: row-reverse;
        }

        div.dt-container div.dt-layout-row div.dt-layout-cell.dt-layout-start {
            margin-right: unset !important;
        }

        div.dt-container div.dt-layout-row div.dt-layout-cell.dt-layout-end {
            margin-left: unset !important;
            width: 50%;
        }
    </style>
@endsection
@section('titlePage')
    Manage Management System
@endsection
@section('path')
    <span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
            class="fa-solid fa-chevron-right"></i></span>
    <span><a class="text-decoration-none text-body" href="{{ route('accounting.index') }}">Accounting</a> <i
            class="fa-solid fa-chevron-right"></i></span>
    <span><a class="text-decoration-none text-body" href="{{ route('income') }}">Income</a> <i
            class="fa-solid fa-chevron-right"></i></span>
@endsection
@section('content')
    <div class="container">
        <div class="accountingTablePage">
            <table class="display text-center" id="accountingTable" style="background-color: white;width: 100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>AMOUNT</th>
                        <th>ACCOUNT</th>
                        <th>CUSTOMER</th>
                        <th>PHONE</th>
                        <th>ADDRESS</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomes as $income )


                    <tr>

                        <th class="text-center">{{$income->delivery_date->format('Y-m-d') . ' : ' . $income->time}}</th>
                        <td class="text-center">{{$income->deal_cards->count()}}</td>
                        <td class="text-center">{{$income->cost}}</td>
                        <td class="text-center">{{$income->defaultname}}</td>
                        <td class="text-center">{{$income->defaultphone}}</td>
                        <td class="text-center">{{$income->customer_address}}</td>

                        {{-- <td>
                            <div class="btnActions">
                                <button class="edit" data-bs-toggle="modal" data-bs-target="#EditRevenueModal"><i
                                        class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button>
                                <a href="" class="trush"><i class="fa-solid fa-trash-can"
                                        style="color: #ffffff;"></i></a>
                            </div>
                        </td> --}}
                    </tr>
                      @endforeach


                </tbody>
            </table>
        </div>
    </div>
    {{-- @push('modals')
        <div class="modal fade AddRevenueModal" id="AddRevenue" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Create New Revenue</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <div class="dateSection">
                                    <input type="date" class="form-control shadow-sm" id="inputEmail4">
                                    <img src="{{ asset('admin/images/icons/calendar.png') }}" alt="" srcset="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputAmount4" class="form-label">Amount</label>
                                <input type="text" class="form-control shadow-sm" id="inputAmount4">
                            </div>
                            <div class="col-md-6">
                                <label for="inputAccount4" class="form-label">Account</label>
                                <input type="email" class="form-control shadow-sm" id="inputAccount4">
                            </div>
                            <div class="col-md-6">
                                <label for="inputCustomer4" class="form-label">Customer</label>
                                <input type="text" class="form-control shadow-sm" id="inputCustomer4">
                            </div>

                            <div class="col-md-6">
                                <label for="inputCategory" class="form-label">Category</label>
                                <select id="inputCategory" class="form-select shadow-sm">
                                    <option selected>Select Category</option>
                                    <option>...</option>
                                    <option>...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputReference" class="form-label">Reference</label>
                                <input type="text" class="form-control shadow-sm" id="inputReference">
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="Description" class="form-label">Description</label>
                                    <textarea class="form-control" id="Description" rows="3"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn create">Create</button>
                        <button type="button" class="btn closebtn" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @push('modals')
        <div class="modal fade AddRevenueModal " id="EditRevenueModal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit New Revenue</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <div class="dateSection">
                                    <input type="date" class="form-control shadow-sm" id="inputEmail4">
                                    <img src="{{ asset('admin/images/icons/calendar.png') }}" alt="" srcset="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputAmount4" class="form-label">Amount</label>
                                <input type="text" class="form-control shadow-sm" id="inputAmount4">
                            </div>
                            <div class="col-md-6">
                                <label for="inputAccount4" class="form-label">Account</label>
                                <input type="email" class="form-control shadow-sm" id="inputAccount4">
                            </div>
                            <div class="col-md-6">
                                <label for="inputCustomer4" class="form-label">Customer</label>
                                <input type="text" class="form-control shadow-sm" id="inputCustomer4">
                            </div>

                            <div class="col-md-6">
                                <label for="inputCategory" class="form-label">Category</label>
                                <select id="inputCategory" class="form-select shadow-sm">
                                    <option selected>Select Category</option>
                                    <option>...</option>
                                    <option>...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputReference" class="form-label">Reference</label>
                                <input type="text" class="form-control shadow-sm" id="inputReference">
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="Description" class="form-label">Description</label>
                                    <textarea class="form-control" id="Description" rows="3"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn create">Save Change</button>
                        <button type="button" class="btn closebtn" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush --}}
@endsection
