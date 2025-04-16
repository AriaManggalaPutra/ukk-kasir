<aside id="sidebar" class="sidebar">

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
            <a class="nav-link" href="#">
                <i class="bi bi-cash-stack"></i>
                <span>Penjualan</span>
            </a>
        </li>

        <!-- User -->
        <li class="nav-item">
            <a class="nav-link" href="#">
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

</aside>
