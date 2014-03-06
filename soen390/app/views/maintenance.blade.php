@extends('auth.master')

@section('view_title')
{{ trans('auth.maintenance.title') }}
@stop

@section('content')
<div class="alert alert-info">
    {{ trans('auth.maintenance.message') }}
</div>
@stop