@extends('publics.app')

@section('content')
<div class="container mt-5">
    <h1>Detalji proizvoda</h1>

    <!-- Poruka za uspeh dodavanja u korpu -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top mb-3" alt="{{ $product->naziv }}" style="width: 400px; height: auto;">
            <h5 class="card-title">{{ $product->naziv }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
                Kategorija: {{ $product->kategorija->naziv ?? '-' }}
            </h6>

            <p class="mb-1"><strong>Tip vode:</strong> {{ $product->tip_vode }}</p>
            <p class="mb-1"><strong>Opis:</strong> {{ $product->opis ?? '-' }}</p>
            <p class="mb-1"><strong>Cena:</strong> {{ number_format($product->cena, 2, ',', '.') }} RSD</p>
            <p class="mb-1"><strong>Ambalaža:</strong> {{ $product->ambalaza }}</p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline mt-2">
                @csrf
                <button type="submit" class="btn btn-success">Dodaj u korpu</button>
            </form>

            <a href="{{ route('home') }}" class="btn btn-secondary mt-2">Nazad na proizvode</a>

            @if(auth()->user()?->role === 'admin')
                <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Nazad</a>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mt-3">Izmeni</a>
            @endif
        </div>
    </div>
</div>
@endsection
