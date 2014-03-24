@extends('admin.master')

@section('view_title')
{{ trans('admin.sidebar.profile') }}
@stop

@section('styles')
<style>
    .alert p:not(.lead),
    .help-block p {
        font-size: 14px;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @if (Session::has('action.message'))
        <div class="alert alert-{{ Session::get('action.failed', true) === true ? 'danger' : 'success' }}">
            {{ Session::get('action.message') }}
        </div>
        @endif

        {{ Form::model($user, array('action' => 'AdminProfileController@postIndex', 'class' => 'form-horizontal')) }}

            <div class="form-group">
                {{ Form::label('Name', trans('admin.profile.form.name'), array('class' => 'col-sm-4 control-label')) }}

                <div class="col-sm-8">
                    {{ Form::text('Name', null, array('class' => 'form-control', 'required' => 'required')) }}
                    <span class="help-block">
                        {{ $errors->first('Name') }}
                    </span>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('Email', trans('admin.profile.form.email'), array('class' => 'col-sm-4 control-label')) }}

                <div class="col-sm-8">
                    {{ Form::email('Email', null, array('class' => 'form-control', 'required' => 'required')) }}
                    <span class="help-block">
                        {{ $errors->first('Email') }}
                    </span>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('LanguageID', trans('admin.profile.form.language'), array('class' => 'col-sm-4 control-label')) }}

                <div class="col-sm-8">
                    {{ Form::select('LanguageID', $languages, null, array('class' => 'form-control', 'required' => 'required')) }}
                    <span class="help-block">
                        {{ $errors->first('LanguageID') }}
                    </span>
                </div>
            </div>

            <div class="alert alert-warning">
                {{ trans('admin.profile.form.changePasswordTip') }}
            </div>

            <div class="form-group">
                {{ Form::label('Password', trans('admin.profile.form.newPassword'), array('class' => 'col-sm-4 control-label')) }}

                <div class="col-sm-8">
                    {{ Form::password('Password', array('class' => 'form-control')) }}
                    <span class="help-block">
                        {{ $errors->first('Password') }}
                    </span>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('Password_confirm', trans('admin.profile.form.confirmPassword'), array('class' => 'col-sm-4 control-label')) }}

                <div class="col-sm-8">
                    {{ Form::password('Password_confirmation', array('class' => 'form-control')) }}
                    <span class="help-block">
                        {{ $errors->first('Password_confirm') }}
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    {{ Form::submit(trans('admin.profile.form.saveChanges'), array('class' => 'btn btn-primary')) }}
                    {{ Form::button(trans('admin.profile.form.undoChanges'), array('class' => 'btn btn-default')) }}
                </div>
            </div>

        {{ Form::close() }}
    </div>
</div>
@stop