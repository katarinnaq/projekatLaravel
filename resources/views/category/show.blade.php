@extends('publics.app')

@section('content')
<div class="container mt-5">
    <h1>Detalji kategorije</h1>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">{{ $category->naziv }}</h5>
            <p class="card-text"><strong>Opis:</strong> {{ $category->opis ?? '-' }}</p>

            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Nazad</a>
            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Izmeni</a>
        </div>
    </div>
</div>
@endsection
