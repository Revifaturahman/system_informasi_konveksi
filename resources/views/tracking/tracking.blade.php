@extends('layouts.master')

@section('title', 'Tracking Kurir')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Tracking Kurir</h4>
    </div>

    {{-- Peta Tracking --}}
    <div id="map" style="height: 80vh; border-radius: 10px; overflow: hidden;"></div>
</div>
@endsection

@push('styles')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
    {{-- Leaflet & Turf.js --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>

    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-6.945, 107.578], 14);

        // Tambahkan peta OSM
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // Titik awal & akhir
        const start = [-6.929168081776788, 107.57979968138781];
        const end = [-6.953298714669747, 107.58228817789401];

        // Marker awal & tujuan
        L.marker(start).addTo(map).bindPopup('Titik Awal');
        L.marker(end).addTo(map).bindPopup('Titik Tujuan');

        // Ikon motor
        const motorIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/2972/2972185.png',
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -35]
        });

        // Ambil rute dari OSRM
        fetch(`https://router.project-osrm.org/route/v1/driving/${start[1]},${start[0]};${end[1]},${end[0]}?overview=full&geometries=geojson`)
            .then(res => res.json())
            .then(data => {
                const route = data.routes[0].geometry;
                const routeCoords = route.coordinates.map(c => [c[1], c[0]]);

                // Rute utama (abu-abu)
                let fullRoute = L.polyline(routeCoords, { color: 'gray', weight: 4 }).addTo(map);

                // Buat geofence area (100 meter dari rute)
                const routeLine = turf.lineString(route.coordinates);
                const buffered = turf.buffer(routeLine, 0.1, { units: 'kilometers' }); // 0.1 km = 100 m

                // Tambahkan area buffer ke peta
                const geofenceLayer = L.geoJSON(buffered, {
                    style: {
                        color: 'blue',
                        fillColor: 'rgba(0, 136, 255, 0.2)',
                        weight: 2,
                        fillOpacity: 0.3
                    }
                }).addTo(map);

                map.fitBounds(fullRoute.getBounds());

                // Tambah marker kurir
                var courierMarker = L.marker(start, { icon: motorIcon }).addTo(map).bindPopup("Posisi Kurir");

                // Update posisi real-time
                if (navigator.geolocation) {
                    navigator.geolocation.watchPosition(pos => {
                        const lat = pos.coords.latitude;
                        const lon = pos.coords.longitude;
                        courierMarker.setLatLng([lat, lon]);

                        // Cek apakah di dalam area geofence
                        const point = turf.point([lon, lat]);
                        const inside = turf.booleanPointInPolygon(point, buffered);

                        // Ganti warna area jika keluar dari geofence
                        geofenceLayer.setStyle({
                            color: inside ? 'blue' : 'red',
                            fillColor: inside ? 'rgba(0, 136, 255, 0.2)' : 'rgba(255, 0, 0, 0.2)'
                        });

                    }, err => {
                        console.error("Gagal ambil lokasi:", err);
                    }, {
                        enableHighAccuracy: true,
                        maximumAge: 0,
                        timeout: 5000
                    });
                } else {
                    alert("Browser tidak mendukung GPS");
                }
            });
    </script>
@endpush
