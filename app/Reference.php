<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $table='references';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'author', 'publisher', 'publish_year', 'category', 'description', 'pdf_file'
    ];

    public function FavouriteLists()
    {
        return $this->hasMany(Favourite_Reference::class,'reference_id','id');
    }
}
