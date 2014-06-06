<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sentian - Sentimental Web Analysis</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<!-- My CSS -->
    <link href="main.css" rel="stylesheet">

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Sentian</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="fb_login">Login with Facebook</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div id="content" class="container">
	
	  <h1 class="text-align-center title">Sentian - Sentimental Web Analysis<h1>
	
	  <div class="input-group input-group-lg input-field">
		<input id="analyse_in" type="text" class="form-control">
		<span class="input-group-btn">
		  <button id="analysing" class="btn btn-default disabled" type="button" style="display:none">Analysing...</button>
		  <button id="analyse" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search">&nbsp;</span>Analyse</button>
		</span>
	  </div>
	
	  <div id="analysis_result"></div>
	
	  </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- My JavaScript -->
	<script src="js/analyse.js"></script>
  </body>
</html>