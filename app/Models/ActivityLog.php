<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $fillable = ['user_id', 'type', 'ip_address', 'browser_agent'];
    protected $hidden   = ['updated_at'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function getActivityLogsByFiltering(array $filters, $pagination = false, $limit = false)
    {
        $query = self::with('user');

        if (!empty($filters['id'])) {
            $query = $query->where('id', $filters['id']);
        }

        if (!empty($filters['user_id'])) {
            $query = $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['user_type'])) {
            $query = $query->where('user_type', $filters['user_type']);
        }

        $query = $query->orderBy('id', 'desc')->where('type', '!=', 'Admin');

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
}
