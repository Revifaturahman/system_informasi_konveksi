<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Konveksi Information System')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Tambahkan stack untuk CSS tambahan --}}
    @stack('styles')
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    {{-- Header --}}
    @include('layouts.header')

    {{-- Main --}}
    <main class="container flex-fill py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Tambahkan stack untuk script tambahan --}}
    @stack('scripts')

</body>
</html>
