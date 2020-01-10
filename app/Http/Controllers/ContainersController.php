<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Network;
use App\Container;
use App\PostJson;
use App\NetworkConfigure;

class ContainersController extends Controller
{

    public function show(Request $request) {
        $cid = $request->id;
        $container = Container::find($cid);
        if($container === null) {
            return redirect('/home');
        }
        $proxy = $container->network_configures;
        $pj = new PostJson();
        $status = $pj->get('http://localhost:8080/containers/state/'.$container->name);
        //$external_ip = $pj->get('http://localhost:8080/networks/external-ip');
        $router_status = $pj->get('http://localhost:8080/containers/state/'.$container->network->name.'-router');
        $external_ip = $router_status['network']['eth0']['addresses'][0]['address'];
        return view('containers.show', compact('container', 'status', 'proxy', 'external_ip'));
    }

    public function start(Request $request) {
        $cid = $request->id;
        $container = Container::find($cid);
        if($container === null) {
            return redirect('/home');
        }

        $pj = new PostJson();
        $pj->post('http://localhost:8080/containers/start', ['name' => $container->name]);

        $ipv4 = explode('/', $container->ipv4_address);
        $pj->post('http://localhost:8080/containers/set/ip', [
            'name' => $container->name,
            'ipv4' => [
                'address'=> $ipv4[0],
                'prefix' => $ipv4[1],
            ],
            'device' => 'eth0'
            ]);
        $pj->post('http://localhost:8080/containers/config/default_gateway', [
            'name' => $container->name,
            'gateway' => $container->network->default_gateway,
        ]);

        $user = $request->user();
        if($user->ssh_authorized_key !== "" && $user->ssh_authorized_key !== null) {
            $pj->post('http://localhost:8080/containers/config/ssh_authorized_key', [
                'name' => $container->name,
                'ssh_authorized_key' => $user->ssh_authorized_key,
            ]);
        }
        
        return redirect('/containers/show/'.$container->id);
    }

    public function stop(Request $request) {
        $cid = $request->id;
        $container = Container::find($cid);
        if($container === null) {
            return redirect('/home');
        }

        $pj = new PostJson();
        $pj->post('http://localhost:8080/containers/stop', ['name' => $container->name ]);
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
        $ipv4_address = $request->ipv4_address;

        $network = Network::find($network_id);
        $pj = new PostJson();
        $body = [
            'name' => $name,
            'alias' => 'container',
            'limits' => [
                'cpu' => $cpu,
                'memory' => $memory,
            ],
            'ifaces' => [
                'eth0' => $network->name,
            ],
        ];

        $res = $pj->post("http://localhost:8080/containers/create", $body);
        if($res == "") {
            return;
        }
        $data = [
            'user_id' => $user->id,
            'network_id' => $network_id,
            'name' => $name,
            'cpu' => $cpu,
            'memory' => $memory, 
            'ipv4_address' => $ipv4_address,
        ];

        $container = new Container();
        $container->fill($data)->save();

        $network = $container->network;
        $endpoint_port = 0;

        do {
            $endpoint_port = strval(rand(1234, 65530));
            $f = $res = NetworkConfigure::where('endpoint_port', $endpoint_port)->exists();
        }while($f);
        
        $pj = new PostJson();
        $router_name = str_replace('_', '-', $network->name).'-router';
        $ipv4 = explode('/', $container->ipv4_address)[0];
        $pj->post("http://localhost:8080/networks/config/proxy", [
            'router_name' => $router_name,
            'endpoint_port' => $endpoint_port,
            'destination_address' => $ipv4,
            'destination_port' => '22',
        ]);

        $nc = new NetworkConfigure();
        $nc->network_id = $network->id;
        $nc->container_id = $container->id;
        $nc->endpoint_port = $endpoint_port;
        $nc->dport = 22;
        $nc->save();


        return redirect('/home');
    }

    public function storeProxy(Request $request) {
        $cid = $request->id;
        $container = Container::find($cid);
        $network = $container->network;
        $endpoint_port = 0;

        do {
            $endpoint_port = strval(rand(1234, 65530));
            $f = $res = NetworkConfigure::where('endpoint_port', $endpoint_port)->exists();
        }while($f);
        
        $dport = $request->dport;

        $pj = new PostJson();
        $router_name = str_replace('_', '-', $network->name).'-router';
        $ipv4 = explode('/', $container->ipv4_address)[0];
        $pj->post("http://localhost:8080/networks/config/proxy", [
            'router_name' => $router_name,
            'endpoint_port' => $endpoint_port,
            'destination_address' => $ipv4,
            'destination_port' => $dport,
        ]);

        $nc = new NetworkConfigure();
        $nc->network_id = $network->id;
        $nc->container_id = $container->id;
        $nc->endpoint_port = $endpoint_port;
        $nc->dport = $dport;
        $nc->save();

        return redirect('/containers/show/'.$cid);
    }

    public function console(Request $request) {
        $cid = $request->id;
        $container = $request->user()->containers->find($cid);
        if($container === null) {
            return redirect('/home');
        }

        return view('containers.console', compact('container'));
    }
}
