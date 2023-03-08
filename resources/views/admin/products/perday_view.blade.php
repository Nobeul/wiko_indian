@extends('admin.app')

@section('css')
    <style>

    </style>
@endsection

@section('content')
<div class="container">
    <form method="get" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="name" placeholder="Enter product name to search" class="form-control" value="{{ $name }}">
            </div>
            <div class="col-md-4">
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">Select Company</option>
                    @foreach ($unique_sellers as $seller)
                        <option value="{{ optional($seller->user)->id }}" {{ isset($user_id) && $user_id == optional($seller->user)->id ? 'selected' : '' }}>{{ optional($seller->user)->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Product Name</th>
            <th class="text-center">Variety</th>
            <th class="text-center">Company</th>
            <th class="text-center">Price</th>
            <th class="text-center">Available Quantity</th>
            <th class="text-center">Is Negotiable</th>
            <th class="text-center">Available Till</th>
            <th class="text-center">Selling Location</th>
        </tr>
        @forelse ($products as $product)
            <tr>
                <td class="text-center">{{ $product->adminOfferedProduct->name }}</td>
                <td class="text-center">{{ $product->variety->name }}</td>
                <td class="text-center">{{ $product->user->name }}</td>
                <td class="text-center">{{ $product->price }}</td>
                <td class="text-center">{{ $product->available_quantity }}</td>
                <td class="text-center">{{ $product->is_negotiable == 0 ? 'No' : 'Yes' }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($product->available_untill)->format('d-m-Y g:i:A') }}</td>
                <td class="text-center">{{ implode(', ', $product->locations->pluck('name')->toArray()) }}</td>
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
                    {{ $products->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
