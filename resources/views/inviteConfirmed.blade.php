@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h3 class="text-center">
                Slack invite sent to {{ $name }} at {{ $email }}
            </h3>
            <h5 class="text-center">
                You will be automatically be rerouted back to the main site in five seconds
            </h5>
        </div>
    </div>
    @endsection

@section('footer')
    <script>
        $(document).ready(function () {
           setTimeout(function () {
               window.location.assign('/');
           }, 5000);
        });
    </script>
    @endsection