@extends('layouts.master')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Laporan Penjualan</h4>
        <div>
            <button class="btn btn-outline-primary me-2">
                <i class="bi bi-calendar"></i> Kalender
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
    </div>

    <p class="text-muted mb-3">Periode: 18–24 Oktober 2025</p>

    <table class="table table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Jumlah Terjual</th>
                <th>Total Pendapatan</th>
                <th>Export PDF</th>
            </tr>
        </thead>
        <tbody>
            @php
                $penjualan = [
                    ['tanggal' => '18/10/2025', 'produk' => 'Baju Anak Size M', 'kategori' => 'Baju Anak', 'jumlah' => 20, 'pendapatan' => 1000000],
                    ['tanggal' => '18/10/2025', 'produk' => 'Baju Dewasa Size L', 'kategori' => 'Baju Dewasa', 'jumlah' => 10, 'pendapatan' => 700000],
                    ['tanggal' => '19/10/2025', 'produk' => 'Baju Anak Size L', 'kategori' => 'Baju Anak', 'jumlah' => 15, 'pendapatan' => 750000],
                ];
            @endphp

            @foreach ($penjualan as $p)
                <tr>
                    <td>{{ $p['tanggal'] }}</td>
                    <td>{{ $p['produk'] }}</td>
                    <td>{{ $p['kategori'] }}</td>
                    <td>{{ $p['jumlah'] }}</td>
                    <td>Rp {{ number_format($p['pendapatan'], 0, ',', '.') }}</td>
                    <td>
                        <a href="#" class="text-decoration-none text-primary">Export</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
