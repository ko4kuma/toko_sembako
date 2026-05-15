<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">POS Toko Sembako</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Master Data
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('barang.index') }}">Barang</a></li>
            <li><a class="dropdown-item" href="{{ route('kategori.index') }}">Kategori Barang</a></li>
            <li><a class="dropdown-item" href="{{ route('supplier.index') }}">Supplier</a></li>
            <li><a class="dropdown-item" href="{{ route('diskon.index') }}">Diskon</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>