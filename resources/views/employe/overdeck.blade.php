@extends('layouts.master')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#overdeckModal" onclick="openCreateModal()">Tambah Overdek</button>

<div class="row text-center g-3">
    @foreach ($overdecks as $index => $overdeck)
        <div class="col-md-4">
            <div class="position-relative p-4 bg-white shadow-sm rounded">

                <!-- Tombol hapus -->
                <form action="{{ route('overdeck.destroy', $overdeck->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>

                <!-- Klik card untuk edit -->
                <div onclick="openEditModal({{ $overdeck->id }}, '{{ $overdeck->name }}', '{{ $overdeck->phone_number }}', '{{ $overdeck->rate_per_piece }}')" style="cursor:pointer;">
                    <h6>Overdek {{ $index + 1 }}</h6>
                    <h2 class="text-primary">{{ $overdeck->name }}</h2>
                    <p class="text-muted mb-0">Rp {{ number_format($overdeck->rate_per_piece, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>


<!-- Modal -->
<div class="modal fade" id="overdeckModal" tabindex="-1" aria-labelledby="overdeckModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('overdeck.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="overdeck_id">

            <div class="modal-header">
                <h5 class="modal-title" id="overdeckModalLabel">Tambah Overdek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" name="phone_number" id="phone_number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga per Baju</label>
                    <input type="number" class="form-control" name="rate_per_piece" id="rate_per_piece" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('overdeckModalLabel').innerText = 'Tambah Overdek';
    document.getElementById('overdeck_id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('phone_number').value = '';
    document.getElementById('rate_per_piece').value = '';
}

function openEditModal(id, name, phone_number, rate_per_piece, latitude, longitude) {
    document.getElementById('overdeckModalLabel').innerText = 'Edit Overdek';
    document.getElementById('overdeck_id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('phone_number').value = phone_number;
    document.getElementById('rate_per_piece').value = rate_per_piece;
    var modal = new bootstrap.Modal(document.getElementById('overdeckModal'));
    modal.show();
}

function confirmDelete(form) {
    if (confirm("Yakin ingin menghapus overdek ini?")) {
        form.submit();
    }
}

</script>
@endsection
