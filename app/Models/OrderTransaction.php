<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'OrderID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'OrderID', 'order_type', 'order_date', 'special_request', 
        'total_items', 'subtotal', 'tax', 'totalAmount', 'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->OrderID)) {
                // Get the last order ID
                $lastOrder = OrderTransaction::orderBy('created_at', 'desc')->first();
                $nextId = 1;
                
                if ($lastOrder) {
                    // Extract the numeric part and increment
                    $lastIdNumber = (int) substr($lastOrder->OrderID, 5);
                    $nextId = $lastIdNumber + 1;
                }
                
                // Format the new ID
                $model->OrderID = 'CAFFE' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Define the relationship with MenuOrderTransaction
     */
    public function menuOrderItems()
    {
        return $this->hasMany(MenuOrderTransaction::class, 'OrderID', 'OrderID');
    }
}