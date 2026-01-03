@extends('publics.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Proizvodi</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Dodaj novi proizvod</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Kategorija</th>
                <th>Tip vode</th>
                <th>Naziv</th>
                <th>Opis</th>
                <th>Cena</th>
                <th>Ambalaža</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->kategorija->naziv ?? '-' }}</td>
                <td>{{ $product->tip_vode }}</td>
                <td>{{ $product->naziv }}</td>
                <td>{{ $product->opis ?? '-' }}</td>
                <td>{{ number_format($product->cena, 2, ',', '.') }} RSD</td>
                <td>{{ $product->ambalaza }}</td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">Prikaži</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Izmeni</a>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Da li ste sigurni da želite obrisati ovaj proizvod?')">
                            Obriši
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Nema proizvoda</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- <!-- Pagination linkovi -->
    @if(method_exists($products, 'links'))
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    @endif --}}
</div>
@endsection
