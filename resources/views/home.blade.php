@extends('layouts.default')

@if($data['online'] !== true)
    @section('head')
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&sensor=false">
        </script>
        <script type="text/javascript">
            // Enable the visual refresh
            google.maps.visualRefresh = true;
            var map;
            var lat = {{ $data['location_lat'] }};
            var lon = {{ $data['location_lng'] }};
            var laravelDFWLocation = new google.maps.LatLng(lat,lon);

            lat = lat + 0.008;
            var mapCenterLocation = new google.maps.LatLng(lat,lon);
            function initialize() {
                var mapOptions = {
                    scrollwheel: false,
                    draggable: false,
                    center: mapCenterLocation,
                    zoom: 13,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map-canvas"),
                        mapOptions);
                addMarker(laravelDFWLocation, map);

            }

            // Function for adding a marker to the page.
            function addMarker(location, map) {
                marker = new google.maps.Marker({
                    position: location,
                    map: map
                });

                markerinfo = new google.maps.InfoWindow({
                    content: '<a class="map-location-title-link" href="{{ $data['location_url'] }}"><h4 class="map-location-title">{{{ $data['location_name'] }}}</h4></a><h5 class="map-date">{{{ $startTime }}}</h5><p class="map-location-address">{{{ $data['location_address'] }}}<br/>{{{ $data['location_phone'] }}}</p>'
                });
                markerinfo.open(map, marker);

                google.maps.event.addListener(marker, 'click', (function(marker) {
                    return function() {
                        markerinfo.open(map, marker);
                    }
                })(marker));
            }

            google.maps.event.addDomListener(window, 'load', initialize);

        </script>
    @stop
@endif

