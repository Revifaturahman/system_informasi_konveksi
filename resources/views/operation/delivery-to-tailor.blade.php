@extends('layouts.master')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#deliveryModal" onclick="resetForm()">
        + Tambah Pengantaran
    </button>

    <!-- Modal Tambah / Edit Pengantaran -->
    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="deliveryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="deliveryForm" method="POST" action="{{ route('delivery-to-tailor.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="delivery_id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="deliveryModalLabel">Tambah / Edit Pengantaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Kurir</label>
                            <select name="courier_id" id="courier_id" class="form-select">
                                @foreach ($couriers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Penjahit</label>
                            <select name="tailor_id" id="tailor_id" class="form-select">
                                @foreach ($tailors as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Tanggal Pengantaran</label>
                            <input type="datetime-local" name="delivery_date" id="delivery_date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Berat Bahan (Kg)</label>
                            <input type="number" step="0.01" name="material_weight" id="material_weight" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Daftar Pengantaran ke Penjahit</h5>
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Kurir</th>
                        <th>Nama Penjahit</th>
                        <th>Tanggal Kirim</th>
                        <th>Jatuh Tempo</th>
                        <th>Jumlah Kain (Kg)</th>
                        <th>Sisa (Kg)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $d)
                        <tr>
                            <td>{{ $d->courier->name ?? '-' }}</td>
                            <td>{{ $d->tailor->name ?? '-' }}</td>
                            <td>{{ $d->delivery_date }}</td>
                            <td>{{ $d->due_date ?? '-' }}</td>
                            <td>{{ $d->material_weight }}</td>
                            <td>{{ $d->remaining }}</td>
                            <td>
                                @php
                                    $badgeClass = match($d->status) {
                                        'delivery' => 'bg-warning text-dark',
                                        'pickup' => 'bg-info text-dark',
                                        'done' => 'bg-success',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($d->status) }}</span>
                            </td>
                            <td>
                                <!-- Ubah -->
                                <button class="btn btn-sm btn-primary"
                                        onclick='editDelivery(@json($d))'
                                        data-bs-toggle="modal"
                                        data-bs-target="#deliveryModal">
                                    Ubah
                                </button>

                                <!-- Hapus -->
                                <form action="{{ route('delivery-to-tailor.destroy', $d->id) }}" 
                                    method="POST" 
                                    class="d-inline" 
                                    onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>

                                @if($d->action_type === 'start')
                                <!-- Tombol mulai pickup -->
                                <form action="{{ route('delivery-to-tailor.start-pickup', $d->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Kurir mulai menjemput hasil jahit?')"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $d->action_class }}">
                                        {{ $d->action_label }}
                                    </button>
                                </form>

                            @elseif($d->action_type === 'finish')
                                <!-- Tombol selesai pickup -->
                                <button class="btn btn-sm {{ $d->action_class }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#finishPickupModal{{ $d->id }}">
                                    {{ $d->action_label }}
                                </button>
                            @endif
                        </td>
                        </tr>

                        <!-- Modal Ambil Hasil -->
                        <div class="modal fade" id="ambilModal{{ $d->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('delivery-to-tailor.take-result', $d->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ambil Hasil dari {{ $d->tailor->name ?? 'Penjahit' }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Total Kain:</strong> {{ $d->material_weight }} Kg</p>
                                            <p><strong>Sisa Saat Ini:</strong> {{ $d->remaining }} Kg</p>

                                            <label class="form-label">Jumlah diambil (Kg)</label>
                                            <input type="number" name="amount_taken" step="0.01" max="{{ $d->remaining }}" class="form-control" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Selesai Jemput -->
                        <div class="modal fade" id="finishPickupModal{{ $d->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('delivery-to-tailor.finish-pickup', $d->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Selesaikan Penjemputan dari {{ $d->tailor->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Pulang ke Konveksi</label>
                                                <input type="datetime-local" name="pickup_date" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Berat Barang yang Dibawa (Kg)</label>
                                                <input type="number" step="0.01" name="pickup_weight" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr><td colspan="9" class="text-center text-muted">Belum ada data pengantaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script -->
<script>
function resetForm() {
    document.getElementById('deliveryForm').reset();
    document.getElementById('delivery_id').value = '';
    document.getElementById('deliveryModalLabel').textContent = 'Tambah Pengantaran';
}

function editDelivery(delivery) {
    document.getElementById('delivery_id').value = delivery.id;
    document.getElementById('courier_id').value = delivery.courier_id;
    document.getElementById('tailor_id').value = delivery.tailor_id;
    document.getElementById('delivery_date').value = delivery.delivery_date.replace(' ', 'T');
    document.getElementById('due_date').value = delivery.due_date;
    document.getElementById('material_weight').value = delivery.material_weight;
    document.getElementById('deliveryModalLabel').textContent = 'Edit Pengantaran';
}
</script>
@endsection
