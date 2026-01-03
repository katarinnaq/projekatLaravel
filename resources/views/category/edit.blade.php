@extends('publics.app')

@section('content')
<div class="container mt-5">
    <h1>Izmeni kategoriju</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="naziv" class="form-label">Naziv kategorije</label>
            <input type="text" name="naziv" id="naziv" class="form-control" 
                   value="{{ old('naziv', $category->naziv) }}" required>
        </div>

        <div class="mb-3">
            <label for="opis" class="form-label">Opis</label>
            <textarea name="opis" id="opis" class="form-control" rows="3">{{ old('opis', $category->opis) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Sačuvaj promene</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Nazad</a>
    </form>
</div>
@endsection
