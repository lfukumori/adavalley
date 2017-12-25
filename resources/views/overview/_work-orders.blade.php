<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Pending Work Orders</h3>
    </div>

    <div class="panel-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($workOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->description }}</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="text-align:center;color:red;">No Work Orders</td></tr>
                @endforelse
            </tbody>
        </table>
        
    </div>

</div>