@extends('auth.master')

@section('view_title')
{{ trans('auth.login.title') }}
@stop

@section('styles')
<style>
    .auth-form .form-control {
        position: relative;
        padding: 10px;
        height: auto;
    }
    .auth-form input:focus {
        z-index: 2;
    }
    .auth-form input[type="email"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .auth-form input[type="password"] {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .checkbox-inline {
        margin-left: 10px;
    }
</style>
@stop

@section('content')
@if(Session::has('action.failed') === true)
<div class="alert {{ Session::get('action.failed') === false ? 'alert-info' : 'alert-danger' }}">
    <p>{{ Session::get('action.message') }}</p>
</div>
@endif

{{ Form::open(array('action' => 'AuthController@postLogin', 'class' => 'auth-form')) }}
    <div class="form-group">
        <input type="email" id="email" name="email" class="form-control" placeholder="{{ trans('auth.login.form.emailAddress') }}" value="{{ Input::old('email') }}" required>
        <input type="password" id="password" name="password" class="form-control" placeholder="{{ trans('auth.login.form.password') }}" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-default">{{ trans('auth.login.form.signIn') }}</button>
        <div class="checkbox-inline">
            <label>
                <input type="checkbox" id="remember" name="remember"{{ Input::old('remember') ? ' checked="checked"' : '' }}>
                <small>{{ trans('auth.login.form.rememberMe') }}</small>
            </label>
        </div>
    </div>
{{ Form::close() }}
@stop