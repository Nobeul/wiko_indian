@extends('admin.app')
@section('css')
<style>
    .chartjs-tooltip {
        margin-top: -300px;
    }
    a {
        color: inherit !important;
        text-decoration: inherit !important;
    }
</style>
@endsection
@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card mb-4 text-white bg-primary">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">{{ $total_user }}</div>
                                <div>Users</div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-transparent text-white p-0" type="button"
                                    data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg class="icon">
                                        <use
                                            xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-options') }}">
                                        </use>
                                    </svg>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                        href="#">Action</a><a class="dropdown-item" href="#">Another
                                        action</a><a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart1" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card mb-4 text-white bg-info">
                        <a href="{{ url('products-selling-today') }}">
                            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fs-4 fw-semibold">{{ $products_selling_today_count }}</div>
                                    <div>Products</div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-transparent text-white p-0" type="button"
                                        data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-options') }}">
                                            </use>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                            href="#">Action</a><a class="dropdown-item" href="#">Another
                                            action</a><a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            <canvas class="chart" id="card-chart2" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card mb-4 text-white bg-warning">
                        <a href="{{ url('sellers') }}">
                            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fs-4 fw-semibold">{{ $total_seller }}</div>
                                    <div>Sellers</div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-transparent text-white p-0" type="button"
                                        data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-options') }}">
                                            </use>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                            href="#">Action</a><a class="dropdown-item" href="#">Another
                                            action</a><a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart" id="card-chart3" height="70"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ url('buyers') }}">
                        <div class="card mb-4 text-white bg-danger">
                            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fs-4 fw-semibold">{{ $total_buyer }}</div>
                                    <div>Buyers</div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-transparent text-white p-0" type="button"
                                        data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-options') }}">
                                            </use>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                            href="#">Action</a><a class="dropdown-item" href="#">Another
                                            action</a><a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                <canvas class="chart" id="card-chart4" height="70"></canvas>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">Traffic</h4>
                            <div class="small text-medium-emphasis">{{ \Carbon\Carbon::now()->subMonths(6)->format('M') }} - {{ \Carbon\Carbon::now()->format('M') }} {{ \Carbon\Carbon::now()->format('Y') }}</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                        <canvas class="chart" id="main-chart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">Traffic &amp; Sales</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="border-start border-start-4 border-start-info px-3 mb-3">
                                                <small class="text-medium-emphasis">Total Clients</small>
                                                <div class="fs-5 fw-semibold">{{ $total_seller }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border-start border-start-4 border-start-success px-3 mb-3">
                                                <small class="text-medium-emphasis">Orders</small>
                                                <div class="fs-5 fw-semibold">{{ $total_order }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.row-->
                                </div>
                                <hr class="mt-0">
                                <!-- /.col-->
                            </div>
                            <!-- /.row-->
                            <div class="table-responsive">
                                <p>Activity Logs</p>
                                <table class="table border mb-0">
                                    <thead class="table-light fw-semibold">
                                        <tr class="align-middle">
                                            <th class="text-center">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="{{ asset('public/admin/vendors/@coreui/icons/svg/free.svg#cil-people') }}">
                                                    </use>
                                                </svg>
                                            </th>
                                            <th>User</th>
                                            <th class="text-center">Phone Number</th>
                                            <th>Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($activity_logs as $activity_log)
                                            <tr class="align-middle">
                                                <td class="text-center">
                                                    @if (optional($activity_log->user)->profile_image)
                                                        <div class="avatar avatar-md"><img class="avatar-img"
                                                            src="{{ asset('public/admin/assets/img/avatars/'.optional($activity_log->user)->profile_image) }}"
                                                            alt="user@email.com"><span
                                                            class="avatar-status bg-success"></span></div>
                                                    @else
                                                        <div class="avatar avatar-md"><img class="avatar-img"
                                                                src="{{ asset('public/admin/assets/img/avatars/default-profile.png') }}"
                                                                alt="user@email.com"><span
                                                                class="avatar-status bg-success"></span></div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>{{ optional($activity_log->user)->name }}</div>
                                                    <div class="small text-medium-emphasis">Registered: {{ \Carbon\Carbon::parse(optional($activity_log->user)->created_at)->format('Y-m-d') }}</div>
                                                </td>
                                                <td class="text-center">
                                                    {{ isset(optional($activity_log->user)->phone) && !empty(optional($activity_log->user)->phone) ? optional($activity_log->user)->phone : 'Phone Number not found' }}
                                                </td>
                                                <td>
                                                    <div class="small text-medium-emphasis">Last login</div>
                                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($activity_log->created_at)->format('Y-m-d') }}</div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center">No Users found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>
@endsection

