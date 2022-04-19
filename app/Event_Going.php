<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_Going extends Model
{
    protected $table='event_going';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'student_id'
    ];
    
    public function event()
    {
        return $this->belongsTo(Event::class,'event_id','id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
}
