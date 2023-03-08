@extends('admin.app')

@section('content')
<div class="container">
    <div>
        <button type="button" class="btn btn-outline-success mb-4" data-coreui-toggle="modal" data-coreui-target="#addModal" id="add-button">+ New Location</button>
    </div>
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Name</th>
            <th class="text-center">Country</th>
            <th class="text-center">City</th>
            <th class="text-center">State</th>
            <th class="text-center">Address</th>
            <th class="text-center">Action</th>
        </tr>
        @forelse ($locations as $location)
            <tr>
                <td class="text-center">{{ $location->name }}</td>
                <td class="text-center">{{ $location->country }}</td>
                <td class="text-center">{{ $location->city }}</td>
                <td class="text-center">{{ $location->state }}</td>
                <td class="text-center">{{ $location->address }}</td>
                <td class="text-center">
                    <a class="nav-link edit-button" data-coreui-toggle="modal" data-coreui-target="#editModal" data-url="{{ url('location/'.$location->id) }}" data-name="{{ $location->name }}" data-country="{{ $location->country }}" data-city="{{ $location->city }}"  data-state="{{ $location->state }}" data-address="{{ $location->address }}" style="display: inline-block">
                        <svg class="nav-icon" style="width: 24px; height: 24px; border: 1px solid black; padding: 5px; border-radius: 5px;">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                        </svg></a>
                    <a class="nav-link delete-button" data-coreui-toggle="modal" data-coreui-target="#deleteModal" data-url="{{ url('delete-location/'.$location->id) }}" data-name="{{ $location->name }}" data-country="{{ $location->country }}" data-city="{{ $location->city }}"  data-state="{{ $location->state }}" data-address="{{ $location->address }}" style="display: inline-block">
                        <svg class="nav-icon" style="width: 24px; height: 24px; border: 1px solid black; padding: 5px; border-radius: 5px;">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-delete"></use>
                        </svg></a>
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
                    {{ $locations->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Location</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="edit-modal">
                @csrf
                <div class="modal-body">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="edit_name">

                    <label for="staticEmail" class="col-sm-2 col-form-label">Country</label>
                    <input type="text" class="form-control" name="country" id="edit_country">

                    <label for="staticEmail" class="col-sm-2 col-form-label">City</label>
                    <input type="text" class="form-control" name="city" id="edit_city">

                    <label for="staticEmail" class="col-sm-2 col-form-label">State</label>
                    <input type="text" class="form-control" name="state" id="edit_state">

                    <label for="staticEmail" class="col-sm-2 col-form-label">Address</label>
                    <input type="text" class="form-control" name="address" id="edit_address">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Location</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('create-new-location') }}">
                @csrf
                <div class="modal-body">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                    <input type="text" class="form-control" name="name">

                    <label for="staticEmail" class="col-sm-2 col-form-label">Country</label>
                    <input type="text" class="form-control" name="country">

                    <label for="staticEmail" class="col-sm-2 col-form-label">City</label>
                    <input type="text" class="form-control" name="city">

                    <label for="staticEmail" class="col-sm-2 col-form-label">State</label>
                    <input type="text" class="form-control" name="state">

                    <label for="staticEmail" class="col-sm-2 col-form-label">Address</label>
                    <input type="text" class="form-control" name="address">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Location</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="delete-modal">
                @csrf
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.edit-button').on('click', function () {
        $('#edit-modal').attr('action', $(this).attr('data-url'));
        $('#edit_name').val($(this).attr('data-name'));
        $('#edit_country').val($(this).attr('data-country'));
        $('#edit_city').val($(this).attr('data-city'));
        $('#edit_state').val($(this).attr('data-state'));
        $('#edit_address').val($(this).attr('data-address'));
    });

    $('.delete-button').on('click', function () {
        $('#delete-modal').attr('action', $(this).attr('data-url'));
    });
</script>
@endsection