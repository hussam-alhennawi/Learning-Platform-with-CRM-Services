<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite_Lecture extends Model
{
    protected $table='favourite_lecture_student';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'lecture_id' 
    ];
    
    public function lecture()
    {
        return $this->belongsTo(Lecture::class,'lecture_id','id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }

}
