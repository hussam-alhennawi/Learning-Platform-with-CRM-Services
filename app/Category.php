<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $table='categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'name', 'image'
    ];

    public function parentCategory()
    {
        return $this->belongsTo(Category::class,'parent_id','id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class,'category_id','id');
    }
    
    public function CourseWithStudents()
    {
        return Course::where('category_id',$this->id)->
            where(function(Builder $query){
                $query->whereHas('AcceptedStudents')->
                orWhereHas('RegisteredStudents');
        })->get();
    }
}
