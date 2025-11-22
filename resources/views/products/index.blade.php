@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Daftar Produk</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bx bx-package me-2"></i>Daftar Produk</h5>
            
            <!-- Search Form -->
            <form action="{{ route('products.index') }}" method="GET" class="d-flex" style="width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bx bx-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">
                        <i class="bx bx-x"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div></div>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-2"></i>Tambah Produk
                </a>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Foto</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration + ($products->perPage() * ($products->currentPage() - 1)) }}</td>
                            <td>
                                @if($product->foto)
                                    <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" class="img-thumbnail" width="80">
                                @else
                                    <div class="text-center text-muted">
                                        <i class="bx bx-image bx-lg"></i>
                                        <br><small>No Image</small>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->nama }}</strong>
                                @if($product->deskripsi)
                                    <br><small class="text-muted">{{ Str::limit($product->deskripsi, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $product->category->nama }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $product->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stok }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);" 
                                           onclick="confirmDelete({{ $product->id }}, '{{ $product->nama }}')">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $product->id }}" 
                                      action="{{ route('products.destroy', $product->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bx bx-inbox bx-lg mb-2"></i><br>
                                    Tidak ada data produk
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} data
                </div>
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// SweetAlert untuk konfirmasi hapus
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Produk?',
        text: `Apakah Anda yakin ingin menghapus produk "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#696cff',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection