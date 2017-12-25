<div class="navbar has-shadow is-light" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('dashboard.index') }}">
            AVM Equipment
        </a>

        <button class="button navbar-burger" :class="isActive" @click="isHamburgerActive = !isHamburgerActive">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="navbar-menu is-hidden-desktop" :class="isActive">
        <div class="navbar-end">
            <a class="nav-item {{ active(['/']) }}" href="{{ route('dashboard.index') }}">
                Dashboard
            </a>
            <a class="nav-item {{ active(['work-order', 'work-order/*']) }}" href="#">
                Work Orders
            </a>
            <a class="nav-item {{ active(['equipment', 'equipment/*']) }}" href="{{ route('equipment.index') }}">
                Equipment
            </a>
            <a class="nav-item {{ active(['part', 'part/*']) }}" href="{{ route('part.index') }}">
                Parts
            </a>
            <a class="nav-item {{ active(['vendor', 'vendor/*']) }}" href="{{ route('vendor.index') }}">
                Vendors
            </a>
        </div>
    </div>
</div>