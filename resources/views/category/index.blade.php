@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Data Kategori</li>
            </ol>
        </nav>
    </div>

    <!-- Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bx bx-category me-2"></i>Data Kategori</h5>
            
            <!-- Search Form -->
            <form action="{{ route('categories.index') }}" method="GET" class="d-flex" style="width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari kategori..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bx bx-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary ms-2">
                        <i class="bx bx-x"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div></div> <!-- Spacer -->
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-2"></i>Tambah Kategori
                </a>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Kategori</th>
                            <th width="20%">Tanggal Dibuat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration + ($categories->perPage() * ($categories->currentPage() - 1)) }}</td>
                            <td><strong>{{ $category->nama }}</strong></td>
                            <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);" 
                                           onclick="confirmDelete({{ $category->id }}, '{{ $category->nama }}')">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $category->id }}" 
                                      action="{{ route('categories.destroy', $category->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bx bx-inbox bx-lg mb-2"></i><br>
                                    Tidak ada data kategori
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari {{ $categories->total() }} data
                </div>
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// SweetAlert untuk konfirmasi hapus
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Kategori?',
        text: `Apakah Anda yakin ingin menghapus kategori "${name}"?`,
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