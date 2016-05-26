@extends('layouts.material')

@section('content')
<section ng-app="DashboardApp" ng-cloak>
    <div ng-controller="DashboardController" layout="row">
        <md-sidenav class="md-sidenav-left md-whiteframe-z2"
                    md-component-id="left"
                    style="height: 100vh;"
                    md-is-locked-open="$mdMedia('gt-md')">
            <md-toolbar class="md-theme-indigo">
                <h1 class="md-toolbar-tools">Admin Dashboard</h1>
            </md-toolbar>
            <md-content layout-padding>
                Nav items here
            </md-content>
        </md-sidenav>
        <md-content flex layout-padding>
            @include('_dashboard.newMeetup')
        </md-content>
    </div>
</section>
    @endsection

@section('css')
    <link rel="stylesheet" href="{{ elixir('css/dashboard.css') }}" />
    @endsection

@section('footerScripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script>
    <script src="{{ elixir('js/dashboard.js') }}" type="text/javascript"></script>
    @endsection