<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'sku',
        'name',
        'stock',
        'avatar',
        'exprired_at',
        'category_id',
        'flag_delete',
    ];
    public function scopeSearch($query)
    {
        if ($product_name = request()->product_name) {
            $query = $query->where('products.name', 'like', "%{$product_name}%");
        }
        if ($category_name = request()->category_name) {
            $query = $query->where('categories.name', 'like', "%{$category_name}%");
        }
        if ($stock = request()->stock) {
            switch ($stock) {
                case '1':
                    $query = $query->where('stock', '<', 10);
                    break;
                case '2':
                    $query = $query->whereBetween('stock', [10, 100]);
                    break;
                case '3':
                    $query = $query->whereBetween('stock', [100, 200]);
                    break;
                case '4':
                    $query = $query->where('stock', '>', 200);
                    break;
                default:
                    break;
            }
        }
        return $query;
    }
}
