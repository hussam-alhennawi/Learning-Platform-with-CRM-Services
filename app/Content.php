<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table='contents';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic_id', 'title', 'description', 'video_file', 'appendix', 'sequence' 
    ];
    
    public function topic()
    {
        return $this->belongsTo(Topic::class,'topic_id','id');
    }

    public function next()
    {
        $course_id = $this->topic->course_id;
        $topics = Topic::where('course_id',$course_id)->get(['id'])->toArray();
        return Content::whereIn('topic_id',$topics)->where('id','>',$this->id)->first();
    }
}
