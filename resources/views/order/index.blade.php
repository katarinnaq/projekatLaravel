@extends('publics.app')

@section('content')
<div class="container mt-5">
    <h1>Porudžbine</h1>

    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <p class="mt-3">Nema porudžbina za prikaz.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>ID porudzbine</th>
                    <th>Stavke</th>
                    <th>Ukupno</th>
                    <th>Status</th>
                    @if(auth()->user()?->role === 'admin')
                        <th>Akcija</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @php
                        $total = $order->orderItems->sum(fn($item) => $item->cena * $item->kolicina);
                    @endphp
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            <ul class="mb-0">
                                @foreach($order->orderItems as $item)
                                    <li>{{ $item->product->naziv }} x {{ $item->kolicina }} ({{ number_format($item->cena,2,',','.') }} RSD)</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ number_format($total,2,',','.') }} RSD</td>
                        <td>
                            <span class="badge 
                                @if($order->status === 'na cekanju') bg-warning
                                @elseif($order->status === 'u obradi') bg-info
                                @elseif($order->status === 'poslata') bg-primary
                                @elseif($order->status === 'zavrsena') bg-success
                                @endif
                            ">{{ $order->status }}</span>
                        </td>


                        @if(auth()->user()?->role === 'admin')
                            <td>
                                <div class="d-flex align-items-center">
                                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline me-2">
                                        @csrf
                                        @method('PATCH')
                                       <select name="status" class="form-select d-inline w-auto">
                                        <option value="na cekanju" {{ $order->status == 'na cekanju' ? 'selected' : '' }}>Na čekanju</option>
                                        <option value="u obradi" {{ $order->status == 'u obradi' ? 'selected' : '' }}>U obradi</option>
                                        <option value="poslata" {{ $order->status == 'poslata' ? 'selected' : '' }}>Poslata</option>
                                        <option value="zavrsena" {{ $order->status == 'zavrsena' ? 'selected' : '' }}>Završena</option>
                                    </select>

                                        <button type="submit" class="btn btn-warning ms-2">Promeni status</button>
                                    </form>

                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovu porudžbinu?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-2">Obriši porudžbinu</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
