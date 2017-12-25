<aside class="column is-narrow aside hero is-fullheight is-hidden-touch">
    <div class="main">
        <a href="{{ route('dashboard.index') }}" class="item {{ active(['/']) }}">
            <span class="icon"><i class="fa fa-home"></i></span>
            <span class="name">Dashboard</span>
        </a>
        <a href="{{ route('work-order.index') }}" class="item {{ active(['work-order', 'work-order/*']) }}">
            <span class="icon"><i class="fa fa-list-alt"></i></span>
            <span class="name">Work Orders</span>
        </a>
        <a href="{{ route('equipment.index') }}" class="item {{ active(['equipment', 'equipment/*']) }}">
            <span class="icon"><i class="fa fa-car"></i></span>
            <span class="name">Equipment</span>
        </a>
        <a href="{{ route('part.index') }}" class="item {{ active(['part', 'part/*']) }}">
            <span class="icon"><i class="fa fa-wrench"></i></span>
            <span class="name">Parts</span>
        </a>
        <a href="{{ route('vendor.index') }}" class="item {{ active(['vendor', 'vendor/*']) }}">
            <span class="icon"><i class="fa fa-building-o"></i></span>
            <span class="name">Vendors</span>
        </a>
    </div>
</aside>