<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table='complaints';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'complaint_text' 
    ];
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
}
