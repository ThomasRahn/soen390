@extends('master')

@section('content')

<div class="container1">
	<div class="panel panel-primary">
		<div class="panel-heading">
	    	<h3 class="panel-title">Login</h3>
	  	</div>
	  	<div class="panel-body">
				<form class="form-horizontal" method="POST">
			  		<div class="form-group">
			    		<label for="email" class="col-sm-2 control-label">Email</label>
			    		<div class="col-sm-10">
			      			<input type="email" name="email" class="form-control input-lg" id="email" placeholder="Email">
			    		</div>
			  		</div>

			  		<div class="form-group">
			    		<label for="password" class="col-sm-2 control-label">Password</label>
			    		<div class="col-sm-10">
			      			<input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password">
			    		</div>
			  		</div>

			  		<div class="form-group">
			    		<div class="col-sm-offset-2 col-sm-10">
			      			<input type="submit" class="btn btn-primary btn-lg" value="Sign In"/>
			    		</div>
			  		</div>
				</form>

@if (isset($msg))
	<div class="msg">
 		<p>{{ $msg }}</p>
 	</div>
@endif
	  	</div>
	</div>
</div>
@stop
