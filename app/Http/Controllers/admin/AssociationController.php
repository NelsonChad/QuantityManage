<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\User;
use Auth;

class AssociationController extends Controller
{
    public function index() {

        $products = Products::get();

        // get the products assiciated to the user [many to many]
        $userID = Auth::user()->id;
        $user = User::find($userID);
        $productsAss = $user->products;

        return view('admin.associate', compact('products','productsAss'));
    }

    private function getUsersOfProducts(){
        // Obtém todos os usuários associados a uma função
        $prod = Products::find(1);
        $users = $prod->users;
    }

    public function store(Request $request) 
    {
        try{
            // Associate product to user [Many to Many]
            $userID = Auth::user()->id;
            $prodID = $request->product;

            $user = User::find($userID);
            $prod = Products::find($prodID);

            $user->products()->attach($prod->id);

            return redirect()->back()->with('success', "sucesso")->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e)
                ->withInput();
        }    
    }

    public function getPrograms(){

    }
}
