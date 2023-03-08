<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table    = 'files';
    protected $fillable = ['uploaded_by', 'file_name', 'original_file_name'];
    public $timestamps = false; 
}
