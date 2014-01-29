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
                <ul class="nav nav-list">
                   <li class="nav-header">Quick links</li>
                   <li class="active"><a  href="#"><i class="icon-home"></i>Home</a></li>
                   <li><a href="#"><i class="icon-list"></i>Requests</a></li>
                   <li><a href="#"><i class="icon-user"></i>Account</a></li>
                   <li><a href="#"><i class="icon-plus"></i>Create</a></li>
                </ul>
           </div>
           <div class="span10">
           </div>
           <div class="clear"></div>
        </div>
</div>


@stop
