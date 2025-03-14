<?php

namespace App\Http\Controllers;

use App\Models\CompleteWorkOrder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function deliveryHistory(Request $request){
       $list=CompleteWorkOrder::with('invoice.customer','product')->get();
        return Inertia::render('History/DeliveryHistory',['list'=>$list]);
    }
}
