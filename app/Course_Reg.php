<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_Reg extends Model
{
    protected $table='course_reg';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'student_id', 'payment_check', 'date', 'status', 'active' 
    ];
    
    public function is_active()
    {
        return $this->active;
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }

}
