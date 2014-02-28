<!doctype html>
<html lang='en'>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>TalkTank</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		<script src="//cdn.jsdelivr.net/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/jplayer/jquery.jplayer.min.js"></script>
		<script type="text/javascript" src="/js/jplayer/jplaylist.js"></script>

		 <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.0.3/css/bootstrap.min.css">

		<!--<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">-->
		<link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.min.css">	
        <link rel="stylesheet" href="/css/style.css">
	</head>
	<body>
		@yield('content')

		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-48518812-1']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</body>
</html>

