<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Network;
use App\PostJson;

class NetworksController extends Controller
{
    
    public function create() {
        return view('networks.create');
    }

    public function store(Request $request) {
        $user = $request->user();
        $name = $request->name;
        $ipv4_cidr = $request->ipv4_cidr;
        $default_gateway = $request->default_gateway;
   
        $pj = new PostJson();
        $body = [
            'name' => $name,
            'config' => [
                'ipv4.address' => 'none',
                'ipv6.address' => 'none',
            ],
        ];
        
        $res = $pj->post('http://localhost:8080/networks/create', $body);
        if($res === "success") {

            $data = [
                'user_id' => $user->id,
                'name' => $name,
                'ipv4_cidr' => $ipv4_cidr,
                'default_gateway' => $default_gateway,
            ];
            $network = new Network();

            $network->fill($data)->save();
        }
        return redirect('/home');
    }
}
