@extends('layouts.master')

@section('title', 'Laporan Overdek')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Laporan Overdek</h4>
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
                <th>Nama</th>
                <th>Jumlah Baju (pcs)</th>
                <th>Tanggal</th>
                <th>Gaji</th>
                <th>Import PDF</th>
                <th>Export Slip</th>
            </tr>
        </thead>
        <tbody>
            @php
                $Overdek = [
                    ['nama' => 'Overdek 1', 'jumlah' => 15, 'tanggal' => '18/10/2025', 'gaji' => 1000000],
                    ['nama' => 'Overdek 2', 'jumlah' => 15, 'tanggal' => '18/10/2025', 'gaji' => 1000000],
                    ['nama' => 'Overdek 3', 'jumlah' => 15, 'tanggal' => '18/10/2025', 'gaji' => 1000000],
                ];
            @endphp

            @foreach ($Overdek as $p)
                <tr>
                    <td>{{ $p['nama'] }}</td>
                    <td>{{ $p['jumlah'] }}</td>
                    <td>{{ $p['tanggal'] }}</td>
                    <td>Rp {{ number_format($p['gaji'], 0, ',', '.') }}</td>
                    <td>
                        <a href="#" class="text-decoration-none text-primary">Import</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-file-earmark-pdf"></i> Export
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3 text-end">
        <button class="btn btn-danger">
            <i class="bi bi-file-earmark-arrow-down"></i> Export Semua Slip
        </button>
    </div>
</div>
@endsection
