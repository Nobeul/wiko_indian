@extends('admin.app')

@section('css')
<!-- bootstrap-select -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/bootstrap-select-1.13.12/css/bootstrap-select.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/backend/select2/select2.min.css') }}">
@endsection

@section('content')
<div class="container ps-4 pe-4">
    <form method="post" action="{{ url('variety/'.$variety->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ old('name', $variety->name) }}">
                @if ($errors->first('name'))
                    <p class="text-danger small">{{ $errors->first('name') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Size</label>
            <div class="col-sm-10">
                <select class="form-select" name="size_id[]" id="size" multiple>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}" {{ in_array($size->id, $variety_sizes) ? 'selected' : '' }}>{{ $size->name }}</option>
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
                <select class="form-select" name="unit_id[]" id="unit" multiple>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" {{ in_array($unit->id, $variety_units) ? 'selected' : '' }}>{{ $unit->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('unit_id'))
                    <p class="text-danger small">{{ $errors->first('unit_id') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Packaging Size</label>
            <div class="col-sm-10">
                <select class="form-select" name="packaging_size_id[]" id="packaging_size" multiple>
                    @foreach ($packaging_sizes as $packaging_size)
                        <option value="{{ $packaging_size->id }}" {{ in_array($packaging_size->id, $variety_packaging_sizes) ? 'selected' : '' }}>{{ $packaging_size->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('packaging_size_id'))
                    <p class="text-danger small">{{ $errors->first('packaging_size_id') }}
                    </p>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Packaging Material</label>
            <div class="col-sm-10">
                <select class="form-select" name="packaging_material_id[]" id="packaging_material" multiple>
                    @foreach ($packaging_materials as $packaging_material)
                        <option value="{{ $packaging_material->id }}" {{ in_array($packaging_material->id, $variety_packaging_materials) ? 'selected' : '' }}>{{ $packaging_material->name }}</option>
                    @endforeach
                </select>
                @if ($errors->first('packaging_material_id'))
                    <p class="text-danger small">{{ $errors->first('packaging_material_id') }}
                    </p>
                @endif
            </div>
        </div>
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
    $('#size, #unit, #packaging_size, #packaging_material').select2();

</script>
@endsection
