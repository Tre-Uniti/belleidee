<!doctype html>
<html lang="en">
<head>
    <meta charset=""UTF-8">
    @yield('siteTitle')
</head>
<body>
<div class = "tL-M">
    @yield('topLeft-menu')
</div>
<div class = "l-P">
    @yield('left-profile')
</div>
<div class = "bL-M">
    @yield('bottomLeft-menu')
</div>
<div class = "c-M">
    @yield('center-menu')
</div>
<div class = "c-V" style = "
    width: 50%;
	height: auto;
	margin: 0 auto;
	background-color: black;
	display: inline-block;
	opacity:0.87;
	filter:alpha(opacity=87);
	border: 2px solid;
	border-radius: 25px;
	font-family: Arial Black, Gadget, sans-serif;">
    @yield('center-Valve')
</div>
<div class = "c-B")>
    @yield('center-Bottom')
</div>
<div class = "tR-M")>
    @yield('topRight-menu')
</div>
<div class = "l-P")>
    @yield('right-profile')
</div>
<div class = "bL-M")>
    @yield('bottomRight-menu')
</div>
</body>
</html>