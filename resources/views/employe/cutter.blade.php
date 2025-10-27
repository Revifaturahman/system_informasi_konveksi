@extends('layouts.master')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#cutterModal" onclick="openCreateModal()">Tambah Pemotong</button>

<div class="row text-center g-3">
    @foreach ($cutters as $index => $cutter)
        <div class="col-md-4">
            <div class="position-relative p-4 bg-white shadow-sm rounded">

                <!-- Tombol hapus -->
                <form action="{{ route('cutter.destroy', $cutter->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>

                <!-- Klik card untuk edit -->
                <div onclick="openEditModal({{ $cutter->id }}, '{{ $cutter->name }}', '{{ $cutter->phone_number }}', '{{ $cutter->address }}', '{{ $cutter->rate_per_piece }}')" style="cursor:pointer;">
                    <h6>Pemotong {{ $index + 1 }}</h6>
                    <h2 class="text-primary">{{ $cutter->name }}</h2>
                    <p class="text-muted mb-0">{{ $cutter->address }}</p>
                    <p class="text-muted mb-0">Rp {{ number_format($cutter->rate_per_piece, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>


<!-- Modal -->
<div class="modal fade" id="cutterModal" tabindex="-1" aria-labelledby="cutterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('cutter.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id" id="cutter_id">

            <div class="modal-header">
                <h5 class="modal-title" id="cutterModalLabel">Tambah Pemotong</h5>
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
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="address" id="address" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga per Baju</label>
                    <input type="number" class="form-control" name="rate_per_piece" id="rate_per_piece" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">latitude</label>
                    <input type="number" class="form-control" name="latitude" id="latitude" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">longitude</label>
                    <input type="number" class="form-control" name="longitude" id="longitude" required>
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
    document.getElementById('cutterModalLabel').innerText = 'Tambah Pemotong';
    document.getElementById('cutter_id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('phone_number').value = '';
    document.getElementById('address').value = '';
    document.getElementById('rate_per_piece').value = '';
    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
}

function openEditModal(id, name, phone_number, address, rate_per_piece, latitude, longitude) {
    document.getElementById('cutterModalLabel').innerText = 'Edit Pemotong';
    document.getElementById('cutter_id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('phone_number').value = phone_number;
    document.getElementById('address').value = address;
    document.getElementById('rate_per_piece').value = rate_per_piece;
    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;
    var modal = new bootstrap.Modal(document.getElementById('cutterModal'));
    modal.show();
}

function confirmDelete(form) {
    if (confirm("Yakin ingin menghapus pemotong ini?")) {
        form.submit();
    }
}

</script>
@endsection
