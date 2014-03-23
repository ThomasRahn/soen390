@extends('admin.master')

@section('view_title')
Google Analytics
@stop

@section('styles')
<style>
    .ga {
        margin-top: 5%;
        text-align: center;
    }
    .ga-icon {
        font-size: 48px;
        margin-bottom: 20px;
    }
</style>
@stop

@section('content')
<div class="row ga">
    <i class="fa fa-bar-chart-o fa-fw ga-icon"></i><br>
    <a class="btn btn-success" href="https://www.google.com/analytics/web/?hl=en" target="_blank">OPEN GOOGLE ANALYTICS</a>
</div>
@stop