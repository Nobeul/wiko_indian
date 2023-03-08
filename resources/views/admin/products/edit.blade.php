@extends('admin.app')

@section('css')
<!-- bootstrap-select -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/bootstrap-select-1.13.12/css/bootstrap-select.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/select2/select2.min.css') }}">
@endsection

@section('content')
<div class="container ps-4 pe-4">
    <form method="post" action="{{ url('product/'.$product->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="is_buyer" value="1">
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}">
                @if ($errors->first('name'))
                    <p class="text-danger small">{{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>
        {{-- <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}">
                @if ($errors->first('price'))
                    <p class="text-danger small">{{ $errors->first('price') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Discount(%)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="discount" value="{{ old('discount', $product->discount) }}">
                @if ($errors->first('discount'))
                    <p class="text-danger small">{{ $errors->first('discount') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Available Quantity</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="available_quantity" value="{{ old('available_quantity', $product->available_quantity) }}">
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
                    <option value="0" {{ $product->is_negotiable == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $product->is_negotiable == 1 ? 'selected' : '' }}>Yes</option>
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
                    <option value="0" {{ $product->is_recommended == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $product->is_recommended == 1 ? 'selected' : '' }}>Yes</option>
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
                        <option value="{{ $location->id }}" {{ in_array($location->id, $product_locations) ? 'selected' : '' }}>{{ $location->name }}</option>
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
                        <option value="{{ $size->id }}" {{ in_array($size->id, $product_sizes) ? 'selected' : '' }}>{{ $size->name }}</option>
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
                        <option value="{{ $unit->id }}" {{ in_array($unit->id, $product_units) ? 'selected' : '' }}>{{ $unit->name }}</option>
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
                        <option value="{{ $variety->id }}" {{ in_array($variety->id, $product_varieties) ? 'selected' : '' }}>{{ $variety->name }}</option>
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
                        <option value="{{ $material->id }}" {{ in_array($material->id, $product_packaging_materials) ? 'selected' : '' }}>{{ $material->name }}</option>
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
                        <option value="{{ $pack_size->id }}" {{ in_array($pack_size->id, $product_packaging_sizes) ? 'selected' : '' }}>{{ $pack_size->name }}</option>
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
                <select class="form-select" aria-label="Default select example" name="seller[]" id="seller" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, $users_array) ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('seller'))
                    <p class="text-danger small">{{ $errors->first('seller') }}
                    </p>
                @endif
            </div>
        </div> --}}
        {{-- <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Product Picture</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="product_image[]" multiple>
                @if ($errors->first('product_image'))
                    <p class="text-danger small">{{ $errors->first('product_image') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-2"></div>
            @if ($product->images)
                <div class="col-sm-10">
                    @php
                        $images = json_decode($product->images);
                    @endphp

                    <div class="row">
                        @foreach ($images as $image)
                            <div class="col-md-3">
                                <img src="{{ asset('public/admin/assets/img/products/'.$image) }}" class="img-fluid">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
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
