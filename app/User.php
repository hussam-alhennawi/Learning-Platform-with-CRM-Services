<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Laratrust\Traits\LaratrustUserTrait;

class User extends Model implements
AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract
{
use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use LaratrustUserTrait; // add this trait to your user model
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'DOB', 'scientific_degree', 'phone', 
        'email', 'password', 'address', 'gender', 'username', 'identity_check', 'active', 'blocked', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function full_name()
    {
        return $this->first_name.' '.$this->middle_name.' '.$this->last_name;
    }

    public function is_active()
    {
        return $this->active;
    }

    public function is_blocked()
    {
        return $this->blocked;
    }
    
    // For Students
    public function StudentRegistredAtCollage()
    {
        return $this->hasOne(Student_Collage::class,'student_id','id');
    }
    
    // For Students
    public function FavouriteLectures()
    {
        return $this->hasMany(Favourite_Lecture::class,'student_id','id');
    }
    
    // For Students
    public function FavouriteLibProjects()
    {
        return $this->hasMany(Favourite_LibProject::class,'student_id','id');
    }
    
    // For Students
    public function FavouriteReferences()
    {
        return $this->hasMany(Favourite_Reference::class,'student_id','id');
    }
    
    // For Students
    public function Classes()
    {
        return $this->hasMany(Student_Class::class,'student_id','id');
    }
    
    // For Students
    public function Events()
    {
        return $this->hasMany(Event_Going::class,'student_id','id');
    }
    
    // For Lecturers
    public function LecturerRegistredAtCollage()
    {
        return $this->hasMany(Collage_Lecturer::class,'lecturer_id','id');
    }

    // For Lecturers
    public function courses()
    {
        return $this->hasMany(Course::class, 'lecturer_id', 'id');
    }

    // For Lecturers
    public function LecturerClasses()
    {
        return $this->hasMany(_Class::class, 'lecturer_id', 'id');
    }
}
