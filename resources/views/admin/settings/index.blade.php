@extends('admin.app')

@section('content')
<div class="container ps-4 pe-4" style="margin-bottom: 300px">
    <form method="post" action="{{ url('company-settings') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Company Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="company_name" value="{{ isset($company_settings->company_name) ? $company_settings->company_name : old('company_name') }}">
                @if ($errors->first('company_name'))
                    <p class="text-danger small">{{ $errors->first('company_name') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Mail Driver</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="mail_driver" value="{{ isset($company_settings->mail_driver) ? $company_settings->mail_driver : old('mail_driver') }}">
                @if ($errors->first('mail_driver'))
                    <p class="text-danger small">{{ $errors->first('mail_driver') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Mail Host</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="mail_host" value="{{ isset($company_settings->mail_host) ? $company_settings->mail_host : old('mail_host') }}">
                @if ($errors->first('mail_host'))
                    <p class="text-danger small">{{ $errors->first('mail_host') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Mail Port</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="mail_port" value="{{ isset($company_settings->mail_port) ? $company_settings->mail_port : old('mail_port') }}">
                @if ($errors->first('mail_port'))
                    <p class="text-danger small">{{ $errors->first('mail_port') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Mail Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="mail_username" value="{{ isset($company_settings->mail_username) ? $company_settings->mail_username : old('mail_username') }}">
                @if ($errors->first('mail_username'))
                    <p class="text-danger small">{{ $errors->first('mail_username') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Mail Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="mail_password" value="{{ isset($company_settings->mail_password) ? $company_settings->mail_password : old('mail_password') }}">
                @if ($errors->first('mail_password'))
                    <p class="text-danger small">{{ $errors->first('mail_password') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Mail Encryption</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="mail_encryption" value="{{ isset($company_settings->mail_encryption) ? $company_settings->mail_encryption : old('mail_encryption') }}">
                @if ($errors->first('mail_encryption'))
                    <p class="text-danger small">{{ $errors->first('mail_encryption') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Mail From Address</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="mail_from_address"  value="{{ isset($company_settings->mail_from_address) ? $company_settings->mail_from_address : old('mail_from_address') }}">
                @if ($errors->first('mail_from_address'))
                    <p class="text-danger small">{{ $errors->first('mail_from_address') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Company Image</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="company_image">
                @if ($errors->first('company_image'))
                    <p class="text-danger small">{{ $errors->first('company_image') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-md-2"></div>
            <div class="col-sm-10">
                @if (!empty($company_image))
                    <img src="{{ asset('public/admin/assets/img/company_settings/'.$company_image) }}" class="img-fluid" alt="Company image">
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
</div>
@endsection