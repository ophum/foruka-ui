@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                    <form action='{{ route("container_store") }}' method="POST">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label>cpu</label>
                            <input class="form-control" type="number" name="cpu">
                        </div>
                        <div class="form-group">
                            <label>memory</label>
                            <input class="form-control" type="text" name="memory">
                        </div>
                        <div class="form-group">
                            <label>network</label>
                            <select class="form-control" name="network_id">
                            @foreach($networks as $n) 
                                <option value="{{ $n->id }}">{{ $n->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" value="Create">
                        </div>
                    </form>
                <div class="card-body">

            </div>
        </div>
    </div>
</div>
@endsection
