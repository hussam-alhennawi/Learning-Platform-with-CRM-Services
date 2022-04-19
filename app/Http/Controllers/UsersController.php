<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use foo\bar;
use Illuminate\Http\Request;
use Image;
use Hash;
use Illuminate\Database\Eloquent\Builder;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;

class UsersController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='users';
        $users=User::paginate(10);
        return view('backEnd.users.index',compact('menu_active','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='users';
        $roles = Role::all();
        return view('backEnd.users.create',compact('menu_active','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkUserName(Request $request){
        $data=$request->all();
        $username=$data['username'];
        $ch_user_name_atDB=User::select('username')->where('username',$username)->first();
        if($username==$ch_user_name_atDB['username']){
            echo "true"; die();
        }else {
            echo "false"; die();
        }
    }
    public function checkEmail(Request $request){
        $data=$request->all();
        $email=$data['email'];
        $ch_email_atDB=User::select('email')->where('email',$email)->first();
        if($email==$ch_email_atDB['email']){
            echo "true"; die();
        }else {
            echo "false"; die();
        }
    }
    /*public function checkPhone(Request $request){
        $data=$request->all();
        $phone=$data['phone'];
        $number=PhoneNumber::parse($phone);
        if($number->isValidNumber()){
            echo "true"; die();
        }else {
            echo "false"; die();
        }
    }*/
    
    public function store(Request $request)
    {
        $gender = ['male', 'female'];
        $request['full phone number'] = '+'.$request['countryCode'].$request['phone'];
        $this->validate($request,[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'DOB' => ['required', 'date'],
            'countryCode' => ['required'],
            'phone' => ['required', 'min:4', 'max:12'],
            'full phone number' => ['required',function($attribute, $value, $fail){
                $number = PhoneNumber::parse($value);
                if(!$number->isValidNumber())
                    $fail($attribute.' is invalid');
            }],
            'gender' => ['required','in_array:gender'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $data=$request->all();
        $data['phone'] = $data['full phone number'];
            
        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $large_image_path=public_path('photos/profiles/').$fileName;
                    //Resize Image
                    Image::make($file)->save($large_image_path);
                    $data['image']=$fileName;
                }
            }       
        }
        
        if(!$request->active)
            $data['active'] = 0;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);        
        if($request->roles)
            $user->syncRoles($request->roles);
        else
            $user->syncRoles([]);
        return redirect()->route('users.index')->with('message','Added Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu_active='users';
        $users[]=User::findOrFail($id);
        return view('backEnd.users.index',compact('menu_active','users'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $menu_active=0;
        $Roles=Role::all();
        $Permissions=Permission::all();
        $user=User::findOrFail($id);
        $user->Permissions = $user->permissions()->get();
        $user->Roles = $user->roles()->get();
        return view('backEnd.users.edit',compact('Roles','menu_active','Permissions','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        if($request->roles)
            $user->syncRoles($request->roles);
        else
            $user->syncRoles([]);

        if($request->permissions)
            $user->syncPermissions($request->permissions);
        else
            $user->syncPermissions([]);
        return redirect()->route('users.index')->with('message','Updated Success!');
    }

    public function UsersType($id)
    {
        $menu_active='users';
        $role=Role::findOrFail($id);
        $users = User::whereRoleIs($role->name)->get();
        return view('backEnd.users.index',compact('menu_active','users','role'));
    }

    public function ActivateUser($id)
    {
        $user=User::findOrFail($id);
        $user->active = 1;
        $user->save();
        return redirect()->back()->with('message',$user->first_name.' Activated Success!');
    }

    public function DeactivateUser($id)
    {
        $user=User::findOrFail($id);
        $user->active = 0;
        $user->save();
        return redirect()->back()->with('message',$user->first_name.' Deactivated Success!');
    }

    public function BlockUser($id)
    {
        $user=User::findOrFail($id);
        $user->blocked = 1;
        $user->save();
        return redirect()->back()->with('message',$user->first_name.' Blocked Success!');
    }

    public function unblockUser($id)
    {
        $user=User::findOrFail($id);
        $user->blocked = 0;
        $user->save();
        return redirect()->back()->with('message',$user->first_name.' Unblocked Success!');
    }
    
}
