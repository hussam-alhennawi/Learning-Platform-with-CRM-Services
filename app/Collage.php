<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collage extends Model
{
    protected $table='collages';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar', 'name_en', 'description', 'image'
    ];
    
    public function Students()
    {
        return $this->hasMany(Student_Collage::class,'collage_id','id');
    }
    
    public function Lecturers()
    {
        return $this->hasMany(Collage_Lecturer::class,'collage_id','id');
    }
    
    public function Subjects()
    {
        return $this->hasMany(Subject::class,'collage_id','id');
    }
}
