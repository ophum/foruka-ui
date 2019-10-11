<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetworkConfigure extends Model
{
    protected $fillable = [
        'network_id',
        'container_id',
        'endpoint_port',
        'dport',
    ];

    public function network() {
        return $this->belongsTo('App\Network');
    }

    public function container() {
        return $this->belongsTo('App\Container');
    }
}
