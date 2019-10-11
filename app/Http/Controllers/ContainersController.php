<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Network;
use App\Container;
use App\PostJson;

class ContainersController extends Controller
{

    public function show(Request $request) {
        $cid = $request->id;
        $container = Container::find($cid);
        if($container === null) {
            return redirect('/home');
        }

        $pj = new PostJson();
        $status = $pj->get('http://localhost:8080/containers/state/'.$container->name);
        return view('containers.show', compact('container', 'status'));
    }

    public function start(Request $request) {
        $cid = $request->id;
        $container = Container::find($cid);
        if($container === null) {
            return redirect('/home');
        }

        $pj = new PostJson();
        $pj->post('http://localhost:8080/containers/start', ['name' => $container->name]);
        return redirect('/containers/show/'.$container->id);
    }

    public function create(Request $request) {
        $networks = $request->user()->networks;
        return view('containers.create', compact('networks'));
    }

    public function store(Request $request) {
        $user = $request->user();
        $name = $request->name;
        $cpu = $request->cpu;
        $memory = $request->memory;
        $network_id = $request->network_id;

        $network = Network::find($network_id);
        $pj = new PostJson();
        $body = [
            'name' => $name,
            'alias' => 'router',
            'limits' => [
                'cpu' => $cpu,
                'memory' => $memory,
            ],
            'devices' => [
                'eth0' => $network->name,
            ],
        ];

        $res = $pj->post("http://localhost:8080/containers/create", $body);
        if($res != "") {
            $data = [
                'user_id' => $user->id,
                'network_id' => $network_id,
                'name' => $name,
                'cpu' => $cpu,
                'memory' => $memory, 
            ];

            $container = new Container();
            $container->fill($data)->save();
        }

        return redirect('/home');
    }
}
