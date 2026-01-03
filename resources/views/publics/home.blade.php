@extends('publics.app')

@section('content')
<div class="container mt-4">
    <!-- Header sa naslovom i navbarom -->
    <div class="d-flex  align-items-center mb-4">
        <h1 class="text">Eterna</h1>

        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Svi proizvodi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carts.index') }}">Moja korpa</a>
                </li>
               
            </ul>
        </nav>
    </div>

    <!-- Poruka za uspeh dodavanja u korpu -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Proizvodi -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($products as $product)
        <div class="col">
            <div class="card h-100">
                <!-- Slika proizvoda -->
                @if(isset($product->slika))
                    <img src="{{ asset('storage/' . $product->slika) }}" class="card-img-top" alt="{{ $product->naziv }}">
                @else
                       <a href="{{ route('products.show', $product->id) }}">
                            <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top img-fluid"  alt="{{ $product->naziv }}">
                        </a>
                @endif

                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->naziv }}</h5>
                    <p class="card-text fw-bold">{{ number_format($product->cena, 2, ',', '.') }} RSD</p>
                </div>

                <div class="card-footer text-center">
                   <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-75">Dodaj u korpu</button>
                    </form>

                </div>
            </div>
        </div>
        @empty
            <p>Nema proizvoda za prikaz.</p>
        @endforelse
    </div>
</div>
@endsection
