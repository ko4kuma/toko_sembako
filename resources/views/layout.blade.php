<!DOCTYPE html>
<html>
<head>
    <title>Toko Sembako</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">

    <div class="container">

        <a class="navbar-brand">
            Toko Sembako
        </a>

        <div class="navbar-nav">

            <a href="/member" class="nav-link">
                Member
            </a>

            <a href="/transaksi" class="nav-link">
                Transaksi
            </a>

        </div>

    </div>

</nav>

<div class="container mt-3">

    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif

</div>

{{-- CONTENT --}}
@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>