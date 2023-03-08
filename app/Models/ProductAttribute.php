<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Product,
    Size
};

class ProductAttribute extends Model
{
    protected $table    = 'product_attribute';
    public $timestamps = false;
}
