@extends('publics.app')

@section('content')
<div class="container mt-5">
    <h1>Moja korpa</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <p class="mt-3">Vaša korpa je prazna.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-2">Nazad na proizvode</a>
    @else
        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>Proizvod</th>
                    <th>Cena</th>
                    <th>Količina</th>
                    <th>Ukupno</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cartItems as $item)
                    @php $subtotal = $item->cena * $item->kolicina; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item->product->naziv }}</td>
                        <td>{{ number_format($item->cena, 2, ',', '.') }} RSD</td>
                        <td>{{ $item->kolicina }}</td>
                        <td>{{ number_format($subtotal, 2, ',', '.') }} RSD</td>
                        <td>
                            <form action="{{ route('cart-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Obrisati stavku?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Obriši</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr class="fw-bold">
                    <td colspan="3" class="text-end">Ukupno:</td>
                    <td>{{ number_format($total, 2, ',', '.') }} RSD</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('home') }}" class="btn btn-secondary">Nastavi kupovinu</a>
        <a href="#" class="btn btn-success">Završi kupovinu</a>
    @endif
</div>
@endsection
