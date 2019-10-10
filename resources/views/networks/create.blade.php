@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Network</div>

                <div class="card-body">
                    <form action='{{ route("network_store") }}' method="POST">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label>ipv4 cidr</label>
                            <input class="form-control" type="text" name="ipv4_cidr">
                        </div>
                        <div class="form-group">
                            <label>default gateway</label>
                            <input class="form-control" type="text" name="default_gateway">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" value="Create">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
