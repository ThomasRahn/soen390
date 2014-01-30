@extends('master')

@section('content')
<header>
        <div class="container">
                <h3><a href="#" class="muted pull-left">TalkTank</a></h3>
                <a href="/logout" class="pull-right">Logout</a>
                <div class="clear"></div>
        </div>
</header>
<div class="container">
	<div class="row">
	  <div class="options span2">
	      <ul class="nav nav-pills nav-stacked">
	        <li><a class="glyphicon glyphicon-home" href="/admin"> Home</a></li>
	        <li><a href="#" class="glyphicon glyphicon-list"> Narratives</a></li>
	        <li class="active"><a href="#" class="glyphicon glyphicon-upload"> Upload</a></li>
	        <li><a href="#" class="glyphicon glyphicon-cog"> Configurations</a></li>
	        <li><a href="#" class="glyphicon glyphicon-ban-circle"> Reported</a></li>
	      </ul>
      </div>
      <div class="span8">
      		{{ Form::open(array('url' => 'admin/upload/store', "method" => "POST",'files'=>true)) }}
      			{{ Form::label('narrative', 'Narrative'); }}
    			{{ Form::file('narrative'); }}

    			<br/>
    			{{ Form::submit('Upload'); }}
		{{ Form::close() }}
      </div>
	</div>
</div>
@stop
