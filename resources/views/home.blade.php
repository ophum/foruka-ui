@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="/networks/create"><button class="btn btn-primary">New Network</button></a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>name</td>
                                <td>ipv4_cidr</td>
                                <td>default_gateway</td>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($networks as $n)
                            <tr>
                                <td><a href="/networks/show/{{$n->id}}">{{ $n->name }}</a></td>
                                <td>{{ $n->ipv4_cidr }}</td>
                                <td>{{ $n->default_gateway }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                    <a href="/containers/create"><button class="btn btn-primary">New Container</button></a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>name</td>
                                <td>cpu</td>
                                <td>memory</td>
                                <td>network_name</td>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($containers as $c)
                            <tr>
                                <td><a href="/containers/show/{{$c->id}}">{{ $c->name }}</a></td>
                                <td>{{ $c->cpu }}</td>
                                <td>{{ $c->memory }}</td>
                                <td>{{ $c->network->name }}</td>
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
