<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public $table = 'albums';

    public function photos2()
    {
        return $this->hasMany('App\Photo');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo')
        -> where('primario',0);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
