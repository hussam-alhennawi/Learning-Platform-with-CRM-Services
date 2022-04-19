<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _Class extends Model
{
    protected $table='classes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lecturer_id', 'subject_id', 'study_year', 'semester_number', 'type'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id', 'id');
    }

    public function StudentsRegistredAtClass()
    {
        return $this->hasMany(Student_Class::class,'class_id','id');
    }

    public function Lectures()
    {
        return $this->hasMany(Lecture::class,'class_id','id');
    }
    
}
