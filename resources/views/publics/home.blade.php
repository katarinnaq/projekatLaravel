@extends('publics.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Eterna</h1>

        <nav class="d-flex align-items-center">
            <ul class="nav me-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Svi proizvodi</a>
                </li>


                @if(auth()->user()?->role === 'user')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carts.index') }}">Moja korpa</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index') }}">Moje porudzbine</a>
                </li>
                @endif

            </ul>

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
            @else
                <div class="dropdown">
                    <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </nav>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($products as $product)
        <div class="col">
            <div class="card h-100">
                <a href="{{ route('products.show', $product->id) }}">
                    <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top img-fluid" style="height:250px; object-fit:cover;" alt="{{ $product->naziv }}">
                </a>

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
            <p class="text-center">Nema proizvoda za prikaz.</p>
        @endforelse
    </div>
</div>
@endsection
