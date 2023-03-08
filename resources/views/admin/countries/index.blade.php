@extends('admin.app')

@section('content')
<div class="container">
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Name</th>
            <th class="text-center">ISO Code</th>
            <th class="text-center">Is Default</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
        </tr>
        @foreach ($countries as $country)
            <tr>
                <td class="text-center">{{ $country->name }}</td>
                <td class="text-center">{{ $country->iso3 }}</td>
                <td class="text-center">{{ $country->is_default }}</td>
                <td class="text-center">{{ $country->status }}</td>
                <td class="text-center">
                    <a class="nav-link delete-button" data-coreui-toggle="modal" data-coreui-target="#exampleModal" data-url="{{ url("country/".$country->id) }}" data-val="{{ $country->status }}">
                        <svg class="nav-icon" style="width: 24px; height: 24px; border: 1px solid black; padding: 5px; border-radius: 5px;">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                        </svg></a>
                </td>
            </tr>
        @endforeach
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
                    {{ $countries->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Country</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="delete-modal">
                @csrf
                <div class="modal-body">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
                    <select class="form-select" aria-label="Default select example" id="status" name="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.delete-button').on('click', function () {
        $('#delete-modal').attr('action', $(this).attr('data-url'));
        $('#status').val($(this).attr('data-val'));
    });
</script>
@endsection