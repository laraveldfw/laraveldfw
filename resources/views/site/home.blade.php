@extends('layouts.site')

@section('body')
<div class="home-banner"></div>
<div class="row">

</div>
@endsection

@push('css')
<style>
.home-banner {
    background-image: url("https://laraveldfw-public.s3.amazonaws.com/site/dallas-ft-worth.jpeg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    width: 100%;
    min-height: 500px;
}
</style>
@endpush
