<aside id="sidebar" class="sidebar">

    @php
        $role = auth()->user()->role;
    @endphp

@if ($role === 'admin')
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin-dashboard')}}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Produk -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin-product')}}">
                <i class="bi bi-box-seam"></i>
                <span>Produk</span>
            </a>
        </li>

        <!-- Penjualan -->
        <li class="nav-item">
            <a class="nav-link" href="{{route(('admin-penjualan'))}}">
                <i class="bi bi-cash-stack"></i>
                <span>Penjualan</span>
            </a>
        </li>

        <!-- User -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('data-user')}}">
                <i class="bi bi-person-lines-fill"></i>
                <span>User</span>
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('logout')}}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li>
    </ul>
    @endif

    @if ($role === 'petugas')
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('petugas-dashboard') ? '' : 'collapsed' }}"
                href="{{ route('petugas-dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('petugas-product') ? '' : 'collapsed' }}"
                href="{{ route('petugas-product') }}">
                <i class="bi bi-grid"></i>
                <span>Product</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link  }}"
                href="{{ route('petugas.pembelian') }}">
                <i class="bi bi-grid"></i>
                <span>Penjualan</span>
            </a>
        </li>

        <li>
            <a class="nav-link {{ request()->routeIs('logout') ? '' : 'collapsed' }}"
                href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li>


    </ul>
@endif


</aside>
