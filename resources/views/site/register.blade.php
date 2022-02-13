@extends('layouts.site')

@section('body')
<div class="container mt-5">
    <div class="row">
        <div class="col text-center">
            <h2>Register</h2>
        </div>
    </div>
    <div class="row justify-center">
        <div class="col col-md-8 col-lg-6 col-xl-4">
            <form action="POST" method="{!! route('auth.register.create') !!}">
                @csrf
                <h4>Email</h4>
                <input type="email"
                       class="form-control"
                       placeholder="joe@example.com"
                       name="email"
                       autocomplete="email" />
                <h4>Password</h4>
                <input type="password"
                       class="form-control"
                       placeholder="$trongP@ssW0rd"
                       name="password"
                       autocomplete="new-password" />
                <h4>Verify Password</h4>
                <input type="password"
                       class="form-control"
                       placeholder="$trongP@ssW0rd"
                       name="passwordAgain"
                       autocomplete="new-password" />
            </form>
        </div>
    </div>
</div>
@endsection
