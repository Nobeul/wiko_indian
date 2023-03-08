<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\File;
use App\Models\{
    Variety,
    Size,
    Location,
    Unit,
    Rating,
    AdminOfferedProduct,
    ProductImage,
    Country
};
use App\User;
use Carbon\Carbon;

class Product extends Model
{
    protected $table    = 'products';
    protected $fillable = ['variety_id', 'size_id', 'location_id', 'name', 'price', 'unit_id', 'available_quantity', 'is_negotiable', 'is_recommended', 'discount', 'sub_total', 'transportation_up_to', 'transportation_cost', 'status'];
    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    // need to add rating here

    public function variety()
    {
        return $this->belongsTo(Variety::class);
    }

    public function adminOfferedProduct()
    {
        return $this->belongsTo(AdminOfferedProduct::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'product_locations');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function packagingMaterial()
    {
        return $this->belongsTo(PackagingMaterial::class);
    }

    public function packagingSize()
    {
        return $this->belongsTo(PackagingSize::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function exportingCountries()
    {
        return $this->belongsToMany(Country::class, 'product_countries');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function getProductsByFiltering(array $filters, $pagination = false, $limit = false) 
    {
        $query = self::query();

        $query = $query->with(['adminOfferedProduct', 'variety', 'size', 'unit', 'packagingMaterial', 'packagingSize', 'exportingCountries', 'locations', 'user', 'ratings', 'user.ratings', 'images']);

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['admin_offered_product_id'])) {
            $query = $query->where('admin_offered_product_id', $filters['admin_offered_product_id']);
        }

        if (!empty($filters['price'])) {
            $query = $query->where('price', $filters['price']);
        }

        if (!empty($filters['available_quantity'])) {
            $query = $query->where('available_quantity', $filters['available_quantity']);
        }

        if (!empty($filters['is_negotiable'])) {
            $query = $query->where('is_negotiable', $filters['is_negotiable']);
        }

        if (!empty($filters['is_recommended'])) {
            $query = $query->where('is_recommended', $filters['is_recommended']);
        }

        if (!empty($filters['name'])) {
            $search = $filters['name'];
            $query = $query->whereHas('adminOfferedProduct', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        }

        // if (!empty($filters['location'])) {
        //     $search = $filters['location'];
        //     $query = $query->whereHas('locations', function ($query) use ($search) {
        //         $query->whereIn('name', $search);
        //     });
        // }

        if (!empty($filters['size_id'])) {
            $search = $filters['size_id'];
            $query = $query->whereHas('size', function ($query) use ($search) {
                $query->where('id', $search)->orWhere('name', 'like', '%'.$search.'%');
            });
        }

        if (!empty($filters['unit_id'])) {
            $search = $filters['unit_id'];
            $query = $query->whereHas('unit', function ($query) use ($search) {
                $query->where('id', $search)->orWhere('name', 'like', '%'.$search.'%');
            });
        }

        if (!empty($filters['variety_id'])) {
            $search = $filters['variety_id'];
            $query = $query->whereHas('variety', function ($query) use ($search) {
                $query->where('id', $search)->orWhere('name', 'like', '%'.$search.'%');
            });
        }

        if (!empty($filters['packaging_material_id'])) {
            $search = $filters['packaging_material_id'];
            $query = $query->whereHas('packagingMaterial', function ($query) use ($search) {
                $query->where('id', $search)->orWhere('name', 'like', '%'.$search.'%');
            });
        }

        if (!empty($filters['packaging_size_id'])) {
            $search = $filters['packaging_size_id'];
            $query = $query->whereHas('packagingSize', function ($query) use ($search) {
                $query->where('id', $search)->orWhere('name', 'like', '%'.$search.'%');
            });
        }

        if (!empty($filters['user_id'])) {
            $search = $filters['user_id'];
            $query = $query->whereHas('user', function ($query) use ($search) {
                $query->where('id', $search)->orWhere('name', 'like', '%'.$search.'%');
            });
        }
        
        if (!empty($filters['seller_id'])) {
            $query = $query->where('user_id', $filters['seller_id']);
        }
        

        if (!empty($filters['transportation_up_to'])) {
            $search = $filters['transportation_up_to'];
            $query = $query->where('transportation_up_to', $search);
        }

        if (!empty($filters['available_untill']) && empty($filters['expired_product'])) {
            $time = Carbon::parse($filters['available_untill'])->toDateTime();
            $query = $query->where('available_untill', '>=', $time);
        }

        if (empty($filters['available_untill']) && !empty($filters['expired_product'])) {
            $query = $query->where('available_untill', '<=', Carbon::now());
        }

        if (!empty($filters['order_pattern'])) {
            $order_pattern = strtolower($filters['order_pattern']) == 'asc' ? 'asc' : 'desc';
            if (!empty($filters['order_by'])) {
                $query = $query->orderBy($filters['order_by'], $order_pattern);
            }
        } else {
            if (!empty($filters['order_by'])) {
                $query = $query->orderBy($filters['order_by'], 'desc');
            } else {
                $query = $query->orderBy('id', 'desc');
            }
        }

        $query = $query->where('status', 1);
        if ($pagination) {
            if ($limit) {
                $query = $query->paginate($limit)->withQueryString();
            } else {
                $query = $query->paginate(10)->withQueryString();
            }
        } else if ($limit) {
            $query = $query->take($limit)->get();
        } else {
            $query = $query->get();
        }

        return $query;
    }

    public static function findById($id)
    {
        return self::with(['variety', 'size', 'unit', 'locations', 'packagingMaterial', 'packagingSize', 'exportingCountries', 'ratings', 'user', 'images', 'adminOfferedProduct'])->where('status', 1)->where('id', $id)->first();
    }

    public static function updateProduct(Product $product, array $data)
    {
        $product = $product->update($data);

        return true;
    }

    private function uploadProductImage($img, $product = null)
    {
        if (!empty($product)) {
            $this->deleteProductImage($img, $product);
        } else {
            $this->deleteProductImage($img);
        }
        
        $imageName = time().rand(1,10000).'.'.$img->extension();
        $upload_path = public_path('admin/assets/img/products');
        $img->move($upload_path, $imageName);

        return $upload_path.$imageName;
    }

    public function deleteProductImage($img, $product = null)
    {
        if ($product) {
            $images = json_decode($product->images);
            foreach($images as $img) {
                if (file_exists(public_path('admin/assets/img/products/'.$img))) {
                    unlink(public_path('admin/assets/img/products/'.$img));
                }
            }
        } else {
            if (file_exists(public_path('admin/assets/img/products/'.$img))) {
                unlink(public_path('admin/assets/img/products/'.$img));
            }
        }
    }

    public function newProduct(array $data)
    {
        try {
            \DB::beginTransaction();
            
            $product = new Product();
            $product->admin_offered_product_id = $data['admin_offered_product_id'];
            $product->variety_id = $data['variety_id'];
            $product->size_id = $data['size_id'];
            $product->unit_id = $data['unit_id'];
            $product->packaging_size_id = $data['packaging_size_id'];
            $product->packaging_material_id = $data['packaging_material_id'];
            $product->user_id = $data['user_id'];
            $product->price = $data['price'];
            $product->available_quantity = $data['available_quantity'];
            $product->transportation_up_to = isset($data['transportation_up_to']) ? $data['transportation_up_to'] : null;
            $product->transportation_cost = isset($data['transportation_cost']) ? $data['transportation_cost'] : 0;
            $product->is_negotiable = $data['is_negotiable'];
            $product->available_untill = $data['available_untill'];

            $product->save();

            $product->locations()->attach($data['location_id']);

            if (!empty($data['country_id'])) {
                $product->exportingCountries()->attach($data['country_id']);
            }

            \DB::commit();

            if (!empty($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $image) {
                    $image_name = $this->uploadProductImage($image);
                    $product_image = new ProductImage;
                    $product_image->product_id = $product->id;
                    $product_image->image = $image_name;
                    $product_image->save();
                }
            }
    
            return response()->json([
                'status' => 200,
                'message' => 'A new product has been created'
            ]);
        } catch(\Throwable $th) {
            \DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => $th
            ]);
        }

    }

    public function editProduct(Product $product, array $data)
    {
        try {
            \DB::beginTransaction();
            
            if (!empty($data['admin_offered_product_id'])) {
                $product->admin_offered_product_id = $data['admin_offered_product_id'];
            }
            if (!empty($data['size_id'])) {
                $product->size_id = $data['size_id'];
            }
            if (!empty($data['unit_id'])) {
                $product->unit_id = $data['unit_id'];
            }
            if (!empty($data['variety_id'])) {
                $product->variety_id = $data['variety_id'];
            }
            if (!empty($data['packaging_material_id'])) {
                $product->packaging_material_id = $data['packaging_material_id'];
            }
            if (!empty($data['packaging_size_id'])) {
                $product->packaging_size_id = $data['packaging_size_id'];
            }
            if (!empty($data['user_id'])) {
                $product->user_id = $data['user_id'];
            }
            if (!empty($data['price'])) {
                $product->price = $data['price'];
            }
            if (!empty($data['available_quantity'])) {
                $product->available_quantity = $data['available_quantity'];
            }
            if ($data['is_negotiable'] === '0' || $data['is_negotiable'] === '1') {
                $product->is_negotiable = $data['is_negotiable'];
            }
            if (!empty($data['available_untill'])) {
                $product->available_untill = $data['available_untill'];
            }
            if (!empty($data['transportation_up_to'])) {
                $product->transportation_up_to = $data['transportation_up_to'];
            }
            if (!empty($data['transportation_cost'])) {
                $product->transportation_cost = $data['transportation_cost'];
            }

            $product->save();
            
            if (!empty($data['location_id'])) {
                $product->locations()->sync($data['location_id']);
            }

            if (!empty($data['country_id'])) {
                $product->exportingCountries()->sync($data['country_id']);
            }

            if (!empty($data['images']) && is_array($data['images'])) {
                $product_images = (new ProductImage())::where('product_id', $product->id)->pluck('id')->toArray();
                foreach ($data['images'] as $image) {
                    (new ProductImage())->destroy($product_images);
                    $image_name = $this->uploadProductImage($image, $product);
                    (new ProductImage())::create([
                        'product_id' => $product->id,
                        'image' => $image_name
                    ]);
                }
            }

            \DB::commit();
    
            return response()->json([
                'status' => 200,
                'message' => 'Product updated successfully'
            ]);
        } catch(\Throwable $th) {
            \DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => $th
            ]);
        }
    }
}
