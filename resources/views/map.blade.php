<!DOCTYPE html >
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Reality</title>
    <link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.css')}}">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<body>



<div id="wrapper">
    <div id="map"></div>
    <div id="over_map">
        <h1>Filter:</h1>
        {!! Form::open(array('route' => 'filter', 'class' => 'form')) !!}
        <div class="form-group">
            {!! Form::label('Max Price') !!}

            <input class="form-control" name="price" type="text" class="form-control" placeholder="price" value="{!! old('price') !!}">



        </div>
        <div class="form-group">
            {!! Form::submit('submit',
              array('class'=>'btn btn-primary')) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>




<script type="text/javascript">




    //<![CDATA[

    var customIcons = {
        restaurant: {
            icon: 'https://mt.googleapis.com/vt/icon/name=icons/onion/166-purple-pushpin.png&scale=1.0',
            shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
        },
        bar: {
            icon: 'http://files.gamebanana.com/img/ico/games/css_icon.png',
            shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
        }
    };

    function initMap() {
        var cluster = [];
        var map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(48.6724821, 19.696058),
            zoom: 7,
            mapTypeId: 'roadmap'
        });
        var infowindow = new google.maps.InfoWindow();

        // Change this depending on the name of your PHP file
        downloadUrl("/data/{{$price}}", function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName("marker");
            for (var i = 0; i < markers.length; i++) {
                var name = markers[i].getAttribute("name");
                var address = markers[i].getAttribute("address");
                var type = markers[i].getAttribute("type");
                var point = new google.maps.LatLng(
                    parseFloat(markers[i].getAttribute("lat")),
                    parseFloat(markers[i].getAttribute("lng")));
                var html = "<b>" + name + "</b> <br/>" + address;
                var icon = customIcons[type] || {};
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    icon: icon.icon,
                    shadow: icon.shadow
                });
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {

                        var name = markers[i].getAttribute("name");
                        var address = markers[i].getAttribute("address");
                        var size = markers[i].getAttribute('size');
                        var id_reality = markers[i].getAttribute('id_reality');
                        infowindow.setContent(

                                @include('content')


                      );
                        console.log(markers[i]);




                        infowindow.open(map, marker);
                    }
                })(marker, i));
                cluster.push(marker);

            }
            var mc = new MarkerClusterer(map,cluster);

        });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;

                callback(request, request.status);
            }
        };

        request.open('GET', url, true);

        request.send(null);
    }

    function doNothing() {}

    //]]>
</script>


<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANgYNnUb9ebTTtB8RWgx0zHr4Nl-llHrI&callback=initMap">

</script>



</body>

</html>