@extends('publics.app')

@section('content')
<div class="container mt-5">
    <h1>Porudžbina broj{{ $order->id }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <p><strong>Status porudžbine:</strong> {{ $order->status }}</p>

    @if($order->orderItems->isEmpty())
        <p>Ova porudžbina još nema stavki.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>Proizvod</th>
                    <th>Cena po komadu</th>
                    <th>Količina</th>
                    <th>Ukupno</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($order->orderItems as $item)
                    @php
                        $subtotal = $item->cena * $item->kolicina;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item->product->naziv }}</td>
                        <td>{{ number_format($item->cena, 2, ',', '.') }} RSD</td>
                        <td>{{ $item->kolicina }}</td>
                        <td>{{ number_format($subtotal, 2, ',', '.') }} RSD</td>
                    </tr>
                @endforeach
                <tr class="fw-bold">
                    <td colspan="3" class="text-end">Ukupno:</td>
                    <td>{{ number_format($total, 2, ',', '.') }} RSD</td>
                </tr>
            </tbody>
        </table>
    @endif

    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Nazad na proizvode</a>

    
</div>
@endsection
