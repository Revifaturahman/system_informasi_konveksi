@extends('layouts.master')

@section('title', 'Operasi - Baju Keluar')

@section('content')
<div class="container mt-4">

    {{-- Header tombol dan filter --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-outline-primary me-2">
                <i class="bi bi-calendar"></i> Kalender
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
        <div>
            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" style="width: 180px;">
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Data Baju Keluar (Penjualan)</h5>

            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Pembeli</th>
                        <th>Kategori Baju</th>
                        <th>Ukuran / Varian</th>
                        <th>Jumlah Baju (pcs)</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Dummy Data --}}
                    @foreach([
                        ['nama' => 'Pembeli 1', 'kategori' => 'Kaos', 'varian' => 'M', 'pcs' => 15, 'tanggal' => '2025-10-18'],
                        ['nama' => 'Pembeli 2', 'kategori' => 'Kemeja', 'varian' => 'L', 'pcs' => 20, 'tanggal' => '2025-10-18'],
                        ['nama' => 'Pembeli 3', 'kategori' => 'Jaket', 'varian' => 'XL', 'pcs' => 10, 'tanggal' => '2025-10-18'],
                    ] as $b)
                        <tr>
                            <td>{{ $b['nama'] }}</td>
                            <td>{{ $b['kategori'] }}</td>
                            <td>{{ $b['varian'] }}</td>
                            <td>{{ $b['pcs'] }}</td>
                            <td>{{ $b['tanggal'] }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                <a href="#" class="btn btn-sm btn-info text-white">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
