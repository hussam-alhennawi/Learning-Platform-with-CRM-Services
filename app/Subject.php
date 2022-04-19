<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table='subjects';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar', 'name_en', 'collage_id'
    ];

    public function collage()
    {
        return $this->belongsTo(Collage::class, 'collage_id', 'id');
    }

    public function classes()
    {
        return $this->hasMany(_Class::class, 'subject_id');
    }
    
    public function classesByYear($year)
    {
        return _Class::where('subject_id',$this->id)->where('study_year',$year)->first();
    }
}
