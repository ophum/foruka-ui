@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <tr><td colspan=2>
                            <form action="/containers/start" method="POST">
                            {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $container->id }}">
                                <input class="btn btn-success" type="submit" value="Start">
                            </form>
                            <form action="/containers/stop" method="POST">
                            {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $container->id }}">
                                <input class="btn btn-danger" type="submit" value="Stop">
                            </form>
                            </td>
                        </tr>
                        <tr><td>Name</td><td>{{ $container->name }}</td></tr>
                        <tr><td>Status</td><td>{{ $status['status'] }}</td></tr>
                        <tr><td>cpus</td><td>{{ $container->cpu }}</td></tr>
                        <tr><td>memory</td><td>{{ $container->memory }}</td></tr>
                        <tr><td>Ipv4 Address</td><td>{{ $container->ipv4_address }}</td></tr>
                        <tr><td>network</td><td>{{ $container->network->name }}</td></tr>
                        <tr><td>ipv4 cidr</td><td>{{ $container->network->ipv4_cidr }}</td></tr>
                        <tr><td>default gateway</td><td>{{ $container->network->default_gateway }}</td></tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Proxy</div>
                <div class="card-body">
                    <form action="/containers/store.proxy" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$container->id}}">
                        <div class="form-group">
                            <label>ポート</label>
                            <input class="form-control" type="number" name="dport">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" value="追加">
                        </div>
                    </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>EndPoint</td>
                                <td>Destination</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proxy as $p)
                                <tr>
                                    <td>{{ $external_ip.":".$p->endpoint_port }}</td>
                                    <td>{{ $container->ipv4_address . ":". $p->dport }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
