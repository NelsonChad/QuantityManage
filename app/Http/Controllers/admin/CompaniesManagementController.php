<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\User;
use App\Models\Publications_year;
use App\Models\Months;


class CompaniesManagementController extends Controller
{
    public function index() {
        $years = Publications_year::orderBy('year','desc')->get();
        $users = User::get();
        return view('admin.manage-companies', compact('years', 'users'));
    }

    public function show($id){
        $company =  User::find($id);
        $products = Products::get();
        $productsAss = $company->products;
        $months = Months::orderBy('id','asc')->get();

        $publications = $company->products()->with(['publications' => function ($query) use ($id) {
            $query->where('user_id', $id);
        }])->get(); // with association of Many to Many

        return view('admin.companies.companies', compact('company','products','productsAss','publications','months'));
    }

    public function removeAttach($userID, $prodID) 
    {
        try{
            $user = User::find($userID);
            $user->products()->detach($prodID);

            return redirect()->back()->with('success', "sucesso")->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e)
                ->withInput();
        }    
    }

    public function getProducts($id){
        try{
            //$parameter = $id;
            $user = User::find($id);
            $response = $user->products()->with(['publications' => function ($query) use ($id) {
                $query->where('user_id', $id);
            }])->get(); // with association of Many to Many
            
            if ($response)
                return response()->json(['products' => $response, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function store($userID ,Request $request) 
    {
        try{
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
}
