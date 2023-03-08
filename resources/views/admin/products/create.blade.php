@extends('admin.app')

@section('css')
<!-- bootstrap-select -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/bootstrap-select-1.13.12/css/bootstrap-select.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/select2/select2.min.css') }}">
@endsection

@section('content')
<div class="container ps-4 pe-4">
    <form method="post" action="{{ url('create-new-product') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="is_buyer" value="1">
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
        {{-- <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                @if ($errors->first('price'))
                    <p class="text-danger small">{{ $errors->first('price') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Discount(%)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="discount" value="{{ old('discount') }}">
                @if ($errors->first('discount'))
                    <p class="text-danger small">{{ $errors->first('discount') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Available Quantity</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="available_quantity" value="{{ old('available_quantity') }}">
                @if ($errors->first('available_quantity'))
                    <p class="text-danger small">{{ $errors->first('available_quantity') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Is Negotiable</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="is_negotiable">
                    <option value="0" >No</option>
                    <option value="1">Yes</option>
                </select>
                @if ($errors->first('is_negotiable'))
                    <p class="text-danger small">{{ $errors->first('is_negotiable') }}
                    </p>
                @endif
            </div>
        </div> --}}
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Is Recommended</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="is_recommended">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
                @if ($errors->first('is_recommended'))
                    <p class="text-danger small">{{ $errors->first('is_recommended') }}
                    </p>
                @endif
            </div>
        </div>
        {{-- <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Location</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="location_id[]" id="location" multiple>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('location_id'))
                    <p class="text-danger small">{{ $errors->first('location_id') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Size</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="size_id[]" id="size" multiple>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('size_id'))
                    <p class="text-danger small">{{ $errors->first('size_id') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Unit</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="unit_id[]" id="unit" multiple>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('unit_id'))
                    <p class="text-danger small">{{ $errors->first('unit_id') }}
                    </p>
                @endif
            </div>
        </div> --}}
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Variety</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="variety_id[]" id="variety" multiple>
                    @foreach ($varieties as $variety)
                        <option value="{{ $variety->id }}">{{ $variety->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('variety_id'))
                    <p class="text-danger small">{{ $errors->first('variety_id') }}
                    </p>
                @endif
            </div>
        </div>
        {{-- <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">packaging Material</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="packaging_material_id[]" id="material" multiple>
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('packaging_material_id'))
                    <p class="text-danger small">{{ $errors->first('packaging_material_id') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">packaging Size</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="packaging_size_id[]" id="packaging_size" multiple>
                    @foreach ($packaging_sizes as $pack_size)
                        <option value="{{ $pack_size->id }}">{{ $pack_size->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('packaging_size_id'))
                    <p class="text-danger small">{{ $errors->first('packaging_size_id') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Sellers</label>
            <div class="col-sm-10">
                <select class="form-select" aria-label="Default select example" name="user_id[]" id="seller" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('seller'))
                    <p class="text-danger small">{{ $errors->first('seller') }}
                    </p>
                @endif
            </div>
        </div> --}}
        <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
</div>
@endsection

@section('script')
<!-- bootstrap-select -->
<script src="{{ asset('public/backend/bootstrap-select-1.13.12/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- Select2 -->
<script src="{{ asset('public/backend/select2/select2.full.min.js') }}" type="text/javascript"></script>
<script>
    $('#location, #size, #unit, #variety, #material, #packaging_size, #seller').select2();
</script>
@endsection
