@extends('layouts.master')

@section('title', 'Operasi - Baju Masuk')

@section('content')
<div class="container mt-4">

    {{-- Header tombol dan filter --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-outline-primary me-2">
                <i class="bi bi-calendar"></i> Kalender
            </button>
        </div>
        <div>
            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" style="width: 180px;">
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Data Baju Masuk dari Penjahit</h5>

            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Penjahit</th>
                        <th>Alamat</th>
                        <th>Jumlah Kain (Kg)</th>
                        <th>Jumlah Baju (pcs)</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Dummy Data --}}
                    @foreach([
                        ['penjahit' => 'Penjahit A', 'alamat' => 'Jalan Sadang', 'kg' => 20, 'pcs' => 15, 'tanggal' => '2025-10-18'],
                        ['penjahit' => 'Penjahit B', 'alamat' => 'Jalan Merdeka', 'kg' => 10, 'pcs' => 8, 'tanggal' => '2025-10-19'],
                        ['penjahit' => 'Penjahit C', 'alamat' => 'Jalan Raya Barat', 'kg' => 5, 'pcs' => 3, 'tanggal' => '2025-10-20'],
                    ] as $b)
                        <tr>
                            <td>{{ $b['penjahit'] }}</td>
                            <td>{{ $b['alamat'] }}</td>
                            <td>{{ $b['kg'] }}</td>
                            <td>{{ $b['pcs'] }}</td>
                            <td>{{ $b['tanggal'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
