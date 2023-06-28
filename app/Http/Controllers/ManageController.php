<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Months;
use App\Models\Products;
use App\Models\Publications;
use App\Models\User;

class ManageController extends Controller
{
    public function getMonths(){
        try{
            $response = Months::withCount('publications')->orderBy('id','asc')->get();
            
            if ($response)
                return response()->json(['months' => $response, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function getProducts(){
        try{

            $user = User::find(2);
            $response = $user->products()->with('publications')->get(); // with association of Many to Many
            
            if ($response)
                return response()->json(['products' => $response, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function storePublication(Request $request)
    {   //$userId = Auth::user()->id;

       // dd($userId);
        try {
            $data = $request->all();
            
            foreach ($data as $produto) {
                $publication = new Publications();
                $publication->quantity = $produto['quantity'];
                $publication->month_id = $produto['month_id'];
                $publication->product_id = $produto['product_id'];
                $publication->user_id = 2;  // to current user
                $publication->company_id = $produto['company_id'];
    
                $publication->save();
            }
    
            return response()->json(['message' => 'Actualizacao feita com sucesso!', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao salvar!', 'error' => $e->getMessage(), 'status' => false], 500);
        }
    }
}
