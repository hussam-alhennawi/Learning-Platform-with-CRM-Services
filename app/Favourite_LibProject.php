<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite_LibProject extends Model
{
    protected $table='favourite_lib_project_student';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'lib_project_id' 
    ];
    
    public function lib_project()
    {
        return $this->belongsTo(Lib_project::class,'lib_project_id','id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }

}
