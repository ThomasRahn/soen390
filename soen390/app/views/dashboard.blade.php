<html>
<head></head>
<body>

{{ $narratives->first()->Name }}
<br/>
{{ $narratives->first()->category()->first()->Name }} 
</body>

</html>
