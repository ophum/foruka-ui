<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    protected $fillable = [
        'user_id',
        'network_id',
        'name',
        'cpu',
        'memory',
    ];

    public function network() {
        return $this->belongsTo('App\Network');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
