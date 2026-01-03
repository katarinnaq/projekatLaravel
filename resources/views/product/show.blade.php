@extends('publics.app')

@section('content')
<div class="container mt-5">
    <h1>Detalji proizvoda</h1>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">{{ $product->naziv }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
                Kategorija: {{ $product->kategorija->naziv ?? '-' }}
            </h6>

            <p class="mb-1"><strong>Tip vode:</strong> {{ $product->tip_vode }}</p>
            <p class="mb-1"><strong>Opis:</strong> {{ $product->opis ?? '-' }}</p>
            <p class="mb-1"><strong>Cena:</strong> {{ number_format($product->cena, 2, ',', '.') }} RSD</p>
            <p class="mb-1"><strong>Ambalaža:</strong> {{ $product->ambalaza }}</p>

            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Nazad</a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mt-3">Izmeni</a>
        </div>
    </div>
</div>
@endsection
