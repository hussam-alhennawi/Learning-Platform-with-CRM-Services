<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table='lectures';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id', 'title', 'date', 'pdf_file', 'qr_code'
    ];
    
    public function _class()
    {
        return $this->belongsTo(_Class::class, 'class_id', 'id');
    }

    public function checksIn()
    {
        return $this->hasMany(CheckIn::class);
    }
}
