<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="{{ asset('adminlte3/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{-- Auth::user()->name --}} GUEST</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-header">LABELS</li>
        <li class="nav-item">
            <a href="{{ route('admin.accounts.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Accounts</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.journals.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Journals</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.journals.entries') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-info"></i>
                <p>Journal Entries</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.accounts.reports.profit-loss') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p>Profit/Loss</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.accounts.reports.balance-sheet') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Balance Sheet</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.items.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-info"></i>
                <p>Items</p>
            </a>
        </li>

        <li class="nav-header">Purchases</li>
        <li class="nav-item">
            <a href="{{ route('admin.purchases.vendors.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Vendors</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.purchases.orders.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Orders</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.purchases.invoices.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Invoices</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.purchases.payments.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-info"></i>
                <p>Payments</p>
            </a>
        </li>

        <li class="nav-header">Sales</li>
        <li class="nav-item">
            <a href="{{ route('admin.sales.customers.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Customers</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.sales.quotations.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Quotations</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.sales.orders.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Orders</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.sales.orders.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Deliveries</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.sales.invoices.index') }}" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Invoices</p>
            </a>
        </li>
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
