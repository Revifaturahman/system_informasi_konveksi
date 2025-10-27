@extends('layouts.master')

@section('title', 'Daftar Produk')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#productModal"   onclick="openCreateModal()">
    <i class="bi bi-plus-circle"></i> Tambah Produk
</button>

<!-- Grid Card Produk -->
<div class="row g-3 text-center">
    @foreach ($products as $index => $p)
        <div class="col-md-4">
            <div class="position-relative p-4 bg-white shadow-sm rounded border">

                <!-- Tombol hapus -->
                <form action="{{ route('product.destroy', $p->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>

                <!-- Klik untuk edit -->
                <div onclick="openEditModal({{ $p->id }}, '{{ $p->category_id }}', '{{ $p->product_name }}', '{{ $p->stock }}')" style="cursor:pointer;">
                    <h6 class="text-muted">Produk {{ $index + 1 }}</h6>
                    <h4 class="text-primary mb-1">{{ $p->product_name }}</h4>
                    <p class="text-muted mb-0"><strong>Kategori:</strong> {{ $p->category->category_name }}</p>
                    <p class="text-muted mt-1"><strong>Stok:</strong> {{ $p->stock ?? '0' }} Pcs</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('product.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="product_id">

            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="product_name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock"/>
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
    document.getElementById('productModalLabel').innerText = 'Tambah Produk';
    document.getElementById('product_id').value = '';
    document.getElementById('category_id').value = '';
    document.getElementById('product_name').value = '';
    document.getElementById('stock').value = '';
}

function openEditModal(id, category_id, product_name, stock) {
    document.getElementById('productModalLabel').innerText = 'Edit Produk';
    document.getElementById('product_id').value = id;
    document.getElementById('category_id').value = category_id;
    document.getElementById('product_name').value = product_name;
    document.getElementById('stock').value = stock;
    var modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
}

function confirmDelete(form) {
    if (confirm("Yakin ingin menghapus produk ini?")) {
        form.submit();
    }
}
</script>
@endsection
