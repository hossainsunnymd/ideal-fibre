<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{

    public function customerPage(Request $request){

        $customers = Customer::all();
        return Inertia::render('Customer/CustomerPage',['customers' => $customers]);
    }

    public function customerSavePage(Request $request){
        $id=$request->query('id');
        $customer=Customer::where('id','=',$id)->first();
        return Inertia::render('Customer/CustomerSavePage',['customer'=>$customer]);
    }
    public function createCustomer(Request $request)
    {
        try {
            $request->validate([
                'name' => 'string|required',
                'address' => 'string|required',
                'mobile' => 'string|required',
            ]);
            $name = $request->input('name');
            $address = $request->input('address');
            $mobile = $request->input('mobile');

            Customer::create(['name' => $name, 'address' => $address, 'mobile' => $mobile]);
            return redirect()->route('customerSavePage')->with(['status' => true, 'message' => 'Customer created successfully']);
        } catch (Exception $e) {
            return redirect()->route('customerSavePage')->with(['status' => false, 'message' => 'Customer creation failed']);
        }
    }


    public function updateCustomer(Request $request){
        $request->validate([
            'name' => 'string|required',
            'address' => 'string|required',
            'mobile' => 'string|required',
        ]);
        try{
            $customerId=$request->input('id');
            Customer::where('id', '=', $customerId)->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'mobile' => $request->input('mobile'),
            ]);

            return redirect()->route('customerSavePage')->with(['status'=>true,'message'=>'Customer updated successfully']);
        }catch(Exception $e){
            return redirect()->route('customerSavePage')->with(['status'=>false,'message'=>'Customer updated fail']);

        }
    }

    public function deleteCustomer(Request $request){
        try{
            $customerId=$request->query('id');
            Customer::where('id', '=', $customerId)->delete();
            return redirect()->route('customerPage')->with(['status' => true, 'message' => 'Customer deleted successfully']);
        }catch(Exception $e){
            return redirect()->route('customerPage')->with(['status' => false, 'message' => 'Customer deletion failed']);
        }

    }

}
