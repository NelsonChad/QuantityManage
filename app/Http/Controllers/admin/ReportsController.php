<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Months;
use App\Models\Products;
use App\Models\Publications;
use App\Models\User;

class ReportsController extends Controller
{
    public function getUsersOfProducts(){
        // Obtém todos os usuários associados a uma função
        $productsCompanies = Products::with('users.publications')->get();
        //$productsCompanies = Products::with('users')->get();
        
        return view('general-products', compact('productsCompanies'));
    }
}
