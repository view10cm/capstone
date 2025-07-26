<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasFactory;

    protected $table = 'menuCategory';
    protected $primaryKey = 'menuCategoryID';

    protected $fillable = [
        'menuCategoryName'
    ];
}