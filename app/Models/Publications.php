<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publications extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity', 'month_id', 'product_id', 'company_id', 'user_id', 'year_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_publications');
    }
}
