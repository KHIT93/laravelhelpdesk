@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">Manage Helpdesk Teams</div>
                <div class="card-body">
                    <a href="{{ route('teams.create') }}" class="btn btn-primary mb-3">Create team</a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($teams->count())
                            @foreach($teams as $team)
                            <tr>
                                <td>{{$team->name}}</td>
                                <td>{{$team->email}}</td>
                                <td><a href="{{ route('teams.edit',['team'=>$team->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">There are currently no teams created!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
