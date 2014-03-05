@extends('admin.master')

@section('title')
Configuration
@stop

@section('styles')
<style>
    .alert {
        background-color: #f5f5f5;
        border-color: #e5e5e5;
        color: #555;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">

        {{ Form::open(array('action' => 'AdminConfigController@postIndex', 'class' => 'form-horizontal')) }}
            <fieldset>
                <legend>{{ trans('admin.configuration.maintenance.legend') }}</legend>

                <div class="alert">
                    <p><small>{{ trans('admin.configuration.maintenance.description') }}</small></p>
                </div>

                <div class="form-group">
                    {{ Form::label('maintenance', trans('admin.configuration.maintenance.label'), array('class' => 'col-sm-3 control-label')) }}

                    <div class="col-sm-9">
                        <div class="checkbox">
                            {{ Form::checkbox('maintenance', 'enable') }}
                        </div>
                        <span class="help-block">
                            <small>{{ trans('admin.configuration.maintenance.help') }}</small>
                        </span>
                    </div>
                </div>
            </fieldset>

            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    {{ Form::submit(trans('admin.configuration.saveSettings'), array('class' => 'btn btn-primary')) }}
                    {{ Form::button(trans('admin.configuration.resetSettings'), array('type' => 'reset', 'class' => 'btn btn-default')) }}
                </div>
            </div>
        {{ Form::close() }}

    </div>
</div>
@stop