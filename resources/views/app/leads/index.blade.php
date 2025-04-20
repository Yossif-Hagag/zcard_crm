@php
    use App\Models\Shipping;
@endphp
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

    <section class="section2 d-flex ">

        <div class="status main">
            <button class="all">SelectAll</button>
            <button class="dis">Dis Select</button>
            <form id="deleteForm" method="POST" action="{{ route('leads.archive.all') }}">
                @csrf
                <input type="hidden" id="deleteSelectedLeadId" name="lead_id" value="">
                <input type="hidden" id="selecteddeleted_at" name="deleted_at" value="2024-09-05 12:03:27">
                <button type="submit" id="deleteButton" class="archive">Archive</button>
            </form>
            <form id="convertForm" method="POST" action="{{ route('leads.convert') }}">
                @csrf
                <input type="hidden" id="convertSelectedLeadId" name="lead_id" value="">
                <input type="hidden" id="selectedUserId" name="user_id" value="">
                <input type="hidden" id="selectedStageId" name="stage_id" value="">

                <input type="hidden" id="sameStatusValue" name="same_status">
                <input type="hidden" id="newStatusValue" name="new_status">

                <button type="submit" id="convertButton" class="convert">Convert Leads</button>
            </form>
            <button type="submit" class="reqorts">Leads Report</button>


            <span id="selectedCount">Selected Leads: 0</span>
        </div>
        <div class="usersStatus main">
            <div class="statuss">
                <div class="sameStatus">
                    <label for="SameStatus">Same Status:</label>
                    <label class="switch">
                        <input type="checkbox" id="SameStatus">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="newStatus">
                    <label for="NewStatus">New Status:</label>
                    <label class="switch">
                        <input type="checkbox" id="NewStatus">
                        <span class="slider round red"></span>
                    </label>
                </div>
            </div>



            <div class="options">
                <select id="userSelect" name="user_id">
                    <option value="">Select a user</option>
                    @foreach ($userss as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

            </div>
        </div>
    </section>

    <div class="searchingTableSection">
        <div class="d-flex" style="align-items: center;gap:10px;white-space: nowrap;">
            @if (Auth::user()->hasRole('Super Admin') ||
                    Auth::user()->hasRole('Director') ||
                    Auth::user()->hasRole('Team Leader') ||
                    Auth::user()->hasRole('Social Media Boy'))
                <a class="btn btn-success" href="{{ route('leads_download_template') }}"
                    style="height: 30px; font-size: small">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    {{ __('Download template') }}
                </a>
                <div>
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data" class="fileForm">
                        @csrf
                        <button type="submit" class="btn btn-dark">Import Leads</button>
                        <label for="chouseFileLead" class="chooseF">
                            <div class="">Choose File</div>
                        </label>
                        <input type="file" name="file" accept=".xlsx" class="FillBtnLeads" id="chouseFileLead">
                    </form>

                </div>
            @endif
        </div>

        <div class="icons">
            @if (!Auth::user()->hasRole('Social Media Boy'))
                <a href="{{ route('export') }}">
                    Export <img src="{{ asset('fro/images/icons/new-file.png') }}" class="icon" alt="">
                </a>
            @endif
            @if (Auth::user()->hasRole('Super Admin') ||
                    Auth::user()->hasRole('Director') ||
                    Auth::user()->hasRole('Team Leader') ||
                    Auth::user()->hasRole('Social Media Boy'))
                <button id="addLead" class="icon">+</button>
            @endif
        </div>
    </div>

    <!-- end searching with name and numbers -->

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
    <section class="section3">
        <div class="tableData">
            <form id="filterForm" method="GET" action="{{ route('leads.index') }}"
                onsubmit="disableInputBeforeSubmit()">
                <table class="table leadsTableF">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-left">@lang('crud.leads.inputs.name')</th>
                            <th class="text-left">@lang('crud.leads.inputs.phone')</th>
                            <th class="text-left">@lang('crud.leads.inputs.contract_id')</th>
                            <th class="text-left">@lang('crud.leads.inputs.follow_date')</th>
                            <th class="text-left">@lang('crud.leads.inputs.create_date')</th>
                            <th class="text-left">@lang('crud.leads.inputs.stage_id')</th>
                            <th class="text-left">@lang('crud.leads.inputs.source')</th>
                            @if (!Auth::user()->hasRole('Sales'))
                                <th class="text-left">@lang('crud.leads.inputs.user')</th>
                            @endif
                            @if (!Auth::user()->hasRole('Social Media Boy'))
                                <th class="text-left">@lang('crud.leads.inputs.deliveryboy')</th>
                            @endif
                            <th class="text-center">@lang('crud.common.actions')</th>
                        </tr>
                        <tr>
                            <th class="align-content-around"></th>
                            <th class="align-content-around text-left">
                                <input type="text" name="name" value="{{ request('name') }}" placeholder="Name">
                            </th>
                            <th class="align-content-around text-left">
                                <input type="text" name="phone" value="{{ request('phone') }}"
                                    placeholder="Phone">
                            </th>
                            <th class="align-content-around text-left">
                                <select name="contract_id" id="contract_id">
                                    <option value="" {{ request('contract_id') ? '' : 'selected' }}>Contract
                                    </option>
                                    @foreach ($contracts as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ request('contract_id') == $id ? 'selected' : '' }}>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="align-content-around text-left">
                                <div class="d-flex flex-column gap-2">
                                    <input type="date" name="follow_date_from" id="follow_date_from"
                                        value="{{ $followDateFrom ?? null }}" placeholder="Create Date From">
                                    <input type="date" name="follow_date_to" id="follow_date_to"
                                        value="{{ $followDateTo ?? null }}" placeholder="Create Date To">
                                </div>
                            </th>
                            <th class="align-content-around text-left">
                                <div class="d-flex flex-column gap-2">
                                    <input type="date" name="create_date_from" id="create_date_from"
                                        value="{{ $createDateFrom ?? null }}" placeholder="Create Date From">
                                    <input type="date" name="create_date_to" id="create_date_to"
                                        value="{{ $createDateTo ?? null }}" placeholder="Create Date To">
                                </div>

                            </th>
                            <th class="align-content-around text-left">
                                <select name="stage_id" id="stage_id">
                                    <option value="" {{ request('stage_id') ? '' : 'selected' }}>Stage</option>
                                    @foreach ($stages as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ request('stage_id') == $id ? 'selected' : '' }}>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="align-content-around text-left">
                                <select name="source_id" id="source_id">
                                    <option value="" {{ request('source_id') ? '' : 'selected' }}>Source</option>
                                    @foreach ($sources as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ request('source_id') == $id ? 'selected' : '' }}>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </th>
                            @if (!Auth::user()->hasRole('Sales'))
                                @if (!Auth::user()->hasRole('Team Leader'))
                                    @if (!Auth::user()->hasRole('Social Media Boy'))
                                        <th class="align-content-around text-left">
                                            <select name="user_id" id="user_id" class="w-100">
                                                <option value="" {{ request('user_id') ? '' : 'selected' }}>User
                                                </option>
                                                <option value="without"
                                                    {{ request('user_id') == 'without' ? 'selected' : '' }}>Without
                                                </option>
                                                @foreach ($userss as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </th>
                                    @endif
                                @else
                                    <th class="align-content-around text-left">
                                        <select name="user_id" id="user_id">
                                            <option value="" {{ request('user_id') ? '' : 'selected' }}>User
                                            </option>
                                            @foreach ($userss as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </th>
                                @endif
                            @endif
                            {{-- <th class="align-content-around text-left">@lang('crud.leads.inputs.deliveryboy')</th> --}}
                            <th class="align-content-around text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="display:none;">
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td>*</td>
                            <td class="action" style="width: 134px;">

                                <a href="">
                                    <img src="{{ asset('admin/images/icons/view.png') }}" alt="">
                                </a>
                                <a href="">
                                    <img src="{{ asset('admin/images/icons/edit.png') }}" alt="">
                                </a>


                                <form action="" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    onsubmit="disableInputBeforeSubmit()">
                                    @csrf
                                    <button type="submit" class="btn btn-light text-danger">
                                        <div class="tdContent">
                                            <img src="{{ asset('admin/images/icons/delete.png') }}" alt="">
                                        </div>
                                    </button>
                                </form>

                            </td>

                        </tr>
                        @forelse($leads as $lead)
                            <tr>

                                <td class="text-center">
                                    <input type="checkbox" id="checkbox-{{ $lead->id }}" class="lead-checkbox "
                                        value="{{ $lead->id }}" />

                                </td>
                                <td>{{ $lead->name ?? '-' }}</td>
                                <td>{{ $lead->phone ?? '-' }}</td>
                                <td>{{ optional($lead->contract)->name ?? '-' }}</td>
                                <td>{{ $lead->follow_date ? $lead->follow_date->format('Y-m-d') : '-' }}</td>
                                <td>{{ $lead->created_at ? $lead->created_at->format('Y-m-d') : '-' }}</td>
                                <td>{{ optional($lead->stage)->name ?? '-' }}</td>
                                <td>{{ optional($lead->source)->name ?? '-' }}</td>
                                @if (!Auth::user()->hasRole('Sales'))
                                    <td class="text-center">
                                        @if ($lead->users->isNotEmpty())
                                            <div class="user-images">
                                                @foreach ($lead->users as $user)
                                                    <P>{{ $user->name }}</P>
                                                @endforeach
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endif
                                @section('script')
                                    <script>
                                        $(document).ready(function() {
                                            // Function to update selected leads
                                            function updateSelectedLeads() {
                                                var selectedIds = [];
                                                $('.lead-checkbox:checked').each(function() {
                                                    selectedIds.push($(this).val());
                                                });
                                                $('#convertSelectedLeadId').val(selectedIds.join(','));
                                                $('#deleteSelectedLeadId').val(selectedIds.join(','));
                                                $('#selectedCount').text('Selected Leads: ' + selectedIds.length);
                                            }

                                            // Update hidden input fields based on user selection
                                            $('#userSelect').change(function() {
                                                var userId = $(this).val();
                                                $('#selectedUserId').val(userId);

                                                // Show stage select if a user is selected, otherwise hide it
                                                if (userId) {
                                                    $('#stageSelect').show();
                                                } else {
                                                    $('#stageSelect').hide();
                                                    $('#selectedStageId').val(''); // Clear stage selection if no user is selected
                                                }
                                            });

                                            // Update hidden input field based on stage selection
                                            $('#stageSelect').change(function() {
                                                var stageId = $(this).val();
                                                $('#selectedStageId').val(stageId);
                                            });

                                            // Handle individual checkbox change
                                            $('.lead-checkbox').change(function() {
                                                updateSelectedLeads();
                                            });

                                            // Handle Select All button click
                                            $('.all').click(function() {
                                                $('.lead-checkbox').prop('checked', true);
                                                updateSelectedLeads();
                                            });

                                            // Handle Deselect All button click
                                            $('.dis').click(function() {
                                                $('.lead-checkbox').prop('checked', false);
                                                updateSelectedLeads();
                                            });
                                        });
                                    </script>
                                @endsection


                                <style>
                                    .user-images {
                                        display: flex;
                                        justify-content: center;
                                        /* Centers images horizontally */
                                        align-items: center;
                                        /* Centers images vertically */
                                    }

                                    .circle-image {
                                        width: 40px;
                                        height: 40px;
                                        border-radius: 40%;
                                        object-fit: cover;
                                        margin-left: -15px;
                                        /* Adjust this value to control the overlap */
                                        border: 2px solid white;
                                        /* Optional: Adds a white border around the images */
                                    }

                                    .circle-image:first-child {
                                        margin-left: 0;
                                        /* No overlap for the first image */
                                    }
                                </style>


                                @if (!Auth::user()->hasRole('Social Media Boy'))
                                    <td>
                                        <div class="btn btn-sm btn-info deliveryBoy btns" role="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#printingdeliveryBoyReason{{ $lead->id }}">View</div>

                                        <div class="modal fade printingdeliveryBoyReason"
                                            id="printingdeliveryBoyReason{{ $lead->id }}" tabindex="-1"
                                            aria-labelledby="printingdeliveryBoyReasonLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">

                                                <div class="modal-content container">
                                                    <img src="{{ asset('admin/images/Ellipse19.png') }}" alt="">
                                                    <div class="modal-body d-flex flex-column">
                                                        <h3 class="mainTitleView">View Deals for Lead :
                                                            {{ $lead->name }}
                                                        </h3>
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Recipient</th>
                                                                    <th>Shipping Status</th>
                                                                    <th>Delivery Boy</th>
                                                                    <th>Attempts</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($lead->deals as $deal)
                                                                    @php
                                                                        $shipping = Shipping::where(
                                                                            'deal_id',
                                                                            $deal->id,
                                                                        )
                                                                            ->with('users')
                                                                            ->first();
                                                                    @endphp
                                                                    @if ($shipping)
                                                                        <tr>
                                                                            <td>{{ $shipping->defaultname }}</td>
                                                                            <td>{{ $shipping->shipping_status }}</td>
                                                                            <td>{{ $shipping?->users->first()->name ?? 'N/A' }}
                                                                            <td>{{ $shipping?->attempts ?? '0' }}
                                                                            </td>
                                                                        </tr>
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
                                        </div>
                                    </td>
                                @endif

                                <td class="action" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class="btn-group">
                                        @if (!Auth::user()->hasRole('Social Media Boy'))
                                            @can('view', $lead)
                                                <a href="{{ route('leads.show', $lead) }}"><button type="button"
                                                        class="btn btn-light">
                                                        <div class="tdContent">
                                                            <img src="{{ asset('admin/images/icons/view.png') }}"
                                                                alt="">
                                                        </div>
                                                    </button>
                                                </a>
                                            @endcan
                                        @endif
                                        @if (Auth::user()->hasRole('Super Admin') ||
                                                Auth::user()->hasRole('Director') ||
                                                Auth::user()->hasRole('Team Leader') ||
                                                Auth::user()->hasRole('Social Media Boy') ||
                                                Auth::user()->hasRole('Sales'))
                                            @can('update', $lead)
                                                <a href="{{ route('leads.edit', $lead) }}">
                                                    <button type="button" class="btn btn-light">
                                                        <div class="tdContent">
                                                            <img src="{{ asset('admin/images/icons/edit.png') }}"
                                                                alt="">
                                                        </div>
                                                    </button>
                                                </a>
                                            @endcan
                                        @endif

                                        @if (Auth::user()->hasRole('Super Admin'))
                                            @can('delete', $lead)
                                                <form action="{{ route('leads.destroy', $lead) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this lead?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    @if ($lead->deals()->exists())
                                                        <button type="button" class="btn btn-light text-danger" disabled>
                                                            <div class="tdContent">
                                                                <img src="{{ asset('admin/images/icons/delete.png') }}"
                                                                    alt="Delete Icon">
                                                            </div>
                                                        </button>
                                                    @else
                                                        <button type="submit" class="btn btn-light text-danger">
                                                            <div class="tdContent">
                                                                <img src="{{ asset('admin/images/icons/delete.png') }}"
                                                                    alt="Delete Icon">
                                                            </div>
                                                        </button>
                                                    @endif
                                                </form>
                                            @endcan
                                        @endif


                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">@lang('crud.common.no_items_found')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination d-flex justify-content-around align-content-around">{!! $leads->render() !!}</div>
            </form>
            </form>
        </div>
    </section>


    </main>
    <div class="bg-mian-dark animate__animated ">

        <div class="addForm container">
            <div class="cickMe"></div>

            <form method="POST" action="{{ route('leads.store') }}">
                @csrf
                <h2>Create Lead</h2>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Name</label>
                        <input name="name" type="text" class="form-control" id="inputEmail4"
                            value="{{ old('name') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPhone">Phone Number</label>
                        <input name="phone" type="text" class="form-control" id="inputPhone"
                            value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputPhone2">Phone Number (Optional)</label>
                        <input name="phone2" type="text" class="form-control" id="inputPhone2"
                            value="{{ old('phone2') }}">
                    </div>
                </div>
                @if (!Auth::user()->hasRole('Social Media Boy'))
                    <div class="userSelect">
                        <label for="users">User Select</label>
                    </div>
                    <select name="user_id" id="users" class="form-select">
                        @foreach ($userss as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                @endif


                <div class="row">
                    @if (Auth::user()->hasRole('Sales'))
                        <div class="form-group col-md-6">
                            <label for="stageSelect">Stage</label>
                            <select name="stage_id" class="form-select" id="stageSelect">
                                <option disabled {{ old('stage_id') ? '' : 'selected' }}>Please select the Stage</option>
                                @foreach ($stages as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('stage_id') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-group col-md-6">
                        <label for="sourceSelect">Source</label>
                        <select name="source_id" class="form-select" id="sourceSelect">
                            <option disabled {{ old('source_id') ? '' : 'selected' }}>Please select the Source</option>
                            @foreach ($sources as $value => $label)
                                <option value="{{ $value }}" {{ old('source_id') == $value ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label for="contractSelect">Follow Up Date</label>
                    <input name="follow_date" type="date" class="form-control" id="follow_date"
                        value="{{ old('follow_date') }}">
                </div>
                <div class="form-group">
                    <label for="contractSelect">Contract</label>
                    <select name="contract_id" class="form-select" id="contractSelect">
                        <option disabled {{ old('contract_id') ? '' : 'selected' }}>Please select the Contract</option>
                        @foreach ($contracts as $value => $label)
                            <option value="{{ $value }}" {{ old('contract_id') == $value ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="btns">
                    <button type="submit" class="btn dark">Create</button>
                    <button type="reset" class="btn lite">Close</button>
                </div>
        </div>
        </form>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Function to update selected leads
            function updateSelectedLeads() {
                var selectedIds = [];
                $('.lead-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });
                $('#convertSelectedLeadId').val(selectedIds.join(','));
                $('#deleteSelectedLeadId').val(selectedIds.join(','));
                $('#selectedCount').text('Selected Leads: ' + selectedIds.length);
            }

            // Update hidden input fields based on user selection
            $('#userSelect').change(function() {
                var userId = $(this).val();
                $('#selectedUserId').val(userId);

                // Show stage select if a user is selected, otherwise hide it
                if (userId) {
                    $('#stageSelect').show();
                } else {
                    $('#stageSelect').hide();
                    $('#selectedStageId').val(''); // Clear stage selection if no user is selected
                }
            });

            // Update hidden input field based on stage selection
            $('#stageSelect').change(function() {
                var stageId = $(this).val();
                $('#selectedStageId').val(stageId);
            });

            // Handle individual checkbox change
            $('.lead-checkbox').change(function() {
                updateSelectedLeads();
            });

            // Handle Select All button click
            $('.all').click(function() {
                $('.lead-checkbox').prop('checked', true);
                updateSelectedLeads();
            });

            // Handle Deselect All button click
            $('.dis').click(function() {
                $('.lead-checkbox').prop('checked', false);
                updateSelectedLeads();
            });
        });
    </script>
    <script>
        document.getElementById('convertForm').addEventListener('submit', function(event) {
            // Get checkbox states
            var sameStatusChecked = document.getElementById('SameStatus').checked;
            var newStatusChecked = document.getElementById('NewStatus').checked;


            // Update hidden input values based on checkbox states
            document.getElementById('sameStatusValue').value = sameStatusChecked ? 'true' : 'false';
            document.getElementById('newStatusValue').value = newStatusChecked ? 'true' : 'false';

            // Ensure a user is selected
            var selectedUser = document.getElementById('userSelect').value;
            if (selectedUser) {
                document.getElementById('selectedUserId').value = selectedUser;
            } else {
                alert('Please select a user.');
                event.preventDefault(); // Prevent form submission if no user is selected
            }
        });
    </script>

@endsection
