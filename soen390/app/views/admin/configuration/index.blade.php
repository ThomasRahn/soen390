@extends('admin.master')

@section('view_title')
{{ trans('admin.sidebar.configuration') }}
@stop

@section('styles')
<style>
    .alert-default {
        background-color: #f5f5f5;
        border-color: #e5e5e5;
        color: #555;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @if (Session::has('action.message'))
        <div class="alert alert-{{ Session::get('action.failed') === true ? 'danger' : 'success' }}">
            {{ Session::get('action.message') }}
        </div>
        @endif

        {{ Form::open(array('action' => 'AdminConfigController@postIndex', 'class' => 'form-horizontal')) }}
            <fieldset>
                <legend>{{ trans('admin.configuration.maintenance.legend') }}</legend>

                <div class="alert alert-default">
                    <p><small>{{ trans('admin.configuration.maintenance.description') }}</small></p>
                </div>

                <div class="form-group{{ $errors->has('maintenance') ? ' has-error' : '' }}">
                    {{ Form::label('maintenance', trans('admin.configuration.maintenance.label'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">
                        <div class="checkbox">
                            {{ Form::checkbox('maintenance', 'true', (Configuration::get('maintenance', 'false') == 'true')) }}
                        </div>
                        <span class="help-block">
                            {{ $errors->has('maintenance') ? $errors->first('maintenance') : '' }}
                        </span>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>{{ trans('admin.configuration.supportEmail.legend') }}</legend>

                <div class="alert alert-default">
                    <p><small>{{ trans('admin.configuration.supportEmail.description') }}</small></p>
                </div>

                <div class="form-group{{ $errors->has('support') ? ' has-error' : '' }}">
                    {{ Form::label('support', trans('admin.configuration.supportEmail.label'), array('class' => 'col-sm-4 control-label')) }}

                    <div class="col-sm-8">
                        {{ Form::email('support', Configuration::get('supportEmail'), array('class' => 'form-control')) }}
                        <span class="help-block">
                            {{ $errors->has('support') ? $errors->first('support') : '' }}
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