@section('content')

    <div class="navbar-wrapper">
        <div class="container">

            <div class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="http://www.laraveldfw.com"><div class="laravel-logo"></div>Laravel DFW</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="http://www.meetup.com/laravel-dallas-fort-worth" target="_blank">Meetup Group</a></li>
                            <li><a class="to-email-signup" href="#mc_embed_signup">Get Laravel DFW Updates</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Resources <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">Sites</li>
                                    <li><a href="http://www.laravel.com" target="_blank">Laravel.com <span class="menu-subtext">Official Website</span></a></li>
                                    <li><a href="http://laravel.com/docs" target="_blank">Laravel Docs</a></li>
                                    <li><a href="http://www.laracasts.com" target="_blank">Laracasts <span class="menu-subtext">Video Tutorials</span></a></li>
                                    <li><a href="http://www.laravel.io" target="_blank">Laravel.io <span class="menu-subtext">The Community</span></a></li>
                                    <li><a href="http://www.larajobs.com" target="_blank">Larajobs.com <span class="menu-subtext">Find a Job</span></a></li>
                                    <li><a href="https://leanpub.com/book_search?search=laravel" target="_blank">Books</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-header">Twitter Accounts</li>
                                    <li><a href="https://twitter.com/laravelphp" target="_blank">@laravelphp</a></li>
                                    <li><a href="https://twitter.com/LaravelIO" target="_blank">@laravelio</a></li>
                                    <li><a href="https://twitter.com/laracasts" target="_blank">@laracasts</a></li>
                                </ul>
                            </li>
                            <li><a href="/login" target="_self">Admins</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="myCarousel" class="carousel slide">
        <div class="carousel-inner">
            <div class="item active">
                <div id="feature-image">
                    <div class="container">
                        <div class="row feature-content">
                            <div class="col-sm-3">
                                @if(isset($data['speaker_img']) && !empty($data['speaker_img']))
                                    <img src="{{ asset($data['speaker_img']) }}" alt="{{ $data['speaker'] }}" class="img-circle feature-speaker-image">
                                @else
                                    <img src="{{ asset('images/laravel-dfw-image.jpg') }}" alt="LaravelDFW" class="img-circle feature-speaker-image">
                                @endif
                            </div>
                            <div class="col-sm-9 feature-info">
                                <h4>Next Meetup: <span class="meetup-date">{{ $startTime }} {{ ($data['online'])?'on':'at' }} <a href="{{ $data['location_url'] }}" target="_blank">{{ $data['location_name'] }}</a></span></h4>

                                <!-- Presentation Title -->
                                <h2>{{ $data['talk'] }}</h2>

                                <!-- Presented By -->
                                @if(isset($data['speaker']) && !empty($data['speaker']))
                                    <h3 class="presenter-text"><span class="presented-by">Presented by</span> <a href="{{ $data['speaker_url'] }}" target="_blank">{{ $data['speaker'] }}</a></h3>
                                @else
                                    <h3 class="presenter-text"><span class="presented-by">Presented by</span> <a href="http://www.laraveldfw.com">LaravelDFW</a></h3>
                                @endif
                                <!-- Free Stuff Alert -->
                                @if(isset($data['additional_info']) && !empty($data['additional_info']))
                                    <div class="alert alert-warning"><strong id="additionalInfo">{{ $data['additional_info'] }}</strong></div>
                                @endif

                                <!-- RSVP Button -->
                                <a class="btn btn-lg btn-danger btn-header-action" data-toggle="modal" href="{{ route('rsvp') }}" target="_blank">RSVP Now!</a>

                                @if($data['online'] === true)
                                    <!-- Ask Button -->
                                    <a class="btn btn-lg btn-success btn-header-action" data-toggle="modal" href="{{ route('ask') }}" target="_blank">Ask us a Question</a>

                                    <!-- Watch Live Button -->
                                    <a class="btn btn-lg btn-warning btn-header-action" data-toggle="modal" href="{{ route('live') }}" target="_blank">Watch Live</a>
                                @endif

                                <!-- Slack Invite Button -->
                                <a class="btn btn-lg btn-info btn-header-action" data-toggle="modal" href="{{ route('slack') }}" target="_blank">Join our Slack Group</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="google-maps-wrapper">
        @if($data['online'] === true)
            <h3 class="text-center">
                <i class="icon-location-arrow"></i>
                This Meetup is on Google Hangouts!
                <i class="icon-map-marker"></i>
            </h3>
        @else
            <div id="map-canvas"></div>
        @endif
    </div>

    <div class="container">
        <!-- Begin MailChimp Signup Form -->
        <div id="mc_embed_signup">
            <form action="http://laraveldfw.us7.list-manage.com/subscribe/post?u=fddcabd02e9fef6de60bf4e2b&amp;id=0bf5df0e38" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                <div class="row">

                    <div class="col-sm-4 col-sm-offset-4">
                        <h3>Get Laravel DFW Updates</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mc-field-group form-group">
                                    <label for="mce-FNAME">First Name</label>
                                    <input type="text" value="" name="FNAME" class="required form-control" id="mce-FNAME" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mc-field-group form-group">
                                    <label for="mce-LNAME">Last Name</label>
                                    <input type="text" value="" name="LNAME" class="required form-control" id="mce-LNAME" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mc-field-group form-group">
                                    <label for="mce-EMAIL">Email</label>
                                    <input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" value="Get Updates" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-lg btn-danger btn-block">
                                <div id="mce-responses" class="clear">
                                    <div class="response" id="mce-error-response" style="display:none"></div>
                                    <div class="response" id="mce-success-response" style="display:none"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <footer>
            <p class="pull-right back-to-top"><a class="back-to-top" href="#">Back to top</a></p>
            <p class="text-center copyright">&copy; 2013 - 2015 <a href="http://www.laraveldfw.com">Laravel DFW</a> | <a href="http://www.meetup.com/laravel-dallas-fort-worth" target="_blank">Meetup Group</a></p>
        </footer>
    </div><!-- end .container -->
@stop

@section('footer')

    <script type="text/javascript">
        $("body").backstretch("images/laravel-dfw-bg.jpg");

        $('.back-to-top').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });

        $('.to-email-signup').click(function(){
            $("html, body").animate({ scrollTop: $(document).height() }, 600);
            return false;
        });

        $(document).ready(function () {
            var maxInfo = 150;
            var info = $("#additionalInfo").html();

            if(info.length > maxInfo){
                var newInfo = info.substr(0, maxInfo) + '... ' + '<a href="{{ route('rsvp') }}" target="_blank">See More</a>';
                $("#additionalInfo").html(newInfo);
            }
        });
    </script>

@stop