<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    protected $table='lecture_check_in';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_class_id', 'lecture_id'
    ];

    public function student_class()
    {
        return $this->belongsTo(Student_Class::class,'student_class_id','id');
    }
}
