@extends('layouts.app')
@section('style')
    <style>
        .page-item.active .page-link {
            background-color: #3f8dff !important;
            color: #fff !important;
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
        .PrintingPage .table-data,
        .PrintingPage .header__item {
            flex: 0 0 20%;
        }
        .header__item{
            align-items: normal !important;
        }
    </style>
@endsection
@section('titlePage')
    Manage Management System
@endsection
@section('path')
    <span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
            class="fa-solid fa-chevron-right"></i></span>
    <span><a class="text-decoration-none text-body" href="{{ route('todos.index') }}">Todo</a> <i
            class="fa-solid fa-chevron-right"></i></span>
@endsection

@section('content')
    <!-- DATA table -->
    <section class="section3 PrintingPage TodoPage ">
        <div class="tableData">
            <!-- Customer data -->
            <div class="customerData">
                <div class="titles">
                    <h5 class="fw-bold">Today Follow UP</h5>
                </div>
            </div>
            <!-- Customer data -->
            <div class="">
                <div class="table">
                    <div class="table-header justify-content-around">
                        <div class="header__item"><a id="name" class="filter__link">ID</a></div>
                        <div class="header__item"><a id="name" class="filter__link">Customer Name</a>
                        </div>
                        <div class="header__item"><a id="wins" class="filter__link filter__link--number">Customer
                                Number</a></div>
                        <div class="header__item"><a id="wins" class="filter__link filter__link--number">Follow Up Comment
                                </a></div>
                        <div class="header__item">
                            <a id="losses" class="filter__link filter__link--number">Delivery Data</a>
                            {{-- <div class="d-flex flex-column gap-2">
                                <input type="date" name="delivery_date_from" id="delivery_date_from"
                                    value="{{ $deliveryDateFrom ?? null }}" placeholder="delivery Date From">
                                <input type="date" name="delivery_date_to" id="delivery_date_to"
                                    value="{{ $deliveryDateTo ?? null }}" placeholder="delivery Date To">
                            </div> --}}
                        </div>
                        <div class="header__item"><a id="draws" class="filter__link filter__link--number">profile
                                link</a>
                        </div>

                    </div>

                    <div class="table-content">
                        @foreach ($leads as $lead)
                            <div class="table-row justify-content-around">

                                <div class="table-data">{{ $loop->iteration }}</div>
                                <div class="table-data">{{ $lead->name }}</div>
                                <div class="table-data">{{ $lead->phone }}</div>
                                <div class="table-data">{{ $lead->follow_up_comment?? 'No Comment' }}</div>
                                <div class="table-data">
    {{ $lead->follow_date ? $lead->follow_date->format('Y-m-d') : 'No Date' }}
</div>

                                <div class="table-data">
                                    <a class="clickHere" href="{{ route('leads.show', $lead) }}">Click Here</a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- pagination -->
    <div class="Todo paginationContainer">
        <nav aria-label="Page navigation example" class="pagination d-flex justify-content-around align-content-around">
            <ul class="pagination">
                {{ $leads->links() }}
            </ul>
        </nav>
    </div>
    <!-- end pagination -->
    <!-- end DATA table -->
@endsection

@section('script')
    <script>
        document.getElementById('delivery_date_from').addEventListener('change', updateDateFilterdelivery_date);
        document.getElementById('delivery_date_to').addEventListener('change', updateDateFilterdelivery_date);

        function updateDateFilterdelivery_date() {
            var fromDate = document.getElementById('delivery_date_from').value;
            var toDate = document.getElementById('delivery_date_to').value;
            var newUrl = window.location.pathname + '?delivery_date_from=' + encodeURIComponent(fromDate) +
                '&delivery_date_to=' + encodeURIComponent(toDate);
            window.location.href = newUrl;
        }
    </script>
@endsection
