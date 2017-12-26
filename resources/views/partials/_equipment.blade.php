<div class="card">
    <header class="card-header">
        <p class="card-header-title is-marginless is-size-5">
            Equipment List
        </p>
        <a href="{{ route('equipment.create') }}" class="card-header-icon" aria-label="create new equipment">
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
                        <th>Brand</th>
                        <th>Model</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipment as $e)
                        <tr>
                            <td><a href="{{ route('equipment.show', $e->id) }}">{{ $e->name() }}</a></td>
                            <td>{{ $e->brand() }}</td>
                            <td>{{ $e->model() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align:center;color:red;">No equipment yet!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <footer class="card-footer">
        <a href="#" class="card-footer-item">Save</a>
        <a href="#" class="card-footer-item">Edit</a>
        <a href="#" class="card-footer-item">Delete</a>
    </footer>
</div>

<!-- <div class="panel">

    <p class="panel-heading">Equipment</p>

    <div class="panel-block">
            
        <table class="table is-striped is-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Model</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipment as $e)
                    <tr>
                        <td><a href="{{ route('equipment.show', $e) }}">{{ $e->name() }}</a></td>
                        <td>{{ $e->brand() }}</td>
                        <td>{{ $e->model() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="text-align:center;color:red;">No equipment</td></tr>
                @endforelse
            </tbody>
        </table>

  </div> -->
    
</div>