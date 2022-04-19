<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\MainController;
use App\User;
use App\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;

class RegisterController extends MainController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $request = request();
        $gender = ['male', 'female'];
        $request['fullPhoneNumber'] = '+'.$data['countryCode'].$data['phone'];
        
        $this->validate($request,[
            'identity_check' => ['required'],
            'identity_check.*' => ['required','mimes:pdf'],
        ]);
        return Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'DOB' => ['required', 'date'],
            'scientific_degree' => ['required', 'string'],
            'countryCode' => ['required'],
            'phone' => ['required', 'min:4', 'max:12'],
            'fullPhoneNumber' => ['required',function($attribute, $value, $fail){
                $number = PhoneNumber::parse($value);
                if(!$number->isValidNumber())
                    $fail($attribute.' is invalid');
            }],
            'gender' => ['required','in_array:gender'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $request = request();

        $file_name = str_replace(' ','-',$data['first_name']).time();
        if($request->file('identity_check')){
            $file = $request->file('identity_check');
            if($file->isValid())
            {
                $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
            }
        }
        $data['identity_check'] = $file_name.'.pdf';
        
        $role = Role::firstOrNew(['name' => 'External_student']);
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_name' => $data['middle_name'],
            'DOB' => $data['DOB'],
            'scientific_degree' => $data['scientific_degree'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'username' => $data['username'],
            'identity_check' => $data['identity_check'],
            'active' => 0,
            'password' => Hash::make($data['password']),
        ])->attachRole($role);
        
        /* Waiting For upload project on hosting */
        // $user->sendEmailVerificationNotification();

        return $user;
    }
}
