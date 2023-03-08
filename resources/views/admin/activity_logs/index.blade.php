@extends('admin.app')

@section('content')
<div class="container">
    <table class="table table-striped data-table table-responsive">
        <tr>
            <th class="text-center">Date</th>
            <th class="text-center">Name</th>
            <th class="text-center">IP address</th>
            <th class="text-center">Platform</th>
        </tr>
        @foreach ($logs as $log)
            <tr>
                <td class="text-center" width="20%">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d h:i A') }}</td>
                <td class="text-center" width="10%">{{ optional($log->user)->name }}</td>
                <td class="text-center" width="20%">{{ $log->ip_address }}</td>
                <td class="text-center" width="60%">{{ $log->browser_agent }}</td>
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
                    {{ $logs->links() }}
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection