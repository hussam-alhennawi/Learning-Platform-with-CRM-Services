<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_Class extends Model
{
    protected $table='student_class';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id', 'student_id', 'mark' 
    ];
    
    public function class()
    {
        return $this->belongsTo(_Class::class,'class_id','id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
}
