<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VerificationType;
use App\User;

class Verification extends Model
{
    protected $table    = 'verifications';
    protected $fillable = ['user_id', 'front_image', 'back_image', 'verification_type_id', 'verification_status'];
    protected $hidden   = ['updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verificationType()
    {
        return $this->hasOne(VerificationType::class, 'id', 'verification_type_id');
    }

    public static function getVerificationsByFiltering(array $filters, $pagination = false, $limit = false)
    {
        $query = self::query();
        $query = $query->with('user');

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['user_id'])) {
            $query = $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['status'])) {
            $query = $query->where('verification_status', $filters['status']);
        }

        if (!empty($filters['verification_type_id'])) {
            $query = $query->where('verification_type_id', $filters['verification_type_id']);
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

    public function newVerification(array $data)
    {
        try {
            \DB::beginTransaction();

            $front_image = $data['front_image'];
            $back_image = $data['back_image'];
            if (isset($front_image)) {
                $imageName = time().'.'.$data['front_image']->extension();  
         
                $data['front_image']->move(public_path('admin/assets/img/verifications/'), $imageName);
                $front_image = $imageName;
            }
            if (isset($back_image)) {
                $imageName = time().'.'.$data['back_image']->extension();  
         
                $data['back_image']->move(public_path('admin/assets/img/verifications/'), $imageName);
                $back_image = $imageName;
            }
            self::create([
                'user_id' => $data['user_id'],
                'front_image' => $front_image,
                'back_image' => $back_image,
                'verification_status' => !empty($data['verification_status']) ? $data['verification_status'] : 'pending',
                'verification_type_id' => $data['verification_type_id']
            ]);
            
            \DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Verification has been added successfully. Please wait for the approval',
                'verification_status' => 'pending',
            ], 200);
        } catch(\Throwable $th) {
            \DB::rollback();

            return response()->json([
                'status' => 400,
                'message' => $th
            ], 400);
        }
    }

    public function editVerification(Verification $verification, array $data)
    {
        try {
            \DB::beginTransaction();

            $verification_data = [
                'verification_status' => $data['verification_status']
            ];
            $verification->update($verification_data);

            
            \DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Verification has been updated successfully'
            ], 200);
        } catch(\Throwable $th) {
            \DB::rollback();

            return response()->json([
                'status' => 400,
                'message' => $th
            ], 400);
        }
    }

}
