<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Months;
use App\Models\Products;
use App\Models\Publications;
use App\Models\User;

class ReportsController extends Controller
{
    public function getUsersOfProducts(){
        try{
            $publications = Products::with('users')->get();
            
            if ($publications)
                return response()->json(['publications' => $publications, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function getTotalProducPerMonth($product, $year){
        
        try{
            $totalPerMoth = [];
            $months = Months::orderBy('id','asc')->get();
            foreach ($months as $moth) {
                $total = Publications::where("product_id", $product)
                ->where("product_id", $product)
                ->where("month_id", $moth->id)
                ->where("year_id", $year)
                ->sum('quantity');

                array_push($totalPerMoth, $total);  
            }

            
            if ($totalPerMoth)
                return response()->json(['total_moths' => $totalPerMoth], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }

    public function getPublications($user_id, $product_id, $year_id) {
        try{
            $publicationsProduct = Publications::
            where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->where('year_id', $year_id)
            ->get();
            
            if ($publicationsProduct)
                return response()->json(['publicationsProduct' => $publicationsProduct, 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha no sistema ao carrengar!','error' => $e->getMessage(), 'status' => false], 500);
        }
    }
}
