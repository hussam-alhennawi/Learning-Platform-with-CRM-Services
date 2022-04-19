<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table='advertisements';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'image'
    ];

    public function collages()
    {
        return $this->belongsToMany(collage::class, 'advertisement_collage', 'advertisement_id', 'collage_id')->withTimestamps();;
    }

    public function classes()
    {
        return $this->belongsToMany(_Class::class, 'advertisement_class', 'advertisement_id', 'class_id')->withTimestamps();;
    }
}
