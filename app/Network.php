<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'ipv4_cidr',
        'default_gateway',
    ];

    public function containers() {
        return $this->hasMany('App\Container');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
