<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function products()
    {
        return $this->belongsToMany(Products::class);
    }

    public function totalPublications()
    {
        return $this->hasMany('App\Models\Publications', 'user_id')
        ->selectRaw('user_id, SUM(quantity) as total_quantity')
        ->groupBy('user_id');
    }

    /*public function publications()
    {
        return $this->belongsToMany(Publications::class, 'user_publications');
    }*/

    public function publications()
    {
        return $this->hasMany('App\Models\Publications', 'product_id')
        ->selectRaw('product_id, quantity, month_id, status')
        ->orderBy('publications.month_id','asc')
        ->groupBy('product_id', 'quantity', 'month_id', 'status');
    }
}
