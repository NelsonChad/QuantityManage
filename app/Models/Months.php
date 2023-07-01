<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Months extends Model
{
    use HasFactory;
    public function publications()
    {
        return $this->hasMany('App\Models\Publications', 'month_id')
        ->where('user_id',1) // to current user
        ->selectRaw('month_id, quantity, month_id, status')
        ->groupBy('month_id', 'quantity', 'status');
    }
}
