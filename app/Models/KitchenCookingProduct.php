<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenCookingProduct extends Model
{
    use HasFactory;

    protected $table = 'kitchen_cooking_products';
    public $timestamps = true;

    protected $fillable = [
        'kitchen_cooking_id',
        'product_name',
        'size',
        'quantity',
        'price'
    ];

    public function kitchenCooking()
    {
        return $this->belongsTo(KitchenCooking::class, 'kitchen_cooking_id', 'KitchenID');
    }
}