@extends('admin.app')

@section('content')
<div class="container ps-4 pe-4">
    <form method="post" class="mb-4" action="{{ url('buyers/'.$buyer->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="is_buyer" value="1">
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ old('name', $buyer->name) }}">
                @if ($errors->first('name'))
                    <p class="text-danger small">{{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control" value="{{ old('email', $buyer->email) }}">
                @if ($errors->first('email'))
                    <p class="text-danger small">{{ $errors->first('email') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $buyer->phone) }}">
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
                        <option value="{{ $country->id }}" {{ $country->id == $buyer->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
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
                <input type="text" class="form-control" name="city" value="{{ old('city', $buyer->city) }}">
                @if ($errors->first('city'))
                    <p class="text-danger small">{{ $errors->first('city') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">State</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="state" value="{{ old('state', $buyer->state) }}">
                @if ($errors->first('state'))
                    <p class="text-danger small">{{ $errors->first('state') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address" value="{{ old('address', $buyer->address) }}">
                @if ($errors->first('address'))
                    <p class="text-danger small">{{ $errors->first('address') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Company Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="company_name" value="{{ old('company_name', $buyer->company_name) }}">
                @if ($errors->first('company_name'))
                    <p class="text-danger small">{{ $errors->first('company_name') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Is KYC Verified</label>
            <div class="col-sm-10">
                <select class="form-control" name="is_kyc_verified">
                    <option value="0" {{ $buyer->is_kyc_verified ==0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $buyer->is_kyc_verified ==1 ? 'selected' : '' }}>Yes</option>
                </select>
                @if ($errors->first('is_kyc_verified'))
                    <p class="text-danger small">{{ $errors->first('is_kyc_verified') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Is Payment Verified</label>
            <div class="col-sm-10">
                <select class="form-control" name="is_payment_verified">
                    <option value="0" {{ $buyer->is_payment_verified == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $buyer->is_payment_verified == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                @if ($errors->first('is_kyc_verified'))
                    <p class="text-danger small">{{ $errors->first('is_kyc_verified') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Is Recommended</label>
            <div class="col-sm-10">
                <select name="is_recommended" id="is_recommended" class="form-control">
                    <option value="0" {{ $buyer->is_recommended == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $buyer->is_recommended == 1 ? 'selected' : '' }}>Yes</option>
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
        @if (count($buyer->verifications) > 0)
            @foreach ($buyer->verifications as $verification)
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">{{ optional($verification->verificationType)->name }} Front Image</label>
                    <div class="col-sm-10 mt-2">
                        <a href="{{ asset('public/admin/assets/img/verifications/'.$verification->front_image) }}" download>{{ $verification->front_image }}</a>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">{{ optional($verification->verificationType)->name }} Back Image</label>
                    <div class="col-sm-10 mt-2">
                        <a href="{{ asset('public/admin/assets/img/verifications/'.$verification->back_image) }}" download>{{ $verification->back_image }}</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Verification</label>
                <div class="col-sm-10">
                    <p class="mt-2">No Verification found!</p>
                </div>
            </div>
        @endif

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
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                @if ($buyer->profile_image)
                    <img src="{{ asset('public/admin/assets/img/avatars/'.$buyer->profile_image) }}" alt="Buyer profile image" class="img-fluid">
                @else 
                    <img src="{{ asset('public/admin/assets/img/avatars/default-profile.png') }}" alt="Buyer profile image" class="img-fluid">
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
</div>
@endsection
