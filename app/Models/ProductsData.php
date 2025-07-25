<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsData extends Model
{
    use HasFactory;

    protected $table = 'productsData';
    protected $primaryKey = 'productID';

    protected $fillable = [
        'productName',
        'productDescription',
        'productCategory',
        'productSubcategory',
        'productPrice',
        'productImage',
    ];
}