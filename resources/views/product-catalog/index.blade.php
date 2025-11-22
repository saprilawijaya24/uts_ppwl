@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light">Master /</span> Katalog Produk
                </h4>
                <div class="d-flex align-items-center">
                    <!-- Search Form -->
                    <form action="{{ route('product-catalog.index') }}" method="GET" class="me-3">
                        <div class="input-group" style="width: 300px;">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari produk..." 
                                   value="{{ request('search') }}"
                                   aria-label="Cari produk">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bx bx-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('product-catalog.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-x"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                    
                    <!-- Quick Actions -->
                    <div class="btn-group">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Produk
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bx bx-category"></i> Kelola Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results Info -->
    @if(request('search'))
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bx bx-info-circle me-2"></i>
                        Menampilkan hasil pencarian untuk: 
                        <strong>"{{ request('search') }}"</strong>
                        <span class="badge bg-primary ms-2">{{ $products->count() }} produk ditemukan</span>
                    </div>
                    <a href="{{ route('product-catalog.index') }}" class="btn-close" aria-label="Close"></a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-package bx-sm"></i>
                            </span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Produk</span>
                    <h3 class="card-title mb-2">{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-category bx-sm"></i>
                            </span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Kategori</span>
                    <h3 class="card-title mb-2">{{ $totalCategories }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-dollar-circle bx-sm"></i>
                            </span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Stok Tersedia</span>
                    <h3 class="card-title mb-2">{{ $totalStock }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        @if(request('search'))
                            Hasil Pencarian Produk
                        @else
                            Katalog Produk Tersedia
                        @endif
                    </h5>
                    <p class="text-muted mb-0">
                        @if(request('search'))
                            Ditemukan {{ $products->count() }} produk untuk "{{ request('search') }}"
                        @else
                            Semua produk yang sudah ditambahkan ke sistem
                        @endif
                    </p>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card h-100 product-card">
                                    <div class="card-img-container">
                                        <img class="card-img-top" 
                                             src="{{ asset('storage/'.$product->foto) }}" 
                                             alt="{{ $product->nama }}"
                                             style="height: 200px; object-fit: cover; width: 100%;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->nama }}</h5>
                                        <div class="mb-2">
                                            <span class="badge bg-label-primary">
                                                {{ $product->category->nama ?? 'No Category' }}
                                            </span>
                                        </div>
                                        <p class="card-text text-muted small mb-2">
                                            {{ Str::limit($product->deskripsi, 80) }}
                                        </p>
                                        <div class="product-info">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="h5 text-primary mb-0">
                                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                                </span>
                                                <span class="badge {{ $product->stok > 0 ? 'bg-label-success' : 'bg-label-danger' }}">
                                                    Stok: {{ $product->stok }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="avatar avatar-xl mb-3">
                                <span class="avatar-initial rounded bg-label-secondary">
                                    <i class="bx bx-search bx-lg"></i>
                                </span>
                            </div>
                            <h5 class="mb-2">
                                @if(request('search'))
                                    Produk tidak ditemukan
                                @else
                                    Belum ada produk
                                @endif
                            </h5>
                            <p class="text-muted mb-4">
                                @if(request('search'))
                                    Tidak ada produk yang sesuai dengan pencarian "{{ request('search') }}"
                                @else
                                    Tambahkan produk pertama Anda untuk mulai berjualan
                                @endif
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                @if(request('search'))
                                    <a href="{{ route('product-catalog.index') }}" class="btn btn-primary">
                                        <i class="bx bx-arrow-back me-1"></i> Lihat Semua Produk
                                    </a>
                                @endif
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus me-1"></i> Tambah Produk
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #e0e0e0;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.card-img-container {
    overflow: hidden;
    border-radius: 0.375rem 0.375rem 0 0;
}

.product-info {
    margin-top: auto;
}

.alert {
    border-radius: 0.5rem;
}
</style>
@endsection