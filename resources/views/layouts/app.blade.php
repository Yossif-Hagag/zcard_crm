<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Z-Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">




    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                height: 100vh;
                padding: 48px 0;
                background-color: #f8f9fa;
            }
        }
    </style>
    <script>
        var test = null
    </script>
    @yield('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">
    @livewireStyles
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
    <link rel="stylesheet" href="{{ asset('admin/css/dash.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/printing.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/shipping.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/accounting.css') }}">


    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>





</head>

<body>
    <div class="mainDiv">


        <div class="flex-shrink-0 p-3 bg-white " style="width: 280px;">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" id="btnSideBar" data-toggle="collapse"
                    data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-play ml-1"></i>

                </button>
            </nav>
            <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                <img src="{{ asset('admin/images/setting1.png') }}" alt="" srcset="">
                <span class="fs-5 fw-semibold">Z-CARD</span>
            </a>
            @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Viewer Admin'))
                <a href="{{ route('home') }}"
                    class="btn btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'home') active @endif">
                    Dashbrord
                </a>
            @endif
            <ul class="list-unstyled ps-0 mainSideBar">


                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Viewer Admin'))
                    <li class="mb-1">

                        <button
                            class="btn btnD btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'users.index' ||
                                    Route::currentRouteName() == 'roles.index' ||
                                    Route::currentRouteName() == 'permissions.index') active @endif"
                            data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                            Authentecation<i
                                class="fa-solid fa-chevron-down @if (Route::currentRouteName() == 'roles.archive' ||
                                        Route::currentRouteName() == 'permissions.index' ||
                                        Route::currentRouteName() == 'users.index') rotato @endif"></i>

                        </button>

                        <div class="collapse @if (Route::currentRouteName() == 'roles.index' ||
                                Route::currentRouteName() == 'permissions.index' ||
                                Route::currentRouteName() == 'users.index') show @endif" id="dashboard-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li>
                                    <a href="{{ route('users.index') }}"
                                        class="@if (Route::currentRouteName() == 'users.index') active @endif">
                                        <i class="bi bi-circle"></i><span>Users</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('roles.index') }}"
                                        class="@if (Route::currentRouteName() == 'roles.index') active @endif">
                                        <i class="bi bi-circle"></i><span>Roles</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('permissions.index') }}"
                                        class="@if (Route::currentRouteName() == 'permissions.index') active @endif">
                                        <i class="bi bi-circle"></i><span>Permissions</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif



                <li class="mb-1">
                    @can('crm')
                        <button
                            class="btn btnD btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'leads.index' ||
                                    Route::currentRouteName() == 'leads.archive' ||
                                    Route::currentRouteName() == 'deals.archive' ||
                                    Route::currentRouteName() == 'stages.index' ||
                                    Route::currentRouteName() == 'sources.index' ||
                                    Route::currentRouteName() == 'contracts.index' ||
                                    Route::currentRouteName() == 'deals.index') active @endif"
                            data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                            CRM<i class="fa-solid fa-chevron-down @if (Route::currentRouteName() == 'leads.index' ||
                                    Route::currentRouteName() == 'leads.archive' ||
                                    Route::currentRouteName() == 'deals.archive' ||
                                    Route::currentRouteName() == 'stages.index' ||
                                    Route::currentRouteName() == 'sources.index' ||
                                    Route::currentRouteName() == 'contracts.index' ||
                                    Route::currentRouteName() == 'deals.index') rotato @endif"></i>
                        </button>
                    @endcan
                    <div class="collapse @if (Route::currentRouteName() == 'leads.index' ||
                            Route::currentRouteName() == 'leads.archive' ||
                            Route::currentRouteName() == 'deals.archive' ||
                            Route::currentRouteName() == 'stages.index' ||
                            Route::currentRouteName() == 'sources.index' ||
                            Route::currentRouteName() == 'contracts.index' ||
                            Route::currentRouteName() == 'deals.index') show @endif" id="orders-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">


                            @can('view-any', App\Models\Lead::class)
                                <li>
                                    <a href="{{ route('leads.index') }}"
                                        class="@if (Route::currentRouteName() == 'leads.index') active @endif">
                                        <i class="bi bi-circle"></i><span>Leads</span>
                                    </a>
                                </li>
                            @endcan

                            @can('view-any', App\Models\User::class)
                                <li>
                                    <a href="{{ route('leads.archive') }}"
                                        class="@if (Route::currentRouteName() == 'leads.archive') active @endif">
                                        <i class="bi bi-circle"></i><span>Archive Leads</span>
                                    </a>
                                </li>
                            @endcan

                            @can('view-any', App\Models\Deal::class)
                                <li class="nav-item">
                                    <a class="@if (Route::currentRouteName() == 'deals.index') active @endif"
                                        href="{{ route('deals.index') }}">
                                        <i class="bi bi-person"></i>
                                        <span>Deals</span>
                                    </a>
                                </li><!-- End Profile Page Nav -->
                            @endcan


                            @can('view-any', App\Models\User::class)
                                <li>
                                    <a href="{{ route('deals.archive') }}"
                                        class="@if (Route::currentRouteName() == 'deals.archive') active @endif">
                                        <i class="bi bi-circle"></i><span>Archive Deals</span>
                                    </a>
                                </li>
                            @endcan

                            @can('view-any', App\Models\Stage::class)
                                <li>
                                    <a href="{{ route('stages.index') }}"
                                        class="@if (Route::currentRouteName() == 'stages.index') active @endif">
                                        <i class="bi bi-circle"></i><span>Stages</span>
                                    </a>
                                </li>
                            @endcan

                            @can('view-any', App\Models\Stage::class)
                                <li>
                                    <a href="{{ route('sources.index') }}"
                                        class="@if (Route::currentRouteName() == 'sources.index') active @endif">
                                        <i class="bi bi-circle"></i><span>Sources</span>
                                    </a>
                                </li>
                            @endcan





                            @can('view-any', App\Models\Contract::class)
                                <li>
                                    <a href="{{ route('contracts.index') }}"
                                        class="@if (Route::currentRouteName() == 'contracts.index') active @endif">
                                        <i class="bi bi-circle"></i><span>Contracts</span>
                                    </a>
                                </li>
                            @endcan


                        </ul>
                    </div>
                </li>



                @can('view-any', App\Models\Card::class)
                    <li class="mb-1">
                        <a class="btn btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'cards.index') active @endif"
                            href="{{ route('cards.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Cards</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                @endcan

                @can('view-any', App\Models\Printing::class)
                    <li class="mb-1" id="printing">
                        <a class="btn btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'printings.index') active @endif"
                            href="{{ route('printings.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Printings</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                @endcan

                @can('view-any', App\Models\Shipping::class)
                    <li class="mb-1" id="shipping">
                        <a class="btn btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'shippings.index') active @endif"
                            href="{{ route('shippings.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Shipping</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                @endcan
                @if (Auth::user()->hasRole('Super Admin'))
                    <li class="mb-1" id="Rnew">
                        <a class="btn btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'renew.index') active @endif"
                            href="{{ route('renew.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Renew</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                @endif
                @can('list todo')
                    <li class="mb-1">
                        <a class="btn btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'todos.index') active @endif"
                            href="{{ route('todos.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Todo</span>
                        </a>
                    </li><!-- End Profile Page Nav -->
                @endcan

                @if (Auth::user()->hasRole('Super Admin'))
                    <li class="mb-1">
                        {{-- @can('Accounting') --}}
                        <button
                            class="btn btnD btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'accounting.index' || Route::currentRouteName() == 'income') active @endif"
                            data-bs-toggle="collapse" data-bs-target="#acc-collapse" aria-expanded="false">
                            Accounting<i
                                class="fa-solid fa-chevron-down @if (Route::currentRouteName() == 'accounting.index' || Route::currentRouteName() == 'income') rotato @endif"></i>
                        </button>
                        {{-- @endcan --}}
                        <div class="collapse @if (Route::currentRouteName() == 'accounting.index' || Route::currentRouteName() == 'income') show @endif" id="acc-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li>
                                    <a href="{{ route('accounting.index') }}"
                                        class="@if (Route::currentRouteName() == 'accounting.index') active @endif">
                                        <i class="bi bi-circle"></i><span>Home</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('income') }}"
                                        class="@if (Route::currentRouteName() == 'income') active @endif">
                                        <i class="bi bi-circle"></i><span>Income</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{--
                    <li class="mb-1">
                        <a class="btn btn-toggle align-items-center rounded collapsed @if (Route::currentRouteName() == 'accounting.index') active @endif"
                            href="{{ route('accounting.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Accounting</span>
                        </a>
                    </li><!-- End Profile Page Nav --> --}}
                @endif

                <li class="mb-1">
                    <a class="btn btn-toggle align-items-center rounded massenger collapsed"
                        href="{{ route('chats.index') }}">
                        <i class="bi bi-person"></i>
                        <span>Massenger</span>
                    </a>
                </li><!-- End Profile Page Nav -->


            </ul>
            <div class="user">
                <div class="image">
                    <img src="{{ asset('admin/images/Ellipse 8.png') }}" alt="">
                </div>
                <div class="nameAndJobTitle">
                    <div>
                        <div class="name">{{ Auth::user()->name }}</div>
                        <div class="jobTitle">Project Manager</div>
                    </div>


                    <div class="icon">

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket"></i>

                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="sideClose"></div>

        <main class="ms-sm-auto w-100">
            <div class="">
                <section class="section1">
                    <div class="s1">
                        <h3>Hello {{ auth()->user()->name }} 👋</h3>
                        <div class="titlePage">@yield('titlePage') </div>
                        <div class="path">@yield('path')</div>
                    </div>

                    @yield('search')

                </section>

                @yield('content')
            </div>
        </main>

        @stack('modals')

        <!-- ======= Footer ======= -->
        @livewireScripts
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
            integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>


        <script src="{{ asset('admin/js/dash.js') }}"></script>
        @yield('script')
</body>

</html>
