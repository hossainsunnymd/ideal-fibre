<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function profilePage(Request $request){
        $userId=$request->header('id');
        $profile=User::where('id','=',$userId)->first();
        return Inertia::render('Profile/ProfilePage',['profile'=>$profile]);
    }

    public function updateProfile(Request $request){
        $request->validate([
            'name'=>'required',
            'mobile'=>'required',
            'password'=>'required|min:8',
        ]);
        $userId=$request->header('id');
        $profile=User::where('id','=',$userId)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
        ]);
       return redirect()->route('profilePage')->with(['status'=>true,'message'=>'Profile updated successfully']);
    }
}
