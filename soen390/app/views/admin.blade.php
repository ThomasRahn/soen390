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
        <li class="active"><a class="glyphicon glyphicon-home" href="#"> Home</a></li>
        <li><a href="/admin/manage" class="glyphicon glyphicon-list"> Narratives</a></li>
        <li><a href="admin/upload" class="glyphicon glyphicon-upload"> Upload</a></li>
        <li><a href="#" class="glyphicon glyphicon-cog"> Configurations</a></li>
        <li><a href="#" class="glyphicon glyphicon-ban-circle"> Reported</a></li>
      </ul>
    </div>
    <div class="list span8">
        Google Analytic stuff here
    </div>
    <div class="clear"></div>
  </div>  
</div>


@stop
