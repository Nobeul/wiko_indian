@extends('admin.app')

@section('content')
<div class="container">
    <div class="float-right">
        <a href="{{ url('create-new-verification') }}" type="button" class="btn btn-outline-success mb-4">+ New Verification</a>
    </div>
    <form method="get" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select class="form-select" name="verification_type_id">
                    <option>{{ 'Verification Type' }}</option>
                    @foreach ($verification_types as $verification_type)
                        <option value="{{ $verification_type->id }}" {{ isset($verification_type_id) && $verification_type_id == $verification_type->id ? 'selected' : '' }}>{{ $verification_type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="user_id">
                    <option>{{ 'Company Name' }}</option>
                    @foreach ($unique_users as $verification)
                        <option value="{{ optional($verification->user)->id }}" {{ isset($user_id) && $user_id == optional($verification->user)->id ? 'selected' : '' }}>{{ optional($verification->user)->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option>Status</option>
                    <option value="pending" {{ isset($status) && $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ isset($status) && $status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ isset($status) && $status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Verification Type</th>
            <th class="text-center">Company Name</th>
            <th class="text-center">Status</th>
            <th class="text-center">Created At</th>
            <th class="text-center">Action</th>
        </tr>
        @foreach ($verifications as $verification)
            <tr>
                <td class="text-center">{{ optional($verification->verificationType)->name }}</td>
                <td class="text-center"><a href="{{ ($verification->user)->user_type == 1 ? url('sellers/'.optional($verification->user)->id) : url('buyers/'.optional($verification->user)->id) }}">{{ optional($verification->user)->name }}</a></td>
                <td class="text-center">{{ ucfirst($verification->verification_status) }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($verification->created_at)->format("Y-m-d") }}</td>
                <td class="text-center">
                    <a class="nav-link" href="{{ url('edit-verification/'.$verification->id) }}" style="display: inline-block">
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
                    {{ $verifications->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
