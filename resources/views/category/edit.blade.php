@extends('layouts.app')

@section('title', 'Edit Kategori')

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
                    <a href="{{ route('categories.index') }}">Data Kategori</a>
                </li>
                <li class="breadcrumb-item active">Edit Kategori</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bx bx-edit me-2"></i>Edit Kategori</h5>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nama Kategori</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="bx bx-category"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        id="basic-icon-default-fullname"
                                        name="nama"
                                        value="{{ old('nama', $category->nama) }}"
                                        placeholder="Silahkan isi nama kategori"
                                        aria-label="Silahkan isi nama kategori"
                                        aria-describedby="basic-icon-default-fullname2"
                                        required
                                    />
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-2"></i>Update
                                </button>
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
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