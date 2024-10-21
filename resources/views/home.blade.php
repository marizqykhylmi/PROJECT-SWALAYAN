@extends('layouts.templates')

@section('content')
    <div class="jumbotron py-5 px-4 text-center bg-light border rounded shadow">
        @if (Session::get('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session::get('failed') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        
        <h1 class="display-4 font-weight-bold text-primary mb-4">
            @if(Auth::check())
                Selamat Datang, <span class="text-success">{{ Auth::user()->name }}</span> !
            @else
                Selamat Datang !
            @endif
        </h1>
        
        <hr class="my-4 bg-secondary" style="height: 2px;">
        
        <p class="lead text-muted mb-4">
            Aplikasi ini digunakan hanya oleh pegawai Administrator Swalayan Mart. 
            Digunakan untuk mengelola data barang, penyetokan, juga pembelian (kasir).
        </p>
        
        <a href="{{ route('swalayan.home') }}" class="btn btn-primary btn-lg">Mulai</a>
    </div>
@endsection
