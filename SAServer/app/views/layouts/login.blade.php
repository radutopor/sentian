<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	@yield('headerSettings')

	<!-- master css -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<!-- master scripts -->
  <script type="text/javascript" src="js/jquery-2.0.3.js" ></script>
  <script type="text/javascript" src="js/knockout-3.0.0.debug.js" ></script>
  <script type="text/javascript" src="js/knockout.validation.js" ></script>
  <script type="text/javascript" src="js/app.js" ></script>
  <script type="text/javascript" src="js/login.js" ></script>

	@yield('externalFiles')

</head>
<body>
	<div class="header"></div>
	<div class="content">
		@yield('content')
	</div> 
	<div class="footer"></div>
</body>
</html>