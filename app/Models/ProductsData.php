<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsData extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id'; // Changed to 'id' to match your migration

    protected $fillable = [
        'productName',
        'productDescription',
        'productCategory',
        'productSubcategory',
        'productPrice',
        'productImage',
        'productAvailability', // Add this
    ];

    // Relationship to menuCategory
    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'productCategory', 'menuCategoryID');
    }
}