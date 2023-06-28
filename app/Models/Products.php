<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public function publications()
    {
        return $this->hasMany('App\Models\Publications', 'product_id')
        ->where('user_id',2) // to current user
        ->selectRaw('product_id, quantity, month_id, status')
        ->orderBy('publications.month_id','asc')
        ->groupBy('product_id', 'quantity', 'month_id', 'status');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
