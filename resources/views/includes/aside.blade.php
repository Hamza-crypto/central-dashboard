<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
            <span class="align-middle me-3">
                <span class="align-middle">{{ env('APP_NAME') }}</span>
            </span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                General
            </li>
            <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->is('files/*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('files.create') }}">
                    <i class="align-middle" data-feather="file-text"></i>
                    <span class="align-middle">Upload Excel</span>
                </a>
            </li>

            <li class="sidebar-header">
                Websites
            </li>


            <li class="sidebar-item {{ request()->is('websites*') ? 'active' : '' }}">
                <a data-target="#vehicles" data-toggle="collapse"
                    class="sidebar-link {{ request()->is('vehicles/sold') || request()->is('vehicles') ? 'collapsed' : '' }}">
                    <i class="align-middle" data-feather="at-sign"></i>
                    <span class="align-middle">Websites</span>
                </a>
                <ul id="vehicles"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->is('websites*') ? 'show' : '' }}"
                    data-parent="#sidebar">

                    <li class="sidebar-item {{ request()->is('websites') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('websites.index') }}">
                            <i class="align-middle" data-feather="at-sign"></i>
                            <span class="align-middle">All
                                Websites</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('websites/create') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('websites.create') }}">
                            <i class="align-middle" data-feather="plus-square"></i>
                            <span class="align-middle">Add New
                                Website</span>
                        </a>
                    </li>





                </ul>
            </li>
        </ul>
    </div>
</nav>
