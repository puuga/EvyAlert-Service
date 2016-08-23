<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>EvyAlert</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"
    integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
    crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <!-- Material Design fonts -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">

    <!-- Bootstrap Material Design -->
    <link href="css/bootstrap-material-design.css" rel="stylesheet">
    <link href="css/ripples.min.css" rel="stylesheet">
    <!-- Dropdown.js -->
    <link href="//cdn.rawgit.com/FezVrasta/dropdown.js/master/jquery.dropdown.css" rel="stylesheet">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      body {
        padding-top: 50px;
      }
      #map {
        height: 100%;
      }
      .container-fluid, .row {
        height: 100%;
      }
    </style>
  </head>
  <body>
    <!-- content -->
    <div class="container-fluid">

      <div class="row">

        <div id="map" class="col-sm-8"></div>

        <div id="list" class="col-sm-4">
          <h2>Filter</h2>
        </div>

      </div>

    </div>

    <!-- nev bar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed"
          data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
          aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">EvyAlert</a>
        </div>
      </div>
    </nav>

    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 13.6256047, lng: 100.9986654},
          zoom: 5
        });

        setMapCentertoMyLocation();
      }

      function setMapCentertoMyLocation() {
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            var cityCircle = new google.maps.Circle({
              strokeColor: '#4444FF',
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: '#AAAAFF',
              fillOpacity: 0.35,
              map: map,
              center: pos,
              radius: 20
            });

            console.log(pos);
            map.setZoom(12);
            map.setCenter(pos);
          }, function() {
            console.log("Error: The Geolocation service failed.");
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrgczUw139gbbLb4fCg0NBbn5bsdCS2o4&callback=initMap&signed_in=true"
    async defer></script>
    <script>

    </script>
  </body>
</html>
