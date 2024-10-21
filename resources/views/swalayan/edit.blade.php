@extends('layouts.templates')
@section('content')
    <form action="{{ route('swalayan.update', $swalayan['id']) }}" method="POST" class="card p-5">
        @csrf
        @method('PATCH')
        @if ($errors->any())
            <ul class="alert alert-danger p-3 list-unstyled">
                @foreach ($error->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama barang : </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $swalayan['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis barang :</label>
            <div class="col-sm-10">
                <select name="type" id="type" class="form-select">
                    <option disabled selected hidden>Pilih</option>
                    <option value="makanan" {{ $swalayan['type'] == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ $swalayan['type'] == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="bahan" {{ $swalayan['type'] == 'bahan' ? 'selected' : '' }}>Bahan</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga barang : </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="price" name="price" value="{{ $swalayan['price'] }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ubah Data</button>
    </form>
@endsection
