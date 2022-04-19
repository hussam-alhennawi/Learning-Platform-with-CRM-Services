<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table='courses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'category_id', 'level', 'lecturer_id', 'skills', 'duration', 'cost', 'rate', 'image' 
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    
    public function lecturer()
    {
        return $this->belongsTo(User::class,'lecturer_id','id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'course_id', 'id');
    }

    public function RegisteredStudents()
    {
        return $this->hasMany(Course_Reg::class, 'course_id', 'id');
    }

    public function AcceptedStudents()
    {
        return $this->hasMany(Course_Student::class, 'course_id', 'id');
    }
}
