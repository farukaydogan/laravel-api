<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'created_at', 'updated_at'];
    protected $guarded = [];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
}
