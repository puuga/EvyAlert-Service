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

    <!-- firebase -->
    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase-app.js"></script>
    <script>
      // Initialize Firebase
      var config = {
        apiKey: "AIzaSyCE47MZ_hqzjniiDviTFDozAE7Qnvb5owY"
      };
      firebase.initializeApp(config);
    </script>

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
      #list {
        height: 100%;
      }
      .container-fluid, .row {
        height: 100%;
      }
      #listView {
        height: 100%;
        overflow-y: scroll;
      }
      .img-profile {
        max-width: 50px;
        max-height: 50px;
      }
      .panel {
        cursor: pointer;
        cursor: hand;
      }
    </style>
  </head>
  <body>
    <!-- content -->
    <div class="container-fluid">

      <div class="row">

        <div id="map" class="col-sm-8"></div>

        <div id="list" class="col-sm-4">

          <div class="form-group col-md-12">
            <label for="selectOption" class="col-md-2 control-label">Filter</label>
            <div class="col-md-10">
              <select id="selectOption" class="form-control">
                <option value="0">Near by 20 Km</option>
                <option value="1">Near by 50 Km</option>
                <option value="2">Last 2 Days</option>
              </select>
            </div>
          </div>

          <div id="listView" class="col-md-12">
          </div>

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
      var eventIcons = [
        "img/ic_accident_red_600_36dp.png",
        "img/ic_natural_disaster_amber_800_36dp.png",
        "img/ic_other_amber_800_36dp.png",
        "img/ic_traffic_jam_orange_800_36dp.png"
      ];
      var pos = {
        lat: 13.6256047,
        lng: 100.9986654
      };
      var map;
      var markers = [];
      // var infoWindows = [];
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
            pos = {
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
            loadNearby("0");
          }, function() {
            console.log("Error: The Geolocation service failed.");
          });
        }
      }

      function makeMarkersOnMap(events) {
        clearMarkers();
        for (var i = 0; i < events.length; i++) {
          var eventData = events[i];

          var marker = new google.maps.Marker({
            map: map,
            title: eventData.title,
            animation: google.maps.Animation.DROP,
            icon: eventIcons[parseInt(eventData.event_type_index)],
            position: {lat: parseFloat(eventData.lat), lng: parseFloat(eventData.lng)}
          });
          var infoWindow = new google.maps.InfoWindow({
            content: eventData.title
          });
          var contentString = eventData.title;

          google.maps.event.addListener(marker,'click', (function(marker,contentString,infoWindow) {
            return function() {
              infoWindow.setContent(contentString);
              infoWindow.open(map,marker);
            };
          })(marker,contentString,infoWindow));
          markers.push(marker);
          // infoWindows.push(infoWindow);
        }
      }

      function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
          var marker = markers[i];
          marker.setMap(null);
        }
        markers = [];
        // infoWindows = [];
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrgczUw139gbbLb4fCg0NBbn5bsdCS2o4&callback=initMap&signed_in=true"
    async defer></script>
    <script>
      $("#selectOption").change(function() {
        var val = $(this).val();
        loadEvents(val);
      });

      function loadEvents(option) {
        switch (option) {
          case "0":
            console.log("loadNearby20");
            loadNearby(0);
            break;
          case "1":
            console.log("loadNearby50");
            loadNearby(1);
            break;
          case "2":
            console.log("loadLast2Day");
            loadNearby(2);
            break;
          default:

        }
      }

      function loadNearby(option) {
        var url = "https://evyalert.roomlinksaas.com/evyalert-service/service_events.php?";
        url += "filter=" + option;
        url += "&lat=" + pos.lat;
        url += "&lng=" + pos.lng;
        var jqxhr = $.ajax(url)
        .done(function(json) {
          console.log(json);
          bindJsonToList(json);
          makeMarkersOnMap(json);
        })
        .fail(function() {
          console.log("error");
        })
      }

      function loadEventsLast2Days(option) {
        var url = "https://evyalert.roomlinksaas.com/evyalert-service/service_events.php?";
        url += "filter=" + option;
        var jqxhr = $.ajax(url)
        .done(function(json) {
          console.log(json);
          bindJsonToList(json);
          makeMarkersOnMap(json);
        })
        .fail(function() {
          console.log("error");
        })
      }

      function bindJsonToList(json) {
        var output = "";
        for (var i = 0; i < json.length; i++) {
          var eventData = json[i];
          output += makeViewHolder(eventData, i);
        }
        $("#listView").html(output);
      }

      function makeViewHolder(eventData, index) {
        var holder = "<div class=\"panel panel-default\" onclick=\"javascript:onHolderClick("+index+")\">";
        holder += "<div class=\"panel-heading\">"; // panel-heading
          holder += "<div class=\"row\">";
          holder += "<div class=\"col-sm-3\">"; // div profile photo
          holder += "<img src=\""+eventData.user_photo_url+"\" class=\"img-profile img-responsive img-circle\">";
          holder += "</div>"; // end div profile photo
          holder += "<div class=\"col-sm-7\">"; // div profile info
          holder += eventData.user_name + "<br/>";
          holder += eventData.created_at + "<br/>";
          holder += "</div>";// end div profile info
          holder += "<div class=\"col-sm-2\">"; // div event info
          holder += "<img src=\""+eventIcons[parseInt(eventData.event_type_index)]+"\" class=\"img-profile img-responsive img-circle\">";
          holder += "</div>";// end div event info
          holder += "</div>";
        holder += "</div>";// end panel-heading
        holder += "<div class=\"panel-body\">";
          holder += eventData.title + "<br/>";
          if (eventData.event_photo_url !== "") {
            holder += "<img src=\""+eventData.event_photo_url+"\" class=\"img-responsive\">";
          }
        holder += "</div>";
        holder += "</div>";
        return holder;
      }

      function onHolderClick(index) {
        var marker = markers[index];
        google.maps.event.trigger(marker, 'click');

        map.setCenter(marker.position);
      }
    </script>
  </body>
</html>
