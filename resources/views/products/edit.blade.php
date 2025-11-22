@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">Daftar Produk</a>
                </li>
                <li class="breadcrumb-item active">Edit Produk</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bx bx-edit me-2"></i>Edit Produk</h5>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama">Nama Produk</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="bx bx-package"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        id="nama"
                                        name="nama"
                                        value="{{ old('nama', $product->nama) }}"
                                        placeholder="Silahkan isi nama produk"
                                        required
                                    />
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="category_id">Kategori</label>
                            <div class="col-sm-10">
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="harga">Harga</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">Rp</span>
                                    <input
                                        type="number"
                                        class="form-control @error('harga') is-invalid @enderror"
                                        id="harga"
                                        name="harga"
                                        value="{{ old('harga', $product->harga) }}"
                                        placeholder="0"
                                        min="0"
                                        step="1000"
                                        required
                                    />
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="stok">Stok</label>
                            <div class="col-sm-10">
                                <input
                                    type="number"
                                    class="form-control @error('stok') is-invalid @enderror"
                                    id="stok"
                                    name="stok"
                                    value="{{ old('stok', $product->stok) }}"
                                    placeholder="0"
                                    min="0"
                                    required
                                />
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="3"
                                    placeholder="Silahkan isi deskripsi produk"
                                >{{ old('deskripsi', $product->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="foto">Foto Produk</label>
                            <div class="col-sm-10">
                                @if($product->foto)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" class="img-thumbnail" width="150">
                                        <br>
                                        <small class="text-muted">Foto saat ini</small>
                                    </div>
                                @endif
                                <input
                                    type="file"
                                    class="form-control @error('foto') is-invalid @enderror"
                                    id="foto"
                                    name="foto"
                                    accept="image/*"
                                />
                                <div class="form-text">Kosongkan jika tidak ingin mengubah foto</div>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-2"></i>Update
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-x me-2"></i>Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection