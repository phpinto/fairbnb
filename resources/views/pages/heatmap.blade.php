<style>

path {

  stroke: #fff;
  stroke-width: .5;
  stroke-dasharray: 1;
  
}

#neighborhoodPopover { 
  position: absolute;     
  text-align: center;         
  padding: 2px;       
  font: 12px sans-serif;   
  background: #fff; 
  border: 0px;    
  border-radius: 8px;     
  pointer-events: none;
  opacity: 0;  
}

</style>


<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src="https://d3js.org/topojson.v1.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-item nav-link" href="/predictor/">Price Predictor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link" href="/heat_map/">NYC Heat Map</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>


                <svg width="720" height="540"></svg>
                <div id='neighborhoodPopover'> </div>


<script>

var svg = d3.select("svg"),
    width = +svg.attr("width"),
    height = +svg.attr("height");


d3.json('/return_json', function(error, nyc) {
  if (error) throw error;

  var path = d3.geoPath()
      .projection(d3.geoConicConformal()
      .parallels([33, 45])
      .rotate([96, -39])
      .fitSize([width, height], nyc));


  svg.selectAll("path")
      .data(nyc.features)
      .enter().append("path")
      .attr("d", path)
      .style("fill", function(d) { 
          if (d.properties.price == 0) {
            return "#afafaf";
          }
          else if (d.properties.price <= 75) {
            return "#008000";
          }
          else if (d.properties.price <= 100) {
            return "#034503";
          }
          else if (d.properties.price <= 150) {
            return "#e6df07";
          }
          else if (d.properties.price <= 200) {
            return "#e68107";
          }
          else if (d.properties.price <= 300) {
            return "#d13b00";
          }
          else if (d.properties.price <= 450) {
            return "#d61900";
          }
          else {
            return "#8f0404";
          }
        })
      .on("mouseenter", function(d) {
        console.log(d);
      d3.select(this)
      .style("stroke-width", 1.5)
      .style("stroke-dasharray", 0)
     
      if (d.properties.price > 0) {
        d3.select("#neighborhoodPopover")
            .transition()
            .style("opacity", 1)
            .style("left", (d3.event.pageX) + "px")
            .style("top", (d3.event.pageY) + "px")
            .text(d.properties.neighborhood + ": $" + d.properties.price.toFixed(2).toString())
      }
      else {
        d3.select("#neighborhoodPopover")
            .transition()
            .style("opacity", 1)
            .style("left", (d3.event.pageX) + "px")
            .style("top", (d3.event.pageY) + "px")
            .text(d.properties.neighborhood)
      }

    })
    .on("mouseleave", function(d) { 
      d3.select(this)
      .style("stroke-width", .25)
      .style("stroke-dasharray", 1)

      d3.select("#cneighborhoodPopoverountyText")
      .transition()
      .style("opacity", 0);
    });

    var myimage = svg.append('image')
        .attr('xlink:href', '/return_image')
        .attr('x', 500)
        .attr('y', 0) 
        .attr('width', 200)
        .attr('height', 200)

    console.log(nyc);
});

</script>

</body>
</html>