<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_Student extends Model
{
    protected $table='course_student';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'student_id', 'rate', 'progress' 
    ];
    
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
    
    public function content()
    {
        return $this->belongsTo(Content::class,'progress','id');
    }

}
