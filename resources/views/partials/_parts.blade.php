<div class="card">
    <header class="card-header">
        <p class="card-header-title is-marginless is-size-5">
            Part List
        </p>
        <a href="{{ route('part.create') }}" class="card-header-icon" aria-label="create new part">
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
                        <th>Description</th>
                        <th>Serial Number</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parts as $part)
                        <tr>
                            <td><a href="{{ route('part.show', $part->id) }}">{{ $part->name }}</a></td>
                            <td>{{ $part->description }}</td>
                            <td>{{ $part->serial_number }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align:center;color:red;">No parts yet!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>