<?php

namespace App\Http\Controllers;

use App\Models\CompleteWorkOrder;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function deliveryHistory(Request $request){
       $list=CompleteWorkOrder::with('invoiceProduct.invoice.customer','product')->get();
        return Inertia::render('History/DeliveryHistory',['list'=>$list]);
    }

    public function orderHistory(Request $request){
        $invoice=InvoiceProduct::with('invoice.customer','product')->get();
        return Inertia::render('History/OrderHistory',['invoice'=>$invoice]);
    }

    public function orderSavePage(Request $request){
        $id=$request->query('id');
        $order=CompleteWorkOrder::where('id','=',$id)->first();
        return Inertia::render('History/OrderSavePage',['order'=>$order]);
    }

    public function updateWorkOrder(Request $request){
        DB::beginTransaction();
        try{
            $invoiceProductId=CompleteWorkOrder::where('id','=',$request->input(key: 'id'))->first()->invoice_product_id;
            $deliveredWorkOrder=$request->input('delivered_work_order');
            $pendingWorkOrder=$request->input('pending_work_order');
            CompleteWorkOrder::where('id','=',$request->input(key: 'id'))->update([
                'delivered_work_order'=>$deliveredWorkOrder,
                'pending_work_order'=>$pendingWorkOrder
            ]);

            InvoiceProduct::where('id','=',$invoiceProductId)->update([
                'complete_work_order'=>$deliveredWorkOrder,
                'incomplete_work_order'=>$pendingWorkOrder
            ]);
            DB::commit();
            return redirect()->back()->with(['status'=>true,'message'=>'Work order updated successfully']);
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with(['status'=>false,'message'=>'Something went wrong']);
        }

    }
}
