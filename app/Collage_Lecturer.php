<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collage_Lecturer extends Model
{
    protected $table='collage_lecturer';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'collage_id', 'lecturer_id', 'date_of_registration' 
    ];
    
    public function collage()
    {
        return $this->belongsTo(Collage::class,'collage_id','id');
    }
    
    public function lecturer()
    {
        return $this->belongsTo(User::class,'lecturer_id','id');
    }
}
