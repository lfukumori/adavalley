<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Equipment</h3>
    </div>

    <div class="panel-body">
            
        <table class="table table-striped">
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
                        <td><a href="{{ route('equipment.show', $e) }}">{{ $e->name }}</a></td>
                        <td>{{ $e->brand }}</td>
                        <td>{{ $e->model }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="text-align:center;color:red;">No equipment</td></tr>
                @endforelse
            </tbody>
        </table>

    </div>
    
</div>