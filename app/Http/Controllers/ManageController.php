<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Months;
use App\Models\Products;
use App\Models\Publications;
use App\Models\User;
use App\Models\Publications_year;

class ManageController extends Controller
{
    public $user_id = 1;
    public function getMonths($id, $year){
        try{
            $response = Months::withCount(['publications' => function ($query) use ($id, $year) {
                $query->where('user_id', $id)
                      ->where('year_id', $year);
            }])->orderBy('id','asc')->get();
            
            if ($response)
                return response()->json(['months' => $response, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function getYears(){
        try{
            $response = Publications_year::orderBy('year','desc')->get();
            
            if ($response)
                return response()->json(['years' => $response, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }
    
    public function getAllMonths() {
        try{
            $response = Months::orderBy('id','asc')->get();

            if ($response)
                return response()->json(['months' => $response, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function getProducts($id, $year){
        try{
            //$parameter = $id;
            $user = User::find($id);
            $response = $user->products()->with(['publications' => function ($query) use ($id, $year) {
                $query->where('user_id', $id)
                      ->where('year_id', $year);
            }])->get(); // with association of Many to Many
            
            if ($response)
                return response()->json(['products' => $response, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function getUserData()
    {
        $userId = Auth::id();
        // Fetch other user data as needed

        return response()->json([
            'user_id' => $userId,
            // Include other user data in the response
        ]);
    }

    public function storePublication(Request $request, $id)
    {   //$userId = Auth::user()->id;
        $userId = $id;
        //dd($userId);
        try {
            $data = $request->all();
            
            foreach ($data as $produto) {
                $publication = new Publications();
                $publication->quantity = $produto['quantity'];
                $publication->month_id = $produto['month_id'];
                $publication->product_id = $produto['product_id'];
                $publication->user_id = $userId; // to current user
                $publication->company_id = $produto['company_id'];
                $publication->year_id = $produto['year_id'];
    
                $publication->save();
                $pubID = $publication['id'];
            }
    
            return response()->json(['message' => 'Actualizacao feita com sucesso!', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao salvar!', 'error' => $e->getMessage(), 'status' => false], 500);
        }
    }
}
