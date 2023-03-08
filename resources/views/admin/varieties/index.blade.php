@extends('admin.app')

@section('content')
<div class="container">
    <div>
        <a href="{{ url('create-new-variety') }}" class="btn btn-outline-success mb-4" id="add-button">+ New Variety</a>
    </div>
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Name</th>
            <th class="text-center">Sizes</th>
            <th class="text-center">Units</th>
            <th class="text-center">Packaging Sizes</th>
            <th class="text-center">Packaging Materials</th>
            <th class="text-center">Action</th>
        </tr>
        @forelse ($varieties as $variety)
            <tr>
                <td class="text-center">{{ $variety->name }}</td>
                <td class="text-center">{{ implode(", ", $variety->sizes->pluck('name')->toArray()) }}</td>
                <td class="text-center">{{ implode(", ", $variety->units->pluck('name')->toArray()) }}</td>
                <td class="text-center">{{ implode(", ", $variety->packaging_sizes->pluck('name')->toArray()) }}</td>
                <td class="text-center">{{ implode(", ", $variety->packaging_materials->pluck('name')->toArray()) }}</td>
                <td class="text-center">
                    <a class="nav-link edit-button" href="{{ url('variety/'.$variety->id) }}" data-name="{{ $variety->name }}" style="display: inline-block">
                        <svg class="nav-icon" style="width: 24px; height: 24px; border: 1px solid black; padding: 5px; border-radius: 5px;">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                        </svg></a>
                    <a class="nav-link delete-button" data-coreui-toggle="modal" data-coreui-target="#deleteModal" data-url="{{ url('delete-variety/'.$variety->id) }}" data-name="{{ $variety->name }}" style="display: inline-block">
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
                    {{ $varieties->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Edit Modal -->
{{-- <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Variety</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="edit-modal">
                @csrf
                <div class="modal-body">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="edit_name">

                    <label for="staticEmail" class="col-sm-2 col-form-label">Size</label>
                    <select class="form-select" name="size_id" id="edit_size">
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}" {{ $variety->size->id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                        @endforeach
                    </select>

                    <label for="staticEmail" class="col-sm-2 col-form-label">Unit</label>
                    <select class="form-select" name="unit_id" id="edit_unit">
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" {{ $variety->unit->id == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                        @endforeach
                    </select>

                    <label for="staticEmail" class="col-sm-2 col-form-label">Packaging Size</label>
                    <select class="form-select" name="packaging_size_id" id="edit_packaging_size">
                        @foreach ($packaging_sizes as $packaging_size)
                            <option value="{{ $packaging_size->id }}" {{ $variety->packaging_size->id == $packaging_size->id ? 'selected' : '' }}>{{ $packaging_size->name }}</option>
                        @endforeach
                    </select>

                    <label for="staticEmail" class="col-sm-2 col-form-label">Packaging Material</label>
                    <select class="form-select" name="packaging_material_id" id="edit_packaging_material">
                        @foreach ($packaging_materials as $packaging_material)
                            <option value="{{ $packaging_material->id }}" {{ $variety->packaging_material->id == $packaging_material->id ? 'selected' : '' }}>{{ $packaging_material->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Variety</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('create-new-variety') }}">
                @csrf
                <div class="modal-body">
                    <label for="staticEmail" class="col-sm-12 col-form-label">Name</label>
                    <input type="text" class="form-control" name="name">

                    <label for="staticEmail" class="col-sm-12 col-form-label">Size</label>
                    <select class="form-select" name="size_id" id="size">
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>

                    <label for="staticEmail" class="col-sm-12 col-form-label">Unit</label>
                    <select class="form-select" name="unit_id" id="unit">
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>

                    <label for="staticEmail" class="col-sm-12 col-form-label">Packaging Size</label>
                    <select class="form-select" name="packaging_size_id" id="packaging_size">
                        @foreach ($packaging_sizes as $packaging_size)
                            <option value="{{ $packaging_size->id }}">{{ $packaging_size->name }}</option>
                        @endforeach
                    </select>

                    <label for="staticEmail" class="col-sm-12 col-form-label">Packaging Material</label>
                    <select class="form-select" name="packaging_material_id" id="packaging_material">
                        @foreach ($packaging_materials as $packaging_material)
                            <option value="{{ $packaging_material->id }}">{{ $packaging_material->name }}</option>
                        @endforeach
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Variety</h5>
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
<!-- bootstrap-select -->
<script src="{{ asset('public/backend/bootstrap-select-1.13.12/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('public/backend/select2/select2.full.min.js') }}" type="text/javascript"></script>
<script>
    $('.edit-button').on('click', function () {
        $('#edit-modal').attr('action', $(this).attr('data-url'));
        $('#edit_name').val($(this).attr('data-name'));
    });

    $('.delete-button').on('click', function () {
        $('#delete-modal').attr('action', $(this).attr('data-url'));
    });
</script>
@endsection