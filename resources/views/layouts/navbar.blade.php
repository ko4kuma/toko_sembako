<nav class="navbar navbar-expand-lg">
<button class="btn" id="sidebarToggle" type="button">
        <i class="bi bi-list fs-4"></i>
    </button>
    <span class="navbar-brand ms-2 mb-0">POS Toko Sembako</span>
</nav>
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
            <li><a class="dropdown-item" href="{{ route('member.index') }}">Member</a></li>
            <li><a class="dropdown-item" href="{{ route('transaksi.index') }}">Transaksi</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
