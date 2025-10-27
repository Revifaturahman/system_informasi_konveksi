@extends('layouts.master')

@section('title', 'Varian Produk')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#variantModal" onclick="openCreateModal()">
        <i class="bi bi-plus-circle"></i> Tambah Varian
    </button>
        
    <div class="row g-3">
        @foreach ($variants as $variant)
            <div class="col-md-4">
                <div class="position-relative p-4 bg-white shadow-sm rounded">

                    <!-- Tombol hapus -->
                    <form action="{{ route('product-variant.destroy', $variant->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                    <!-- Klik card untuk edit -->
                    <div onclick="openEditModal('{{ $variant->id }}', '{{ $variant->product_id }}', '{{ $variant->size }}', '{{ $variant->stock }}')" style="cursor:pointer;">
                        <h6 class="text-muted mb-1">{{ $variant->product->product_name }}</h6>
                        <h4 class="text-primary mb-1">Ukuran: {{ $variant->size }}</h4>
                        <p class="text-muted mb-0">Stok: {{ $variant->stock }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="variantModal" tabindex="-1" aria-labelledby="variantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('product-variant.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="variant_id">

            <div class="modal-header">
                <h5 class="modal-title" id="variantModalLabel">Tambah Varian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Produk</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}">{{ $p->product_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ukuran</label>
                    <input type="text" class="form-control" name="size" id="size" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stock" id="stock" min="0" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('variantModalLabel').innerText = 'Tambah Varian';
    document.getElementById('variant_id').value = '';
    document.getElementById('product_id').value = '';
    document.getElementById('size').value = '';
    document.getElementById('stock').value = '';
}

function openEditModal(id, product_id, size, stock) {
    document.getElementById('variantModalLabel').innerText = 'Edit Varian';
    document.getElementById('variant_id').value = id;
    document.getElementById('product_id').value = product_id;
    document.getElementById('size').value = size;
    document.getElementById('stock').value = stock;
    var modal = new bootstrap.Modal(document.getElementById('variantModal'));
    modal.show();
}

function confirmDelete(form) {
    if (confirm("Yakin ingin menghapus varian ini?")) {
        form.submit();
    }
}
</script>
@endsection
