@extends('admin.app')

@section('content')
<div class="container ps-4 pe-4">
    <form method="post" action="{{ url('create-new-verification') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Verification Type</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="verification_type_id">
                    @foreach ($verification_types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('verification_type_id'))
                    <p class="text-danger small">{{ $errors->first('verification_type_id') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Company</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="user_id">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('user_id'))
                    <p class="text-danger small">{{ $errors->first('user_id') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="verification_status">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                @if ($errors->first('verification_status'))
                    <p class="text-danger small">{{ $errors->first('verification_status') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Front Image</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="front_image">
                @if ($errors->first('front_image'))
                    <p class="text-danger small">{{ $errors->first('front_image') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Back Image</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="back_image">
                @if ($errors->first('back_image'))
                    <p class="text-danger small">{{ $errors->first('back_image') }}
                    </p>
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
</div>
@endsection
