<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use App\Models\Country;
use App\Models\Verification;
use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\Rating;
use App\Models\Order;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'phone', 'profile_image', 'country_id', 'city', 'state', 'address', 'deal_id', 'is_payment_verified', 'is_kyc_verified', 'is_recommended', 'company_name', 'in_business_since', 'exporting_countries'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot', 'email', 'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function verifications()
    {
        return $this->hasMany(Verification::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id', 'id');
    }

    public function activityLog()
    {
        return $this->hasOne(ActivityLog::Class)->latest();
    }

    protected $appends = ['rating'];
    public function getRatingAttribute()
    {
        $count = $this->ratings()->count();
        if ($count > 0) {
            $total = $this->ratings()->sum('rating');
            return $total / $count;
        } else {
            return 0;
        }
    }

    public static function getUsersByFiltering(array $filters, $pagination = false, $limit = false)
    {
        $query = self::with(['ratings', 'country', 'verifications', 'products', 'activityLog', 'orders', 'orders.product']);

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['name'])) {
            $query = $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['phone'])) {
            $query = $query->where('phone', $filters['phone']);
        }

        if (!empty($filters['user_type'])) {
            $query = $query->where('user_type', $filters['user_type']);
        }

        if (!empty($filters['country_id'])) {
            $query = $query->where('country_id', $filters['country_id']);
        }

        if (!empty($filters['deal_id'])) {
            $query = $query->where('deal_id', $filters['deal_id']);
        }

        if (!empty($filters['is_payment_verified'])) {
            $query = $query->where('is_payment_verified', $filters['is_payment_verified']);
        }

        if (isset($filters['is_kyc_verified'])) {
            $query = $query->where('is_kyc_verified', $filters['is_kyc_verified']);
        }
        
        if (isset($filters['in_business_since'])) {
            $query = $query->where('in_business_since', $filters['in_business_since']);
        }

        if (isset($filters['is_recommended'])) {
            $query = $query->where('is_recommended', $filters['is_recommended']);
        }

        if (!empty($filters['with'])) {
            $query->with($filters['with']);
        }

        if (!empty($filters['order_by'])) {
            $query = $query->orderBy($filters['order_by'], 'desc');
        } else {
            $query = $query->orderBy('id', 'desc');
        }

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
        return self::with(['ratings', 'country', 'verifications', 'products', 'activityLog'])->find($id);
    }

    public function newUser(array $data)
    {
        if (isset($data['profile_image'])) {
            $imageName = time().'.'.$data['profile_image']->extension();  
     
            $data['profile_image']->move(public_path('admin/assets/img/avatars/'), $imageName);
        }
        try {
            \DB::beginTransaction();
            self::create([
                'name' => $data['name'],
                'email' => isset($data['email']) ? $data['email'] : null,
                'password' => isset($data['password']) ? Hash::make($data['password']) : null,
                'user_type' => isset($data['user_type']) ? $data['user_type'] : 2,          
                'phone' => isset($data['phone']) ? $data['phone'] : null,          
                'country_id' => isset($data['country_id']) ? $data['country_id'] : 226,
                'city' => isset($data['city']) ? $data['city'] : null,
                'state' => isset($data['state']) ? $data['state'] : null,
                'address' => isset($data['address']) ? $data['address'] : null,
                'profile_image' => isset($data['profile_image']) ? public_path('admin/assets/img/avatars/').$imageName : null,
                'deal_id' => unique_code(),
                'is_payment_verified' => isset($data['is_payment_verified']) ? 1 : 0,
                'is_kyc_verified' => isset($data['is_kyc_verified']) ? 1 : 0,
                'is_recommended' => isset($data['is_recommended']) ? 1 : 0,
                'company_name' => isset($data['company_name']) ? $data['company_name'] : null,
                'in_business_since' => isset($data['in_business_since']) ? $data['in_business_since'] : null,
                'partners' => isset($data['partners']) ? implode(",", $data['partners']) : null,
                'exporting_countries' => isset($data['exporting_countries']) ? implode(",", $data['exporting_countries']) : null
            ]);
            \DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'A new user created'
            ], 200);
        } catch(\Throwable $th) {
            \DB::rollback();

            return response()->json([
                'status' => 400,
                'message' => $th
            ], 400);
        }
        
    }

    public function updateUser(User $user, array $data)
    {
        try {
            \DB::beginTransaction();
            $user->name = $data['name'];
            if (isset($data['email'])) {
                $user->email = $data['email'];
            }
            if (isset($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            if (isset($data['user_type'])) {
                $user->user_type =  $data['user_type'];
            }
            if (isset($data['phone'])) {
                $user->phone =  $data['phone'];
            }
            if (isset($data['profile_image'])) {
                if ($user->profile_image && file_exists(public_path('admin/assets/img/avatars/'.$user->profile_image))) {
                    unlink(public_path('admin/assets/img/avatars/'.$user->profile_image));
                }
                $imageName = time().'.'.$data['profile_image']->extension();  
         
                $data['profile_image']->move(public_path('admin/assets/img/avatars/'), $imageName);
                $user->profile_image = $imageName;
            }
            if (isset($data['country_id'])) {
                $user->country_id = $data['country_id'];
            }
            if (isset($data['city'])) {
                $user->city = $data['city'];
            }
            if (isset($data['state'])) {
                $user->state = $data['state'];
            }
            if (isset($data['address'])) {
                $user->address = $data['address'];
            }
            if (isset($data['company_name'])) {
                $user->company_name = $data['company_name'];
            }
            if (isset($data['is_payment_verified'])) {
                $user->is_payment_verified = $data['is_payment_verified'] == 1 ? 1 : 0;
            }
            if (isset($data['is_kyc_verified'])) {
                $user->is_kyc_verified = $data['is_kyc_verified'] == 1 ? 1 : 0;
            }
            if (isset($data['in_business_since'])) {
                $user->in_business_since = $data['in_business_since'];
            }
            if (isset($data['is_recommended'])) {
                $user->is_recommended = $data['is_recommended'] == 1 ? 1 : 0;
            }
            if (isset($data['partners'])) {
                $user->partners = implode(",", $data['partners']);
            }
            if (isset($data['exporting_countries'])) {
                $user->exporting_countries = implode(",", $data['exporting_countries']);
            }
            if (isset($data['transportation_up_to'])) {
                $user->transportation_up_to = $data['transportation_up_to'];
            }
    
            $user->save();
            \DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'User has been updated successfully'
            ], 200);
        } catch (\Throwable $th) {
            \DB::rollback();

            return response()->json([
                'status' => 400,
                'message' => $th
            ], 400);
        }
    }
}