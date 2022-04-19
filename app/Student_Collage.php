<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student_Collage extends Model
{
    protected $table='student_collage';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'collage_id', 'student_id', 'date_of_registration' 
    ];
    
    public function collage()
    {
        return $this->belongsTo(Collage::class,'collage_id','id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
}
