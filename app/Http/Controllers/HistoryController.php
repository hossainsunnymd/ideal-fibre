<?php

namespace App\Http\Controllers;

use App\Models\CompleteWorkOrder;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function deliveryHistory(Request $request){
       $list=CompleteWorkOrder::with('invoice.customer','product')->get();
        return Inertia::render('History/DeliveryHistory',['list'=>$list]);
    }

    public function orderHistory(Request $request){
        $invoice=InvoiceProduct::with('invoice.customer','product')->get();
        return Inertia::render('History/OrderHistory',['invoice'=>$invoice]);
    }

    public function orderSavePage(Request $request){
        $id=$request->query('id');
        $order=InvoiceProduct::where('id','=',$id)->first();
        return Inertia::render('History/OrderSavePage',['order'=>$order]);
    }
}
