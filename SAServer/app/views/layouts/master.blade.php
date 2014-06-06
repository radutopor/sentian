<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  @yield('headerSettings')

  <!-- master css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link href="css/simple-sidebar.css" rel="stylesheet">
  <!-- <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" type="text/css" href="css/main.css">

  <!-- master scripts -->
  <script type="text/javascript" src="js/jquery-2.0.3.js" ></script>
  <script type="text/javascript" src="js/knockout-3.0.0.debug.js" ></script>
  <script type="text/javascript" src="js/knockout.validation.js" ></script>
  <script type="text/javascript" src="js/app.js" ></script>
  <script type="text/javascript" src="js/enum.js" ></script>
  <script type="text/javascript" src="js/settings.js" ></script>

  @yield('externalFiles')

</head>
<body>
	<div id="wrapper">
    <!-- ALERT -->
    <div class="divAlert" style="display:none">
      <div class="alert" >
        <button type="button" class="close" aria-hidden="true" onclick="hideBoostrapAlert();return false;">&times;</button>
        <div class='message'></div>
      </div>
    </div>
    <!-- ALERT -->

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand"><a href="#">Control Panel</a></li>
        <li><a href="/servicelist">Service List</a></li>
        <li><a href="/endpointlist">Endpoint List</a></li>
      </ul>
    </div>

    <!-- Page content -->
    <div id="page-content-wrapper">
      <div class="content-header">
        <h1>
          <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
          @yield('welcomeMessage')
        </h1>
      </div>
      <!-- Keep all page content within the page-content inset div! -->
      <div class="page-content inset">
        <div class="row">
          @yield('content')
        </div>
      </div>
    </div>

  </div>

  <!-- JavaScript -->
  <!--  <script src="js/jquery-1.10.2.js"></script> -->
  <script src="js/bootstrap.js"></script>

  <!-- Custom JavaScript for the Menu Toggle -->
  <script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("active");
  });
  </script>
</body>
</html>