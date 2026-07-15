<div class="custom-push-offcanvas bg-light border-end" id="sidebarMenu">
    <div class="p-3">
        <ul class="nav flex-column" id="sidebarAccordion">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link text-dark d-flex align-items-center gap-1" href="#">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>
            {{-- Kasir --}}
            <li class="nav-item">
                <a class="nav-link text-dark d-flex align-items-center gap-1" href="{{ route('transaksi.create') }}">
                    <i class="bi bi-cash"></i> Kasir
                </a>
            </li>

            {{-- Master Data --}}
            <li class="nav-item">
                <a class="nav-link text-dark d-flex justify-content-between align-items-center gap-1" href="#masterDataMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="masterDataMenu">
                    <span><i class="bi bi-database"></i> Master Data</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse ms-3" id="masterDataMenu" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column">
                        <li><a class="nav-link icon-link text-dark" href="{{ route('kategori.index') }}"> Kategori Barang</a></li>
                        <li><a class="nav-link icon-link text-dark" href="{{ route('supplier.index') }}"> Supplier</a></li>
                        <li><a class="nav-link icon-link text-dark" href="{{ route('barang.index') }}"> Barang</a></li>
                        <li><a class="nav-link icon-link text-dark" href="{{ route('diskon.index') }}"> Diskon</a></li>
                        <li><a class="nav-link icon-link text-dark" href="{{ route('member.index') }}"> Member</a></li>
                    </ul>
                </div>
            </li>
            {{-- Stok --}}
            <li class="nav-item">
                <a class="nav-link text-dark d-flex justify-content-between align-items-center gap-1" href="#stokMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="stokMenu">
                    <span><i class="bi bi-box-seam"></i> Stok</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse ms-3" id="stokMenu" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column">
                        <li><a class="nav-link icon-link text-dark" href="{{ route('stok.index') }}">Pergerakan Stok</a></li>
                        <li><a class="nav-link icon-link text-dark" href="{{ route('stok-opname.index') }}"> Stok Opname</a></li>
                    </ul>
                </div>
            </li>

            {{-- Riwayat --}}
            <li class="nav-item">
                <a class="nav-link text-dark d-flex justify-content-between align-items-center gap-1" href="#riwayatMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="riwayatMenu">
                    <span><i class="bi bi-clock-history"></i> Riwayat</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse ms-3" id="riwayatMenu" data-bs-parent="#sidebarAccordion">
                    <ul class="nav flex-column">
                        <li><a class="nav-link icon-link text-dark" href="{{ route('transaksi.index') }}">Penjualan</a></li>
                        <li><a class="nav-link icon-link text-dark" href="#"> Pembelian</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>