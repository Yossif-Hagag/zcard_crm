@php
    use App\Models\Lead;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/dash.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/shipping.css') }}">
</head>
<style>
    .borderRest {
        border-top: 2px solid;
        border-bottom: 0px solid;
        padding: 10px 0px;
        font-size: small;
    }

    .shippingModalsBolesaa .logos {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .shippingModalsBolesaa .rewsetNum {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .logos {
        display: flex;
        justify-content: space-around;
        width: 100%;
    }
</style>

<body>
    <div class=" shippingModalsBolesaa" id="Bolesaa" tabindex="-1" aria-labelledby="BolesaaLabel" aria-hidden="fals">
        <div class="modal-dialog ShippingForms">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="" style="height: 90px">
                        <img src="{{ public_path('admin/images/qr.png') }}" style="float: right;" height="80"/>
                        <img src="{{ public_path('admin/images/nassar.png') }}" height="80"/>
                    </div>
                    <div class="rewsetNum borderRest">
                        <div style="float: right;" >465635264524</div>
                        <div>Shipper: Egypt</div>
                    </div>
                    <div class="address borderRest">
                        <div style="float: right;" >Address: October - Sheikh Zayed</div>
                        <div>Company Z-Card</div>
                    </div>
                    <div class="ToAndData borderRest">
                        <div>To: Egypt</div>
                        <div class="titles">Customer data</div>
                        <div>Name: {{ $shipp->lead->name }}</div>
                        <div>Phone: +{{ $shipp->lead->phone }}</div>
                        @php
                            $lead = Lead::with('addresses')
                                ->find($shipp->lead_id)
                                ->get();
                        @endphp
                        @forelse ($lead as $lea)
                            @if ($lea->id == $shipp->lead_id)
                                @foreach ($lea->addresses as $key => $address)
                                    <hr class="m-0">
                                    <div>
                                        <span>Address {{ ++$key }}:
                                            {{ $address->address }}</span>
                                        | <span>Building :
                                            {{ $address->building }}</span>
                                        | <span>Floor :
                                            {{ $address->floor }}</span>
                                        | <span>Flat Number :
                                            {{ $address->flat_number }}</span>
                                        | <span>State :
                                            {{ $address->state }}</span>
                                        | <span>City :
                                            {{ $address->city }}</span>
                                        | <span>Landmark :
                                            {{ $address->landmark }}</span>
                                    </div>
                                @endforeach
                            @endif
                        @empty
                            <div>Address: No Address Exist</div>
                        @endforelse
                    </div>

                    <div class="cash borderRest">
                        <div class="titles">Cash information</div>
                        <div>Total card: ({{ $shipp?->shipping_cards?->count() }})</div>
                        <div>Price: {{ $shipp->cost }} EGP
                        </div>
                    </div>

                    <div class="information borderRest">
                        <div class="titles">Egent information</div>
                        <div>Name: {{ $shipp->defaultname }}</div>
                        <div>Phone: +{{ $shipp->defaultphone }}</div>
                        <div>
                            <span>Address :
                                {{ $address->address }}</span>
                            | <span>Building :
                                {{ $address->building }}</span>
                            | <span>Floor :
                                {{ $address->floor }}</span>
                            | <span>Flat Number :
                                {{ $address->flat_number }}</span>
                            | <span>State :
                                {{ $address->state }}</span>
                            | <span>City :
                                {{ $address->city }}</span>
                            | <span>Landmark :
                                {{ $address->landmark }}</span>
                        </div>











                        نتسمؤنتسيبببببببببببببببببببببببببببببببببببببببببببببب
                        تنمياسبمسيابتسيابتناااااااااااااااااااا
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
