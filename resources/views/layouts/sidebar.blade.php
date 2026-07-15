<div class="custom-push-offcanvas bg-light border-end" id="sidebarMenu">
    <div class="p-3 d-flex flex-column justify-content-between" style="min-height: 100vh;">
        <ul class="nav flex-column" id="sidebarAccordion">

            {{-- Dashboard --}}
            @auth
            <li class="nav-item">
                <a class="nav-link text-dark d-flex align-items-center gap-1" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>
            @endauth

            {{-- Semua menu di bawah ini hanya tampil jika user SUDAH LOGIN --}}
            @auth
                {{-- Kasir --}}
                @if(auth()->user()->role === 'kasir')
                <li class="nav-item">
                    <a class="nav-link text-dark d-flex align-items-center gap-1" href="{{ route('transaksi.create') }}">
                        <i class="bi bi-cash"></i> Kasir
                    </a>
                </li>
                @endif

                {{-- Master Data --}}
                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link text-dark d-flex justify-content-between align-items-center gap-1" href="#masterDataMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="masterDataMenu">
                        <span><i class="bi bi-database"></i> Master Data</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse ms-3" id="masterDataMenu" data-bs-parent="#sidebarAccordion">
                        <ul class="nav flex-column">
                            <li><a class="nav-link icon-link text-dark" href="{{ route('pegawai.index') }}"> Pegawai</a></li>
                            <li><a class="nav-link icon-link text-dark" href="{{ route('kategori.index') }}"> Kategori Barang</a></li>
                            <li><a class="nav-link icon-link text-dark" href="{{ route('supplier.index') }}"> Supplier</a></li>
                            <li><a class="nav-link icon-link text-dark" href="{{ route('barang.index') }}"> Barang</a></li>
                            <li><a class="nav-link icon-link text-dark" href="{{ route('diskon.index') }}"> Diskon</a></li>
                            <li><a class="nav-link icon-link text-dark" href="{{ route('member.index') }}"> Member</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                {{-- Stok --}}
                @if(in_array(auth()->user()->role, ['admin', 'gudang']))
                <li class="nav-item">
                    <a class="nav-link text-dark d-flex justify-content-between align-items-center gap-1" href="#stokMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="stokMenu">
                        <span><i class="bi bi-box-seam"></i> Stok</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse ms-3" id="stokMenu" data-bs-parent="#sidebarAccordion">
                        <ul class="nav flex-column">
                            @if(auth()->user()->role === 'admin')
                            <li><a class="nav-link icon-link text-dark" href="{{ route('stok.index') }}">Pergerakan Stok</a></li>
                            @endif
                            @if(auth()->user()->role === 'gudang')
                            <li><a class="nav-link icon-link text-dark" href="{{ route('stok-opname.index') }}"> Stok Opname</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                {{-- Riwayat --}}
                @if(in_array(auth()->user()->role, ['kasir', 'purchasing', 'admin']))
                <li class="nav-item">
                    <a class="nav-link text-dark d-flex justify-content-between align-items-center gap-1" href="#riwayatMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="riwayatMenu">
                        <span><i class="bi bi-clock-history"></i> Riwayat</span>
                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <div class="collapse ms-3" id="riwayatMenu" data-bs-parent="#sidebarAccordion">
                        <ul class="nav flex-column">
                            @if(in_array(auth()->user()->role, ['kasir', 'admin']))
                            <li><a class="nav-link icon-link text-dark" href="{{ route('transaksi.index') }}">Penjualan</a></li>
                            @endif
                            @if(in_array(auth()->user()->role, ['purchasing', 'admin']))
                            <li><a class="nav-link icon-link text-dark" href="{{ route('pembelian.index') }}"> Pembelian</a></li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <hr>

                {{-- ✅ TOMBOL LOGOUT --}}
                <li class="nav-item mt-auto">
                    <a class="nav-link text-danger d-flex align-items-center gap-1" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endauth

        </ul>
    </div>
</div>
