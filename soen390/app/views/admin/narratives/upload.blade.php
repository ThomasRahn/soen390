@extends('admin.master')

@section('view_title')
Upload Narrative(s)
@stop

@section('styles')
<style>
    .n-upload-form {
        margin-top: 20px;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        {{ Form::open(array('action' => 'ApiNarrativeController@store', 'class' => 'form-horizontal n-upload-form', 'files' => true)) }}
            <div class="form-group">
                {{ Form::label('archive', 'Archive File', array('class' => 'col-sm-3 control-label')) }}
                <div class="col-sm-9">
                    {{ Form::file('archive', array('class' => 'form-control', 'accept' => 'application/zip', 'required' => 'required')) }}
                    <span class="help-block"><small>{{ Lang::get('admin.narratives.upload.help.archive', array('limit' => ini_get('post_max_size'))) }}</small></span>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('category', 'Default Category', array('class' => 'col-sm-3 control-label')) }}
                <div class="col-sm-9">
                    {{ Form::select('category', $categoryArray, null, array('class' => 'form-control', 'required' => 'required')) }}
                    <span class="help-block"><small>{{ trans('admin.narratives.upload.help.category') }}</small></span>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('publish', 'Publish on Upload?', array('class' => 'col-sm-3 control-label')) }}
                <div class="col-sm-9">
                    <div class="checkbox">
                        {{ Form::checkbox('publish', '') }}
                    </div>
                    <span class="help-block"><small>{{ trans('admin.narratives.upload.help.publish') }}</small></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-default"><i class="fa fa-upload"></i> {{ trans('admin.narratives.upload.submit') }}</button>
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
@stop

@section('scripts')
<script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {

        $(".n-upload-form").submit(function(e) {
            e.preventDefault();
            alert("Form submit.");
        });

    });
</script>
@stop