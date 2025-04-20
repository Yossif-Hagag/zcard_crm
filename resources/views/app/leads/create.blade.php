@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="editLeadPage">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('leads.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.leads.create_title')
                </h4>

                <x-form method="POST" action="{{ route('leads.store') }}" class="mt-4">
                    @include('app.leads.form-inputs')

                    <div class="mt-4">
                        <a href="{{ route('leads.index') }}" class="btn btnBlack">
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <button type="submit" class="btn btnBlack float-right">
                            <i class="icon ion-md-save"></i>
                            @lang('crud.common.create')
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@endsection
