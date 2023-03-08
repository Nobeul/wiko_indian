@extends('admin.app')

@section('css')
    <style>

    </style>
@endsection

@section('content')
<div class="container">
    <div class="float-right">
        <a href="{{ url('create-new-seller') }}" type="button" class="btn btn-outline-success mb-4">+ New Seller</a>
    </div>
    <form method="get" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="name" placeholder="Enter seller name to search" class="form-control" value="{{ $name }}">
            </div>
            <div class="col-md-4">
                <input type="text" name="phone" placeholder="Enter seller phone number to search" class="form-control" value="{{ $phone }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Picture</th>
            <th class="text-center">Name</th>
            <th class="text-center">Phone</th>
            <th class="text-center">Rating</th>
            <th class="text-center">Country</th>
            <th class="text-center">Address</th>
            <th class="text-center">Is Recommended</th>
            <th class="text-center">Action</th>
        </tr>
        @forelse ($sellers as $seller)
            <tr>
                <td class="text-center">
                    @if ($seller->profile_image)
                        <div class="avatar avatar-md"><img class="avatar-img"
                            src="{{ asset('public/admin/assets/img/avatars/'.$seller->profile_image) }}"
                            alt="{{ $seller->name }}"></div>
                    @else
                        <div class="avatar avatar-md"><img class="avatar-img"
                            src="{{ asset('public/admin/assets/img/avatars/default-profile.png') }}"
                            alt="{{ $seller->name }}"></div>
                    @endif
                </td>
                <td class="text-center">{{ $seller->name }}</td>
                <td class="text-center">{{ $seller->phone }}</td>
                <td class="text-center">{{ $seller->rating }}</td>
                <td class="text-center">{{ $seller->country->name }}</td>
                <td class="text-center">
                    @if ($seller->city)
                        City: {{ $seller->city }}<br>
                    @endif

                    @if ($seller->state)
                        State: {{ $seller->state }}<br>
                    @endif

                    @if ($seller->address)
                        Address: {{ $seller->address }}<br>
                    @endif
                </td>
                <td class="text-center">{{ $seller->is_recommended == 1 ? 'Yes' : 'No' }}</td>
                <td class="text-center">
                    <a class="nav-link" href="{{ url('sellers/'.$seller->id) }}" style="display: inline-block">
                        <svg class="nav-icon" style="width: 24px; height: 24px; border: 1px solid black; padding: 5px; border-radius: 5px;">
                          <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
                        </svg></a>
                    <a class="nav-link delete-button" style="display: inline-block" data-coreui-toggle="modal" data-coreui-target="#exampleModal" data-url="{{ url("delete-seller/".$seller->id) }}">
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
                    {{ $sellers->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Delete Seller</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure to delete this seller?
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
    $('.delete-button').on('click', function () {
        $('#delete-modal').attr('action', $(this).attr('data-url'));
    });
</script>
@endsection