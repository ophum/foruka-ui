@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <tr><td colspan=2>
                            
                        </tr>
                        <tr><td>Name</td><td>{{ $network->name }}</td></tr>
                        <tr><td>ipv4 cidr</td><td>{{ $network->ipv4_cidr}}</td></tr>
                        <tr><td>default gateway</td><td>{{ $network->default_gateway }}</td></tr>
                        <tr><td>router status</td><td><span class="badge @if($router_state['status'] === 'Running') badge-success @else badge-secondary @endif ">{{ $router_state['status'] }}</span></td></tr>
                      
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
