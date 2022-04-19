<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Lib_project extends Model
{
    protected $table='lib_projects';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_ar', 'title_en', 'subject_id', 'pdf_file', 'study_year'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'lib_project_student', 'lib_project_id', 'student_id')->withTimestamps();
    }

    public function supervisors()
    {
        return $this->belongsToMany(User::class, 'lib_project_supervisor', 'lib_project_id', 'lecturer_id')->withTimestamps();
    }
}
