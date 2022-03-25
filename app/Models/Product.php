<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

/**
 * Product
 *
 * @mixin \Elequent
 *
 * @OA\Schema (
 *     title="Product",
 *     description="Product model",
 *     type="object",
 *     schema="Product",
 *     @OA\Xml (
 *         name="Product"
 *     ),
 *     properties={
 *         @OA\Property (property="id", type="integer", format="int64", description="id column"),
 *         @OA\Property (property="name", type="string", description="product name"),
 *         @OA\Property (property="price", type="float", format="float64", description="product price")
 *     },
 *     required={"id","name","price"}
 * )
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = ['name', 'slug', 'price', 'description', 'created_at', 'updated_at']; // create ve update ile doldurulabilcek alanları tanımlarız.
    protected $guarded = []; // hangi kolonların create ve update komutları ile değiştirilemeyeceğini tanımlarız.
//    protected $hidden = ['slug'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
}

