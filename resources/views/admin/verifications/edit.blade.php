@extends('admin.app')

@section('content')
<div class="container ps-4 pe-4">
    <form method="post" class="mb-4" action="{{ url('edit-verification/'.$verification->id) }}">
        @csrf
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">User Name</label>
            <div class="col-sm-10">
                <h4>{{ optional($verification->user)->name }}</h4>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Verification Type</label>
            <div class="col-sm-10">
                {{ optional($verification->verificationType)->name }}
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Front Image</label>
            <div class="col-sm-10">
                <a href="{{ asset('public/admin/assets/img/verifications/'.$verification->front_image) }}" download>{{ $verification->front_image }}</a>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Back Image</label>
            <div class="col-sm-10">
                <a href="{{ asset('public/admin/assets/img/verifications/'.$verification->back_image) }}" download>{{ $verification->back_image }}</a>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Verification Status</label>
            <div class="col-sm-10">
                <select name="verification_status" class="form-control">
                    <option value="pending" {{ $verification->verification_status == "pending" ? 'selected' : "" }}>Pending</option>
                    <option value="rejected" {{ $verification->verification_status == "rejected" ? 'selected' : "" }}>Rejected</option>
                    <option value="approved" {{ $verification->verification_status == "approved" ? 'selected' : "" }}>Approved</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
</div>
@endsection