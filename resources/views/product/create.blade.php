@extends('publics.app')

@section('content')
<div class="container mt-5">
    <h1>Dodaj novi proizvod</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kategorija_id" class="form-label">Kategorija</label>
            <select name="kategorija_id" id="kategorija_id" class="form-select" required>
                <option value="">-- Izaberite kategoriju --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('kategorija_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->naziv }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tip_vode" class="form-label">Tip vode</label>
            <input type="text" name="tip_vode" id="tip_vode" class="form-control" value="{{ old('tip_vode') }}" required>
        </div>

        <div class="mb-3">
            <label for="naziv" class="form-label">Naziv proizvoda</label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv') }}" required>
        </div>

        <div class="mb-3">
            <label for="opis" class="form-label">Opis</label>
            <textarea name="opis" id="opis" class="form-control" rows="3">{{ old('opis') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="cena" class="form-label">Cena</label>
            <input type="number" name="cena" id="cena" class="form-control" step="0.01" value="{{ old('cena') }}" required>
        </div>

        <div class="mb-3">
            <label for="ambalaza" class="form-label">Ambalaža</label>
            <select name="ambalaza" id="ambalaza" class="form-select" required>
                <option value="">-- Izaberite ambalažu --</option>
                <option value="PET" {{ old('ambalaza') == 'PET' ? 'selected' : '' }}>PET</option>
                <option value="Staklo" {{ old('ambalaza') == 'Staklo' ? 'selected' : '' }}>Staklo</option>
            </select>
        </div>


        <button type="submit" class="btn btn-success">Sačuvaj</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Nazad</a>
    </form>
</div>
@endsection
