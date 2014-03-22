@extends('layouts.default')

@section('head')
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJPjuNamTjqMr47aMldOQB9ZW2yXtfr-E&sensor=false">
  </script>
  <script type="text/javascript">
    // Enable the visual refresh
    google.maps.visualRefresh = true;
    var map;
    var lat = 32.7307852;
    var lon = -97.3269152;
    var laravelDFWLocation = new google.maps.LatLng(lat,lon);

    lat = lat + 0.008
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
          content: '<a class="map-location-title-link" href="{{{ $locationurl }}}"><h4 class="map-location-title">The Music Bed</h4></a><h5 class="map-date">Thursday, February 9th at 7:00pm</h5><p class="map-location-address">158 West Magnolia Ave<br>Fort Worth, TX 76104</p>'
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
              <a class="navbar-brand" href="http://www.meetup.com/laravel-dallas-fort-worth"><div class="laravel-logo"></div>Laravel DFW</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="http://www.meetup.com/laravel-dallas-fort-worth">Meetup Group</a></li>
                <li><a class="to-email-signup" href="#mc_embed_signup">Get Laravel DFW Updates</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Resources <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li class="dropdown-header">Sites</li>
                    <li><a href="http://www.laravel.com">Laravel.com <span class="menu-subtext">Official Website</span></a></li>
                    <li><a href="http://laravel.com/docs">Laravel Docs</a></li>
                    <li><a href="http://www.laracasts.com">Laracasts <span class="menu-subtext">Video Tutorials</span></a></li>
                    <li><a href="http://www.laravel.io">Laravel.io <span class="menu-subtext">The Community</span></a></li>
                    <li><a href="https://leanpub.com/book_search?search=laravel">Books</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Twitter Accounts</li>
                    <li><a href="https://twitter.com/laravelphp">@laravelphp</a></li>
                    <li><a href="https://twitter.com/LaravelIO">@laravelio</a></li>
                    <li><a href="https://twitter.com/laracasts">@laracasts</a></li>
                  </ul>
                </li>
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
                  <img src="{{ asset('img/taylor-otwell.jpg') }}" alt="David Adams" class="img-circle feature-speaker-image">
                </div>
                <div class="col-sm-9 feature-info">
                  <h4>Next Meetup: <span class="meetup-date">Thursday, April 3rd at 7:00pm on <a href="{{ $locationurl }}" target="_blank">Google Hangouts</a></h4>

                  <!-- Presentation Title -->
                  <h2>Live Q&amp;A with Taylor Otwell</h2>

                  <!-- Presented By -->
                  <h3 class="presenter-text"><span class="presented-by">Presented by</span> <a href="https://twitter.com/taylorotwell">Taylor Otwell</a></h3>

                  <!-- Free Stuff Alert -->
                  {{-- <div class="alert alert-success">Have a question for Taylor? <strong><a href="{{ route('ask') }}">Submit your question here</a></strong></div> --}}

                  <!-- Free Stuff Alert -->
                  {{-- <div class="alert alert-danger"><strong>Want a free Laravel book?</strong><br>We are giving away <strong>free copies</strong> of <strong><a href="https://leanpub.com/codebright">Code Bright</a></strong> by <strong><a href="https://twitter.com/daylerees">Dayle Rees</a></strong> at this meetup!</div> --}}

                  <!-- RSVP Button -->
                  <a class="btn btn-lg btn-danger btn-header-action" data-toggle="modal" href="http://www.meetup.com/laravel-dallas-fort-worth/events/158539822/" target="_blank">RSVP Now!</a>

                  <!-- Ask Button -->
                  <a class="btn btn-lg btn-success btn-header-action" data-toggle="modal" href="{{ route('ask') }}" target="_blank">Submit A Question</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="google-maps-wrapper">
      @if($hidemap == true)
        <h3 class="text-center">
          <i class="icon-location-arrow"></i>
          The April Meetup is on Google Hangouts!
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
        <p class="text-center copyright">&copy; 2013-2014 <a href="http://www.meetup.com/laravel-dallas-fort-worth">Laravel DFW</a>.</p>
      </footer>
    </div><!-- end .container -->
@stop

@section('footer')

  <script type="text/javascript">
    $("body").backstretch("img/laravel-dfw-bg.jpg");

    $('.back-to-top').click(function(){
      $("html, body").animate({ scrollTop: 0 }, 600);
      return false;
    });

    $('.to-email-signup').click(function(){
      $("html, body").animate({ scrollTop: $(document).height() }, 600);
      return false;
    });

  </script>

@stop