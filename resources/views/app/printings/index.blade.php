@extends('layouts.app')
@section('style')
    <style>
        .page-item.active .page-link {
            background-color: #3551B5 !important;
            color: #fff !important;
            border-color: unset !important;
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
    </style>
@endsection
@section('titlePage')
    Manage Management System
@endsection
@section('path')
    <span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
            class="fa-solid fa-chevron-right"></i></span>
    <span><a class="text-decoration-none text-body" href="{{ route('printings.index') }}">Printings</a> <i
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
    <section class="section3 PrintingPage shippingPage">
        <div class="tableData d-flex flex-column align-items-center justify-content-between ">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            <div class="w-100">
                <!-- Customer data -->
                <div class="customerData">
                    <div class="titles">
                        <h5 class="fw-bold">Printing plan</h5>
                    </div>
                </div>
                <!-- Customer data -->
                <div class="">

                    <div class="searchbyDates ">
                        <div class="Fillter ">Fillter: </div>
                        <div class="ReceiptDateTo animate__animated">
                            <div class="d-flex gap-2">
                                <div class="from">From</div>
                                <div class="conInput">
                                    <input type="date" name="deal_date_from" id="create_date_from"
                                        value="{{ $createDateFrom ?? null }}" placeholder="Create Date From">
                                    <img src="{{ asset('admin/images/icons/calendar.png') }}" alt="" srcset="">
                                </div>
                                <div class="to">To</div>
                                <div class="conInput">
                                    <input type="date" name="deal_date_to" id="create_date_to"
                                        value="{{ $createDateTo ?? null }}" placeholder="Create Date To">
                                    <img src="{{ asset('admin/images/icons/calendar.png') }}" alt="" srcset="">
                                </div>
                            </div>
                        </div>




                        <div class="DealDateTo animate__animated">
                            <div class="d-flex gap-2">
                                <div class="from">From</div>
                                <div class="conInput">
                                    <input type="date" name="receipt_date_from" id="delivery_date_from"
                                        value="{{ $deliveryDateFrom ?? null }}" placeholder="Create Date From">
                                    <img src="{{ asset('admin/images/icons/calendar.png') }}" alt=""
                                        srcset="">
                                </div>
                                <div class="to">To</div>
                                <div class="conInput">
                                    <input type="date" name="receipt_date_to" id="delivery_date_to"
                                        value="{{ $deliveryDateTo ?? null }}" placeholder="Create Date To">
                                    <img src="{{ asset('admin/images/icons/calendar.png') }}" alt=""
                                        srcset="">
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <select name="" id="" class="">
                                <option value="">Create Date</option>
                                <option value="">Delivery Date</option>
                            </select>
                        </div>

     <a href="{{ route('Printing.export') }}">
                            Export <img src="{{ asset('fro/images/icons/new-file.png') }}" class="icon" alt="">
                        </a>

                    </div>

                    <div class="table">
                        <div class="table-header">
                            <div class="header__item"><a id="name" class="filter__link">ID</a></div>
                            <div class="header__item"><a id="name" class="filter__link">Customer name</a>
                            </div>
                            <div class="header__item"><a id="wins" class="filter__link filter__link--number">Customer
                                    number</a></div>
                            <div class="header__item"><a id="draws" class="filter__link filter__link--number">Customer
                                    Address</a></div>

                            <div class="header__item">
                                <a id="losses" class="filter__link filter__link--number">Create Date</a>
                                {{-- <div class="d-flex flex-column gap-2">
                                    <input type="date" name="create_date_from" id="create_date_from"
                                        value="{{ $createDateFrom ?? null }}" placeholder="Create Date From">
                                    <input type="date" name="create_date_to" id="create_date_to"
                                        value="{{ $createDateTo ?? null }}" placeholder="Create Date To">
                                </div> --}}
                            </div>
                            <div class="header__item">
                                <a id="total" class="filter__link filter__link--number w-100">Delivery Data</a>

                                {{-- <div class="d-flex flex-column gap-2">
                                    <input type="date" name="delivery_date_from" id="delivery_date_from"
                                        value="{{ $deliveryDateFrom ?? null }}" placeholder="Delivery Date From">
                                    <input type="date" name="delivery_date_to" id="delivery_date_to"
                                        value="{{ $deliveryDateTo ?? null }}" placeholder="Delivery Date To">
                                </div> --}}

                            </div>
                            <div class="header__item"><a id="total"
                                    class="filter__link filter__link--number">Total</a>
                            </div>
                        </div>
                        <div class="table-content">
                            @forelse ($printings as $print)
                                <div class="table-row ">
                                    <div class="table-data">{{ $x++ }}</div>
                                    <div class="table-data">{{ $print->defaultname }}</div>
                                    <div class="table-data">+{{ $print->defaultphone }}</div>
                                    <div class="table-data">{{ $print->customer_address }}</div>
                                    <div class="table-data">{{ $print->created_at->format('Y-m-d') }}</div>
                                    <div class="table-data">
                                        {{ $print->delivery_date }}&nbsp;&nbsp;{{ $print->time }}
                                    </div>
                                    <div class="table-data">{{ $print?->print_cards?->count() ?? 0 }}
                                        <div class="Ticon"><img src="{{ asset('admin/images/icons/arrow.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="subTable">
                                    <div class="table">
                                        <div class="table-header">
                                            <div class="header__item"><a id="name" class="filter__link">Card
                                                    name</a>
                                            </div>
                                            <div class="header__item"><a id="wins"
                                                    class="filter__link filter__link--number">Card number</a></div>
                                            <div class="header__item"><a id="draws"
                                                    class="filter__link filter__link--number">Card Code</a></div>
                                            <div class="header__item"><a id="losses"
                                                    class="filter__link filter__link--number">Create Date </a></div>
                                            <div class="header__item"><a id="total"
                                                    class="filter__link filter__link--number">Action</a></div>
                                        </div>
                                        <div class="table-content">

                                            @forelse ($print->print_cards as $printCard)
                                                <div class="table-row">
                                                    <div class="table-data">{{ $printCard->customer_name }}</div>
                                                    <div class="table-data">+{{ $printCard->customer_phone }}</div>
                                                    <div class="table-data">
                                                        <div class="d-flex justify-content-center align-items-center">

                                                            <div class="tdContent">{{ $printCard->card_code }} </div>
                                                            @if (!Auth::user()->hasRole('Viewer Admin'))
                                                                <button class="btn btn-sm edit" data-bs-toggle="modal"
                                                                    data-bs-target="#printingEdit{{ $printCard->id }}"><img
                                                                        src="{{ asset('fro/images/icons/edit.png') }}"
                                                                        alt=""></button>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="table-data">{{ $printCard->created_at->format('Y-m-d') }}
                                                    </div>
                                                    <div class="table-data tdContent action d-flex">
                                                        @if (!Auth::user()->hasRole('Viewer Admin'))
                                                            <!-- pending -->
                                                            @if ($printCard->print_status == 'pending')
                                                                <form
                                                                    action="{{ route('printings.to_print', $printCard->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button class="bulid" type="submit">Pending</button>
                                                                </form>
                                                            @elseif ($printCard->print_status == 'printing')
                                                                <div class="bulid bg-success text-white">Printing</div>
                                                            @endif
                                                            <!-- send -->
                                                            @if ($printCard->send_status == 'send')
                                                                <form
                                                                    action="{{ route('printings.to_sent', $printCard->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button class="bulid" type="submit">Send</button>
                                                                </form>
                                                            @elseif ($printCard->send_status == 'sent')
                                                                <div class="bulid sent">Sent</div>
                                                            @endif
                                                            <!-- confirm -->
                                                            @if ($printCard->confirm_status == null)
                                                                <button class="bulid btns" data-bs-toggle="modal"
                                                                    data-bs-target="#printingConfirm{{ $printCard->id }}">Confirm</button>
                                                            @elseif ($printCard->confirm_status == 'done')
                                                                <div class="bulid done btns">Done</div>
                                                            @elseif ($printCard->confirm_status == 'cancel')
                                                                <div class="bulid cancel btns" role="button"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#printingCancelReason{{ $printCard->id }}">
                                                                    Cancel</div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                @push('modals')
                                                    <!-- Modal 1-->
                                                    <div class="modal fade" id="printingConfirm{{ $printCard->id }}"
                                                        tabindex="-1" aria-labelledby="printingConfirmLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="codeConfirm">
                                                                        <!-- start confirm printing form -->
                                                                        <div class="animate__animated PrintingPlanForm">
                                                                            <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                                                alt="">
                                                                            <div class="container">
                                                                                <form method="post"
                                                                                    action="{{ route('printings.to_confirm', [$print->id, $printCard->id]) }}">
                                                                                    @csrf
                                                                                    <h2>Enter Status</h2>
                                                                                    <div class="form-row row mt-2">
                                                                                        <div
                                                                                            class="form-group col-md-12 doneBtn">
                                                                                            <input type="radio"
                                                                                                name="cancelOrDone"
                                                                                                id="inputEmail4{{ $printCard->id }}"
                                                                                                value="done" required>
                                                                                            <label class="m-0"
                                                                                                for="inputEmail4{{ $printCard->id }}">Done</label>
                                                                                        </div>
                                                                                        <div
                                                                                            class="form-group col-md-12 canselBtn">
                                                                                            <input type="radio"
                                                                                                name="cancelOrDone"
                                                                                                id="inputEmail5{{ $printCard->id }}"
                                                                                                value="cancel" required>
                                                                                            <label class="m-0"
                                                                                                for="inputEmail5{{ $printCard->id }}">Cancel</label>
                                                                                        </div>
                                                                                        <div class="form-group col-md-12 textareaForm"
                                                                                            id="cancellationReason{{ $printCard->id }}">
                                                                                            <label
                                                                                                for="inputEmail5{{ $printCard->id }}"
                                                                                                class="animate__animated">
                                                                                                Reason for cancellation
                                                                                                <textarea name="reason" id="reason" rows="4" cols="25" style="width: 80%"></textarea>
                                                                                            </label>
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
                                                    <!-- Modal 2-->
                                                    <div class="modal fade" id="printingEdit{{ $printCard->id }}"
                                                        tabindex="-1" aria-labelledby="printingEditLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog enterCodeForm">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                                        alt="">
                                                                    <div class="codeEdit">
                                                                        <div>Enter The Code</div>
                                                                        <form method="post"
                                                                            action="{{ route('printings.update_code', $printCard->id) }}">
                                                                            <div class="mt-3">
                                                                                @csrf

                                                                                <div class="form-group col-md-12 ">
                                                                                    <input name="card_code" type="text"
                                                                                        class="form-control"
                                                                                        id="card_code{{ $printCard->id }}"
                                                                                        value="{{ $printCard->card_code }}"
                                                                                        placeholder="#00000"></input>
                                                                                </div>

                                                                            </div>
                                                                            <div class="btns mt-3">
                                                                                <div class="d-flex">
                                                                                    <button type="submit"
                                                                                        class="btn mx-4 black"
                                                                                        id="accept_code{{ $printCard->id }}"
                                                                                        disabled="disabled">Accept</button>
                                                                                    <button type="button" class="btn lite"
                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal 3-->
                                                    <div class="modal fade printingCancelReason"
                                                        id="printingCancelReason{{ $printCard->id }}" tabindex="-1"
                                                        aria-labelledby="printingCancelReasonLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <img src="{{ asset('admin/images/Ellipse19.png') }}"
                                                                        alt="" srcset="">
                                                                    <div>The Reason For Cancelation</div>
                                                                    <div class="mt-3">{{ $printCard->confirm_reason }}</div>
                                                                    <div class="mt-5">
                                                                        <form
                                                                            action="{{ route('printings.returncancel', $printCard->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <button type="submit" role="button"
                                                                                class="btn btn-sm btn-dark mx-4 black"
                                                                                id="returncancel{{ $printCard->id }}">Return</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            const radioButtons = document.querySelectorAll('input[name="cancelOrDone"]');
                                                            const cancellationReason = document.getElementById('cancellationReason{{ $printCard->id }}');

                                                            radioButtons.forEach(radio => {
                                                                cancellationReason.style.display = 'none';

                                                                radio.addEventListener('change', function() {
                                                                    if (document.getElementById('inputEmail5{{ $printCard->id }}').checked) {
                                                                        cancellationReason.style.display = 'block';
                                                                    } else {
                                                                        cancellationReason.style.display = 'none';
                                                                    }
                                                                });
                                                            });
                                                        });

                                                        $(document).ready(function() {
                                                            $('#card_code{{ $printCard->id }}').on('input', function() {
                                                                var input = $(this);
                                                                var button = $('#accept_code{{ $printCard->id }}');
                                                                var inputValue = input.val();

                                                                if (inputValue.length === 8) {
                                                                    button.removeAttr('disabled');
                                                                } else {
                                                                    button.attr('disabled', 'disabled');
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                @endpush
                                            @empty
                                                <div class="d-flex justify-content-around align-items-center">
                                                    <div>No Cards for Printing Exist.</div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="d-flex justify-content-around align-items-center">
                                    <div>No Printings Exist.</div>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
            <!-- pagination -->
            <nav aria-label="Page navigation example" class="pagination">
                <ul class="pagination">
                    {{ $printings->links() }}
                </ul>
            </nav>
            <!-- end pagination -->
        </div>
    </section>
    <!-- end DATA table -->
@endsection

@section('script')
    <script>
        document.getElementById('create_date_from').addEventListener('change', updateDateFiltercreate_date);
        document.getElementById('create_date_to').addEventListener('change', updateDateFiltercreate_date);

        function updateDateFiltercreate_date() {
            var fromDate = document.getElementById('create_date_from').value;
            var toDate = document.getElementById('create_date_to').value;
            var newUrl = window.location.pathname + '?create_date_from=' + encodeURIComponent(fromDate) +
                '&create_date_to=' + encodeURIComponent(toDate);
            window.location.href = newUrl;
        }

        document.getElementById('delivery_date_from').addEventListener('change', updateDateFilterdelivery_date);
        document.getElementById('delivery_date_to').addEventListener('change', updateDateFilterdelivery_date);

        function updateDateFilterdelivery_date() {
            var fromDate = document.getElementById('delivery_date_from').value;
            var toDate = document.getElementById('delivery_date_to').value;
            var newUrl = window.location.pathname + '?delivery_date_from=' + encodeURIComponent(fromDate) +
                '&delivery_date_to=' + encodeURIComponent(toDate);
            window.location.href = newUrl;
        }


        $('#printing').addClass('sidebar_active rounded-pill');
    </script>
@endsection
