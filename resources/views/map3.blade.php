<!DOCTYPE html >
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Reality page v 1.0</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>
    <link href="{{URL::asset('assets/fonts/font-awesome.css')}}" rel='stylesheet' type="text/css">
    <link rel="stylesheet" href="{{URL::asset('assets/bootstrap/css/bootstrap.css')}}" type="text/css">
    <link rel="stylesheet" href="{{URL::asset('assets/css/bootstrap-select.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{URL::asset('assets/css/jquery.slider.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{URL::asset('assets/css/style.css')}}" type="text/css">
    <link rel="stylesheet" href="{{URL::asset('css/styles.css')}}">
</head>
<body class="page-homepage navigation-fixed-bottom" id="page-top">
<div id="wrapper">
    <div id="map"></div>
    <div class="search-box-wrapper">
        <div class="search-box-inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <div class="search-box map">
                            {!! Form::open(array(
                            'action' => 'FilterController@change',
                            'class' => 'form-map form-search',
                            'id' => 'form-map',
                            )) !!}
                            <h2>Vyhľadať</h2>
                            {{--{!! Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S') !!}--}}
                            <div class="form-group">
                                <select id="kraj" name="kraj">
                                    <option value="all" selected>Kraj</option>
                                    @foreach($regions as $region)
{{--                                        @if ($region->id == $kraj)
                                            <option value="{{ $region->id }}" selected>{{ $region->name }}</option>
                                        @else--}}
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        {{--@endif--}}
                                    @endforeach
                                </select>
                            </div><!-- /.form-group -->
                            <div class="form-group">
                                <select id="mesto" name="mesto" class="selectpicker" data-live-search="true">
                                    <option value="all">všetky mesta</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div><!-- /.form-group -->
                            <div class="form-group">
                                {!! Form::label('Cena:') !!}
                                <div class="price-range">
                                    <input id="price-input" type="text" name="price" value="{{$price}}">
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<button type="submit" id="odoslat" class="btn btn-default">Search Now</button>--}}
                            {{--</div>--}}
                            {!! Form::close() !!}
                            <div class="form-group">
                                <button type="submit" id="odoslat" class="btn btn-default">Search Now</button>
                                <button type="submit" id="clear-all" class="btn btn-default" style="display:none">clear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{URL::asset('assets/js/jquery-2.1.0.min.js')}}"></script>
<script type="text/javascript">
    $(window).load(function() {
        $("#odoslat").click();
        $('#kraj').change(function(){
            var mesto = $('#mesto');
            var kraj = $( "#kraj" ).val();
            mesto.empty();
            console.log(kraj);
            $.get("data/mesta/"+kraj, function(data)
            {
                //mesto.empty();
                mesto.append($("<option></option>").attr("value","all").text("všetky mesta"));
                $.each(data, function(key, value) {
                        console.log(value['name']);
                        mesto.append($("<option></option>").attr("value",value['id']).text(value['name']));
                    });
                $('.selectpicker').selectpicker('refresh');
                });
        });
    });
</script>
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
    function initMap()
    {
        var map = new google.maps.Map(document.getElementById("map"),
        {
            center: new google.maps.LatLng(48.6724821, 19.696058),
            zoom: 7,
            mapTypeId: 'roadmap'
        });
        var infowindow = new google.maps.InfoWindow();
        //kliknutie tlacidla odoslat
        $("#odoslat").click(function()
        {
            var price,kraj,mesto;
            //precistenie pred dalsim nacitanim markerov
            $("#clear-all").click();
            price = $("[name='price']").val();
            kraj = $( "#kraj" ).val();
            mesto = $("[name='mesto']").val();
            console.log(price);
            console.log(kraj);
            console.log(mesto);
            var cluster = [];
            downloadUrl("/data/price/"+price+"/kraj/"+kraj+"/mesto/"+mesto+"", function(data)
            {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName("marker");
                var i,name,address,type,point,icon,marker,mc;
                // vytvorenie markerov
                for (i = 0; i < markers.length; i++)
                {
                    name = markers[i].getAttribute("name");
                    address = markers[i].getAttribute("address");
                    type = markers[i].getAttribute("type");
                    point = new google.maps.LatLng(
                        parseFloat(markers[i].getAttribute("lat")),
                        parseFloat(markers[i].getAttribute("lng")));
                    icon = customIcons[type] || {};
                    marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: icon.icon,
                        shadow: icon.shadow
                    });
                    console.log(markers[i]);
                    //kliknutie markera
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
 /*                         var name = markers[i].getAttribute("name");
                            var address = markers[i].getAttribute("address");
                            var price = markers[i].getAttribute('price');*/
                            var size = markers[i].getAttribute('size');
                            var id_reality = markers[i].getAttribute('id_reality');
                            infowindow.setContent(
                                    @include('content')
                            );
                            infowindow.open(map, marker);
                        }
                    }) (marker, i));
                    //end odkliknutie markera
                    cluster.push(marker);
                }
                //koniec vytvarania markerov
                mc = new MarkerClusterer(map,cluster);
                $('#clear-all').click(function () {
                    mc.clearMarkers();
                });
            });
        });
    }
    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANgYNnUb9ebTTtB8RWgx0zHr4Nl-llHrI&callback=initMap"></script>
<script type="text/javascript" src="{{URL::asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/tmpl.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/draggable-0.1.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/jquery.slider.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/custom.js')}}"></script>
<script type="text/javascript">
    //  Price slider
    var $priceSlider = $("#price-input");
    if($priceSlider.length > 0) {
        $priceSlider.slider({
            from: {{$min}},
            to: {{$max}},
            step: 100,
            round: 1,
            format: { format: '$ ###,###', locale: 'en' }
        });
    }
</script>

</body>
</html>