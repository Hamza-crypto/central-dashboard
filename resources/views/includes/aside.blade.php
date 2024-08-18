<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
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

                    <i class="align-middle" data-lucide="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Manage
            </li>


            <li class="sidebar-item {{ request()->is('websites*') ? 'active' : '' }}">
                <a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link" aria-expanded="false">
                    <i class="align-middle" data-lucide="home"></i>
                    <span class="align-middle ">Websites</span>
                </a>
                <ul id="ui"
                    class="sidebar-dropdown list-unstyled collapse {{ request()->is('websites*') ? 'show' : '' }}"
                    data-bs-parent="#sidebar" style="">
                    <li class="sidebar-item {{ request()->is('websites') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('websites.index') }}">
                            <i class="align-middle" data-lucide="home"></i>
                            All
                            Websites</a>
                    </li>
                    <li class="sidebar-item {{ request()->is('websites/create') ? 'active' : '' }}"><a
                            class="sidebar-link" href="{{ route('websites.create') }}"> <i class="align-middle"
                                data-lucide="home"></i>Add New
                            Website</a></li>

                </ul>
            </li>



        </ul>
    </div>
</nav>
