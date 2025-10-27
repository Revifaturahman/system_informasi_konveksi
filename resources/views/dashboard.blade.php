@extends('layouts.master')

@section('content')
<div class="row text-center g-3">
    <div class="col-md-4">
        <div class="p-4 bg-white shadow-sm rounded">
            <h6>Jumlah Penjahit</h6>
            <h2 class="text-primary">10</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-white shadow-sm rounded">
            <h6>Produk di Gudang</h6>
            <h2 class="text-success">245</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-white shadow-sm rounded">
            <h6>Kurir Aktif</h6>
            <h2 class="text-warning">3</h2>
        </div>
    </div>
</div>

{{-- Tombol Gemini di pojok kanan bawah --}}
<button id="geminiBtn" class="btn btn-primary rounded-circle shadow-lg"
        style="position: fixed; bottom: 25px; right: 25px; width: 60px; height: 60px; z-index: 1050;">
    <i class="bi bi-stars fs-4"></i>
</button>

{{-- Overlay belakang modal --}}
<div id="overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none"
     style="z-index:1040;"></div>

{{-- Popup Gemini --}}
<div id="geminiPopup" class="card shadow-lg d-none"
     style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 600px; max-width: 90%; z-index: 1050; border-radius: 15px;">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span><i class="bi bi-stars me-2"></i> Gemini Assistant</span>
        <button class="btn-close btn-close-white btn-sm" id="closePopup"></button>
    </div>

    <div class="card-body" id="geminiOutput" style="max-height: 400px; overflow-y: auto;">
        <p class="text-muted text-center my-4">
            Tekan tombol <b>Jalankan Analisis</b> untuk mulai analisis data gudang...
        </p>
    </div>

    <div class="card-footer text-end">
        <button id="runGemini" type="button" class="btn btn-success">
            <i class="bi bi-play-circle me-1"></i> Jalankan Analisis
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('geminiBtn');
    const popup = document.getElementById('geminiPopup');
    const overlay = document.getElementById('overlay');
    const closePopup = document.getElementById('closePopup');
    const runBtn = document.getElementById('runGemini');
    const output = document.getElementById('geminiOutput');

    // 🟦 Tampilkan popup
    btn.addEventListener('click', () => {
        popup.classList.remove('d-none');
        overlay.classList.remove('d-none');
    });

    // 🔴 Tutup popup
    const hidePopup = () => {
        popup.classList.add('d-none');
        overlay.classList.add('d-none');
    };
    closePopup.addEventListener('click', hidePopup);
    overlay.addEventListener('click', hidePopup);

    // 🚀 Jalankan analisis Gemini
    runBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        output.innerHTML = `
            <div class="text-center my-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-3 text-muted">Sedang menganalisis data gudang...</p>
            </div>
        `;

        try {
            const res = await fetch("{{ route('dashboard.gemini') }}");
            if (!res.ok) throw new Error("Gagal memanggil API backend");

            const result = await res.json();
            output.innerHTML = `
                <h5 class="text-primary">📊 Hasil Analisis:</h5>
                <pre class="bg-light p-3 rounded" style="white-space: pre-wrap;">${result.output}</pre>
            `;
        } catch (err) {
            output.innerHTML = `
                <div class="alert alert-danger">
                    ❌ Terjadi kesalahan: ${err.message}
                </div>
            `;
        }
    });
});
</script>
@endpush
