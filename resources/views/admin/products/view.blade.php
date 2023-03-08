@extends('admin.app')

@section('content')
<div class="container ps-4 pe-4">
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Name</label>
        <div class="col-sm-8">
            <label for="staticEmail" class="col-sm-4 col-form-label">{{ $product->name }}</label>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Is Recommended</label>
        <div class="col-sm-8">
            <label for="staticEmail" class="col-sm-4 col-form-label">{{ $product->is_recommended == 1 ? 'Yes' : 'No' }}</label>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Available Varieties</label>
        <div class="col-sm-8">
            <label for="staticEmail" class="col-sm-4 col-form-label">{{ implode(", ", $product->varieties->pluck('name')->toArray()) }}</label>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Available Sizes</label>
        <div class="col-sm-8">
            <label for="staticEmail" class="col-sm-4 col-form-label">
                @foreach($product->varieties as $variety)
                    {{ implode(", ", $variety->sizes->pluck('name')->toArray()) }}
                @endforeach
            </label>

        </div>
    </div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Available Units</label>
        <div class="col-sm-8">
            <label for="staticEmail" class="col-sm-4 col-form-label">
                @foreach($product->varieties as $variety)
                    {{ implode(", ", $variety->units->pluck('name')->toArray()) }}
                @endforeach
            </label>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Available Packaging Sizes</label>
        <div class="col-sm-8">
            <label for="staticEmail" class="col-sm-4 col-form-label">
                @foreach($product->varieties as $variety)
                    {{ implode(", ", $variety->packaging_sizes->pluck('name')->toArray()) }}
                @endforeach
            </label>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Available Packaging Materials</label>
        <div class="col-sm-8">
            <label for="staticEmail" class="col-sm-4 col-form-label">
                @foreach($product->varieties as $variety)
                    {{ implode(", ", $variety->packaging_materials->pluck('name')->toArray()) }}
                @endforeach
            </label>
        </div>
    </div>
    <a href="{{ url('products') }}" class="btn btn-outline-primary">Back</a>
</div>
@endsection