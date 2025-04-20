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
    </style>
@endsection
@section('titlePage')
    Manage Management System
@endsection
@section('path')
    <span><a class="text-decoration-none text-body" href="{{ route('home') }}">Dashbord</a> <i
            class="fa-solid fa-chevron-right"></i></span>
    <span><a class="text-decoration-none text-body" href="{{ route('printings.index') }}">Massenger</a> <i
            class="fa-solid fa-chevron-right"></i></span>
@endsection

@section('content')


            <livewire:chat />

@endsection

@section('script')
@endsection
