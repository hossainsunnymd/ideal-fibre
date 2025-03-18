<?php

namespace App\Http\Controllers;

use App\Models\CompleteWorkOrder;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ModeratorController extends Controller
{
    public function moderatorDashboard(){

        $invoice=InvoiceProduct::where('incomplete_work_order','>',0)->with('invoice','invoice.customer','product')->get();

        return Inertia::render('Dashboard/ModaratorDashboard',['invoice'=>$invoice]);
    }

    public function deliviredWorkOrder(Request $request){

        DB::beginTransaction();
        try{
            $id=$request->query('id');
            $currentCompleteWorkOrder=InvoiceProduct::where('id','=',$id)->first()->complete_work_order;
            $currentInCompleteWorkOrder=InvoiceProduct::where('id','=',$id)->first()->incomplete_work_order;
            InvoiceProduct::where('id','=',$id)->update([
                'complete_work_order'=>$request->query('orderQty')+$currentCompleteWorkOrder,
                'incomplete_work_order'=>$currentInCompleteWorkOrder-$request->query('orderQty'),
            ]);

            CompleteWorkOrder::create([
                'delivered_work_order'=>$request->query('orderQty'),
                'pending_work_order'=>InvoiceProduct::where('id','=',$id)->first()->incomplete_work_order,
                'work_order'=>InvoiceProduct::where('id','=',$id)->first()->qty,
                'delivered_by'=>$request->query('delivered_by'),
                'invoice_product_id'=>$id,
                'product_id'=>InvoiceProduct::where('id','=',$id)->first()->product_id
            ]);
            DB::commit();
            return redirect()->back()->with(['status'=>true,'message'=>'Work order updated successfully']);
        }catch(Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
