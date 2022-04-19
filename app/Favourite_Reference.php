<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite_Reference extends Model
{
    protected $table='favourite_reference_student';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'reference_id' 
    ];
    
    public function reference()
    {
        return $this->belongsTo(Reference::class,'reference_id','id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }

}
