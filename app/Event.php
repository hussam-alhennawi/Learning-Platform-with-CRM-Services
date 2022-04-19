<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table='events';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'started_at', 'ended_at', 'location', 'description', 'image'
    ];
    
    public function GoingStudents()
    {
        return $this->hasMany(Event_Going::class,'event_id','id');
    }
}
