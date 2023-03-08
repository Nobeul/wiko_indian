@extends('admin.app')

@section('content')
<div class="container ps-4 pe-4">
    <form method="post" action="{{ url('create-new-buyer') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_type" value="2">
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                @if ($errors->first('name'))
                    <p class="text-danger small">{{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                @if ($errors->first('email'))
                    <p class="text-danger small">{{ $errors->first('email') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                @if ($errors->first('phone'))
                    <p class="text-danger small">{{ $errors->first('phone') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Country</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="country_id">
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ $country->id == 226 ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('country'))
                    <p class="text-danger small">{{ $errors->first('country') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">City</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                @if ($errors->first('city'))
                    <p class="text-danger small">{{ $errors->first('city') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">State</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="state" value="{{ old('state') }}">
                @if ($errors->first('state'))
                    <p class="text-danger small">{{ $errors->first('state') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                @if ($errors->first('address'))
                    <p class="text-danger small">{{ $errors->first('address') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Is Recommended</label>
            <div class="col-sm-10">
                <select name="is_recommended" id="is_recommended" class="form-control">
                    <option value="0" {{ old('is_recommended') == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('is_recommended') == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                @if ($errors->first('is_recommended'))
                    <p class="text-danger small">{{ $errors->first('is_recommended') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" id="inputPassword">
                @if ($errors->first('password'))
                    <p class="text-danger small">{{ $errors->first('password') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Confirm Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password_confirmation" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Buyer Picture</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="profile_image">
                @if ($errors->first('profile_image'))
                    <p class="text-danger small">{{ $errors->first('profile_image') }}
                    </p>
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
</div>
@endsection
