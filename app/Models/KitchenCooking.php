<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenCooking extends Model
{
    use HasFactory;

    protected $table = 'kitchen_cooking';
    protected $primaryKey = 'KitchenID';
    public $timestamps = true;

    protected $fillable = [
        'order_name',
        'order_type',
        'special_request',
        'subtotal',
        'status' // Make sure this is included
    ];

    public function products()
    {
        return $this->hasMany(KitchenCookingProduct::class, 'kitchen_cooking_id', 'KitchenID');
    }
}