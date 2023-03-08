@extends('admin.app')

@section('css')
    <style>

    </style>
@endsection

@section('content')
<div class="container">
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Name</th>
            <th class="text-center">Buyer</th>
            <th class="text-center">Seller</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Price</th>
            <th class="text-center">Location</th>
            <th class="text-center">Shipping Cost</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Ordered At</th>
        </tr>
        @forelse ($orders as $order)
            <tr>
                <td class="text-center">{{ optional($order->product->adminOfferedProduct)->name }}</td>
                <td class="text-center">{{ optional($order->buyer)->name }}</td>
                <td class="text-center">{{ optional($order->seller)->name }}</td>
                <td class="text-center">{{ $order->quantity }}</td>
                <td class="text-center">{{ $order->price }}</td>
                <td class="text-center">{{ optional($order->location)->name }}</td>
                <td class="text-center">{{ $order->shipping_cost }}</td>
                <td class="text-center">{{ $order->discount }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</td>
            </tr>
        @empty
            <tr>
                <td>No data found</td>
            </tr>
        @endforelse
    </table>
    <div class="row mt-4">
        <div class="col-md-4">
            <form method="get" class="m-2">
                <span>Row per page</span>
                <select name="page_limit" class="form-control form-control-sm d-inline"
                    @if (empty($from)) onchange="this.form.submit()" @endif style="width: auto;">
                    <option value="10" <?php echo $page_limit == '10' ? 'selected="selected"' : ''; ?>>
                        10
                    </option>
                    <option value="25" <?php echo $page_limit == '25' ? 'selected="selected"' : ''; ?>>
                        25
                    </option>
                    <option value="50" <?php echo $page_limit == '50' ? 'selected="selected"' : ''; ?>>
                        50
                    </option>
                    <option value="100" <?php echo $page_limit == '100' ? 'selected="selected"' : ''; ?>>
                        100
                    </option>
                </select>
            </form>
        </div>
        <div class="col-md-8">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    {{ $orders->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection