@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('cards.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.cards.show_title')
                </h4>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5>@lang('crud.cards.inputs.name')</h5>
                        <span>{{ $card->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.cards.inputs.cost')</h5>
                        <span>{{ $card->cost ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5>@lang('crud.cards.inputs.image')</h5>
                        <x-partials.thumbnail src="{{ $card->image ? \Storage::url($card->image) : '' }}" size="150" />
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('cards.index') }}" class="btn btn-light">
                        <i class="icon ion-md-return-left"></i>
                        Back to Index
                    </a>

                    @if (!Auth::user()->hasRole('Viewer Admin'))
                        @can('create', App\Models\Card::class)
                            <a href="{{ route('cards.create') }}" class="btn btn-light">
                                <i class="icon ion-md-add"></i> @lang('crud.common.create')
                            </a>
                        @endcan
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
