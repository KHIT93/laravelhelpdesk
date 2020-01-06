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
            <form method="post" action="{{ route('teams.update', ['team' => $team->id]) }}" role="form">
                <div class="card">
                    <div class="card-header">Edit Team {{$team->name}}</div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" placeholder="Priority Support" required id="name" name="name" value="{{ old('name') ?? $team->name }}"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" placeholder="priority@example.com" required id="email" name="email" value="{{ old('email') ?? $team->email }}"/>
                        </div>
                        <div class="form-group">
                            <label for="email_host">Email Host</label>
                            <input type="text" class="form-control" placeholder="mail.example.com" required id="email_host" name="email_host" value="{{ old('email_host') ?? $team->email_host }}"/>
                        </div>
                        <div class="form-group">
                            <label for="email_user">Email User</label>
                            <input type="text" class="form-control" placeholder="priority@example.com" required id="email_user" name="email_user" value="{{ old('email_user') ?? $team->email_user }}"/>
                        </div>
                        <div class="form-group">
                            <label for="email_pass">Email Password</label>
                            <input type="password" class="form-control" placeholder="P@ssw0rd" id="email_pass" name="email_pass" value="{{ old('email_pass') ?? $team->email_pass }}"/>
                        </div>
                        <div class="form-group">
                            <label for="email_encryption">Encryption</label>
                            <select class="form-control" id="email_encryption" required name="email_encryption">
                                <option value="none" {{ ($team->email_encryption == 'none') ? 'selected': '' }}>None</option>
                                <option value="ssl" {{ ($team->email_encryption == 'ssl') ? 'selected': '' }}>SSL</option>
                                <option value="starttls" {{ ($team->email_encryption == 'starttls') ? 'selected': '' }}>STARTTLS</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
