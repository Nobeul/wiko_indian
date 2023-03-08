@extends('admin.app')

@section('css')
    <style>

    </style>
@endsection

@section('content')
<div class="container">
    <div class="float-right">
        <a href="{{ url('create-new-product') }}" type="button" class="btn btn-outline-success mb-4">+ New Product</a>
    </div>
    <form method="get" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="name" placeholder="Enter product name to search" class="form-control" value="{{ $name }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Name</th>
            <th class="text-center">Is Recommended</th>
            <th class="text-center">Varieties</th>
            <th class="text-center">Action</th>
        </tr>
        @forelse ($products as $product)
            <tr>
                <td class="text-center">{{ $product->name }}</td>
                <td class="text-center">{{ $product->is_recommended == 0 ? 'No' : 'Yes' }}</td>
                <td class="text-center">{{ implode(", ", $product->varieties->pluck('name')->toArray()) }}</td>
                <td class="text-center">
                    <a class="nav-link" href="{{ url('view-product/'.$product->id) }}" style="display: inline-block">
                        <svg class="nav-icon" style="width: 24px; height: 24px; border: 1px solid black; padding: 5px; border-radius: 5px;">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom-in"></use>
                        </svg></a>
                    <a class="nav-link" href="{{ url('product/'.$product->id) }}" style="display: inline-block">
                        <svg class="nav-icon" style="width: 24px; height: 24px; border: 1px solid black; padding: 5px; border-radius: 5px;">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                        </svg></a>
                    {{-- <a class="nav-link" style="display: inline-block" data-coreui-toggle="modal" data-coreui-target="#exampleModal" id="delete-button" data-url="{{ url("delete-product/".$product->id) }}">
                        <svg class="nav-icon" style="width: 24px; height: 24px; border: 1px solid black; padding: 5px; border-radius: 5px;">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-delete"></use>
                        </svg></a> --}}
                </td>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                <form method="post" id="delete-modal">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#delete-button').on('click', function () {
        $('#delete-modal').attr('action', $(this).attr('data-url'));
    });
</script>
@endsection