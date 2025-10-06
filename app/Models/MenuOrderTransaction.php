<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuOrderTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'OrderItemID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'OrderItemID', 'OrderID', 'ProductName', 'Quantity', 'unitPrice'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->OrderItemID)) {
                // Use a database transaction to prevent race conditions
                DB::transaction(function () use ($model) {
                    // Get the highest existing OrderItemID
                    $lastOrderItem = MenuOrderTransaction::lockForUpdate()
                        ->orderByRaw('CAST(SUBSTRING(OrderItemID, 5) AS UNSIGNED) DESC')
                        ->first();
                    
                    $nextId = 1;
                    
                    if ($lastOrderItem) {
                        // Extract the numeric part and increment
                        $lastIdNumber = (int) substr($lastOrderItem->OrderItemID, 4);
                        $nextId = $lastIdNumber + 1;
                    }
                    
                    // Format the new ID
                    $model->OrderItemID = 'MENU' . str_pad($nextId, 8, '0', STR_PAD_LEFT);
                });
            }
        });
    }

    /**
     * Define the relationship with OrderTransaction
     */
    public function orderTransaction()
    {
        return $this->belongsTo(OrderTransaction::class, 'OrderID', 'OrderID');
    }
}