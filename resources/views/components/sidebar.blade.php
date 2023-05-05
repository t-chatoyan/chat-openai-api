<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: calc(100vh - 56px);">
    <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">Sidebar Menu</span>
    </p>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('customers') }}" class="nav-link {{ (request()->is('customers')) ? 'active' : '' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#customers"></use>
                </svg>
                Customers List
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admins') }}" class="nav-link {{ (request()->is('admins')) ? 'active' : '' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#customers"></use>
                </svg>
                Admins
            </a>
        </li>
    </ul>
</div>
