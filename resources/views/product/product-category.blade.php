@extends('layouts.master')

@section('title', 'Kategori Produk')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openCreateModal()">
    <i class="bi bi-plus-circle"></i> Tambah Kategori
</button>

<!-- Grid Card -->
<div class="row text-center g-3">
    @foreach ($categories as $index => $category)
        <div class="col-md-4">
            <div class="position-relative p-4 bg-white shadow-sm rounded border">

                <!-- Tombol Hapus -->
                <form action="{{ route('product-category.destroy', $category->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>

                <!-- Klik card untuk edit -->
                <div onclick="openEditModal({{ $category->id }}, '{{ $category->category_name }}', '{{ $category->description }}')" style="cursor:pointer;">
                    <h6 class="text-muted">Kategori {{ $index + 1 }}</h6>
                    <h4 class="text-primary">{{ $category->category_name }}</h4>
                    <p class="text-muted mb-0">{{ $category->description ?? '-' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('product-category.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="category_id">

            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Script -->
<script>
function openCreateModal() {
    document.getElementById('categoryModalLabel').innerText = 'Tambah Kategori';
    document.getElementById('category_id').value = '';
    document.getElementById('category_name').value = '';
    document.getElementById('description').value = '';
}

function openEditModal(id, name, description) {
    document.getElementById('categoryModalLabel').innerText = 'Edit Kategori';
    document.getElementById('category_id').value = id;
    document.getElementById('category_name').value = name;
    document.getElementById('description').value = description;
    var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
}

function confirmDelete(form) {
    if (confirm("Yakin ingin menghapus kategori ini?")) {
        form.submit();
    }
}
</script>
@endsection
