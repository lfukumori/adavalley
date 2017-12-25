<div class="card">
    <header class="card-header">
        <p class="card-header-title is-marginless is-size-5">
            Vendor List
        </p>
        <a href="{{ route('vendor.create') }}" class="card-header-icon" aria-label="create new part">
            <span class="icon">
                <i class="fa fa-lg fa-plus-square" aria-hidden="true"></i>
            </span>
        </a>
    </header>
    <div class="card-content">
        <div class="content is-paddingless">
            <table class="table is-striped is-fullwidth">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $vendor)
                        <tr>
                            <td><a href="{{ route('vendor.show', $vendor->id) }}">{{ $vendor->name }}</a></td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone_number }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align:center;color:red;">No vendors yet!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>