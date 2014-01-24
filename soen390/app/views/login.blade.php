<html>
<head>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
	<link href="/home/o_dror/soen390/soen390/app/css/stylesheet.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<form class="form-signin" id="loginForm" onsubmit="return validateLoginForm()" method="post">
			<h2 class="form-signin-heading">Login</h2>
			<input type="text" class="input-block-level" placeholder="Email Address" name="email">	
			<input type="password" class="input-block-level" placeholder="Password" name="password">
			<button class="btn btn-large btn-primary" type="submit">Login</button>
			<br /><br />
			<div id="errorMessage">
			</div>
		</form>
	</div>
</body>
</html>
