<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

use Image;
use Auth;
use Hash;

class ProfileController extends MainController
{
        
    public function profile()
    {
        $user = Auth::user();
        if($user)
        {
            return view('FrontEnd.Private.account',compact(['user']));
        }
        return redirect()->route('/');
    }

    public function profilePage()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            $page = (string)view('FrontEnd.Private.tabs.profile',compact(['user']));
            return response()->json([
                'success'=>true,
                'data'=> $page
                ]);
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validate($request,[
            'first_name' => [ 
                Rule::requiredIf(function () use ($request) {
                    return !$request->first_name;
                })
                , 'string', 'max:255'],
            'last_name' => [ 
                Rule::requiredIf(function () use ($request) {
                    return !$request->last_name;
                })
                , 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'old_password' => ['nullable', 'string', 'min:8'],
            'new_password' => [ 
                Rule::requiredIf(function () use ($request) {
                    return $request->old_password;
                })
                ,'nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        $message = '';
        $edited = false;
        if($request->first_name && $request->first_name != $user->first_name)
        {
            $user->first_name = $request->first_name;
            $edited = true;
        }

        if($request->middle_name && $request->middle_name != $user->middle_name)
        {
            $user->middle_name = $request->middle_name;
            $edited = true;
        }

        if($request->last_name && $request->last_name != $user->last_name)
        {
            $user->last_name = $request->last_name;
            $edited = true;
        }

        if($request->address && $request->address != $user->address)
        {
            $user->address = $request->address;
            $edited = true;
        }

        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $image_path=public_path('photos/profiles/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image_path);
                    $user->image=$fileName;
                    $edited = true;
                }
            }       
        }

        if($edited)
        {
            $user->save();
            $message .= ' Your Information Update Successfully';
        }

        if($request->old_password)
        {
            $email=Auth::user()->email;
            $check_password=User::where(['email'=>$email])->first();
            if(Hash::check($request->old_password,$check_password->password))
            {
                $password=bcrypt($request->new_password);
                User::where('email',$email)->update(['password'=>$password]);
                $message .= ' Password Update Successfully';
            }
            else
            {
                $message .= ' InCorrect Current Password';
            }
        }
        return redirect()->back()->with('message',$message);
    }
}
