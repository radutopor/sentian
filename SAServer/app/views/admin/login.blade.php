@section('headerSettings')
<title>Control Panel -Index</title>
@stop

@section('content')
<div class="row" style="margin-top:20px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<form role="form" action='/signIn' method='POST'>
			<fieldset>
				<h2>Please Sign In</h2>
				<hr class="colorgraph">
				<div class="form-group">
                    <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" required>
				</div>
				<div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" required>
				</div>
				<!-- <span class="button-checkbox">
					<button type="button" class="btn" data-color="info">Remember Me</button>
                    <input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
				</span> -->
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
                         <input type="submit" class="btn btn-lg btn-success btn-block" value="Sign In">
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
@stop