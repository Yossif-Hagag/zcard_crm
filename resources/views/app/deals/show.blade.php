@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('deals.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.deals.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.deals.inputs.customer_name')</h5>
                    <span>{{ $deal->customer_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.deals.inputs.customer_phone')</h5>
                    <span>{{ $deal->customer_phone ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.deals.inputs.customer_address')</h5>
                    <span>{{ $deal->customer_address ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.deals.inputs.cost')</h5>
                    <span>{{ $deal->cost ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.deals.inputs.deal_date')</h5>
                    <span>{{ $deal->deal_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.deals.inputs.delivery_date')</h5>
                    <span>{{ $deal->delivery_date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.deals.inputs.card_name')</h5>
                    <pre>{{ json_encode($deal->card_name) ?? '-' }}</pre>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.deals.inputs.lead_id')</h5>
                    <span>{{ optional($deal->lead)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('deals.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Deal::class)
                <a href="{{ route('deals.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
