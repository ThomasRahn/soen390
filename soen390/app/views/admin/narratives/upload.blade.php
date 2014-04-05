@extends('admin.master')

@section('view_title')
{{ trans('admin.sidebar.uploadNarratives') }}
@stop

@section('styles')
<style>
    .n-upload-form {
        margin-top: 20px;
    }
    .modal-body {
        padding-top: 50px;
    }
    .progress-bar {
        font-family: "Roboto Condensed", "Arial Narrow", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: 300;
    }
</style>
@stop

@section('content')
<div id="uploadProgressModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="progress">
                            <div class="progress-bar upload-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <p class="text-center"><span class="lead">{{ trans('admin.narratives.upload.uploading.pleaseWait') }}</span><br><small class="text-muted">{{ trans('admin.narratives.upload.uploading.mayTakeAWhile') }}</small></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel-upload-button" class="btn btn-danger"><i class="fa fa-minus-circle fa-fw"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="uploadCompletedModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply"></i> {{ trans('admin.narratives.upload.close') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        {{ Form::open(array('action' => 'ApiNarrativeController@store', 'class' => 'form-horizontal n-upload-form', 'files' => true)) }}
            <div class="form-group">
                {{ Form::label('archive', trans('admin.narratives.upload.form.archive'), array('class' => 'col-sm-3 control-label')) }}
                <div class="col-sm-9">
                    {{ Form::file('archive', array('class' => 'form-control', 'accept' => 'application/zip', 'required' => 'required')) }}
                    <span class="help-block"><small>{{ Lang::get('admin.narratives.upload.help.archive', array('limit' => ini_get('post_max_size'))) }}</small></span>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('category', trans('admin.narratives.upload.form.category'), array('class' => 'col-sm-3 control-label')) }}
                <div class="col-sm-9">
                    {{ Form::select('category', $categoryArray, null, array('class' => 'form-control', 'required' => 'required')) }}
                    <span class="help-block"><small>{{ trans('admin.narratives.upload.help.category') }}</small></span>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('topic', trans('admin.narratives.upload.form.topic'), array('class' => 'col-sm-3 control-label')) }}
                <div class="col-sm-9">
                    {{ Form::select('topic', $topicArray, null, array('class' => 'form-control', 'required' => 'required')) }}
                    <span class="help-block"><small>{{ trans('admin.narratives.upload.help.topic') }}</small></span>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('publish', trans('admin.narratives.upload.form.publish'), array('class' => 'col-sm-3 control-label')) }}
                <div class="col-sm-9">
                    <div class="checkbox">
                        {{ Form::checkbox('publish', 'publish') }}
                    </div>
                    <span class="help-block"><small>{{ trans('admin.narratives.upload.help.publish') }}</small></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-default">{{ trans('admin.narratives.upload.submit') }}</button>
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
    var xhr = null, uploadCancelled = false;

    function uploadProgressHandler(e) {
        if (! e.lengthComputable) return;

        var loaded          = e.loaded,
            total           = e.total,
            percentComplete = parseInt((loaded / total) * 100),
            cssWidth        = percentComplete + "%";

        if (percentComplete > 89) {
            $("#cancel-upload-button").attr("disabled", "disabled");
        }

        $(".upload-progress-bar").css("width", cssWidth);
        $(".upload-progress-bar").html(cssWidth);
    }

    $(document).ready(function() {

        $("#cancel-upload-button").click(function(e){
            e.preventDefault();

            uploadCancelled = true;

            xhr.abort();

            $("#uploadProgressModal").modal("hide");
        });

        $(".n-upload-form").submit(function(e) {
            e.preventDefault();
            var form = $(".n-upload-form");

            $("#uploadProgressModal").modal({
                backdrop: "static",
                keyboard: false
            });

            var formData = new FormData(form[0]);

            xhr = $.ajax({
                type: "POST",
                url: "/api/narrative",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                xhr: function() {
                    myXhr = $.ajaxSettings.xhr();

                    if (myXhr.upload) myXhr.upload.addEventListener('progress', uploadProgressHandler, false);

                    return myXhr;
                }
            }).done(function(data, status, xhr) {
                $("#uploadCompletedModal .modal-body").html(
                    "<p class=\"text-center text-success\"><i class=\"fa fa-thumbs-o-up fa-fw fa-3x\"></i></p>" +
                    "<p class=\"text-center\"><span class=\"lead\">{{ trans('admin.narratives.upload.uploaded.success') }}</span><br><small>{{ trans('admin.narratives.upload.uploaded.successQueued') }}</small></p>"
                );

                ($(".n-upload-form")[0]).reset();

                $("#uploadProgressModal").modal("hide");
                $("#uploadCompletedModal").modal("show");
            }).fail(function(xhr, status, error) {
                if (uploadCancelled === true) {
                    uploadCancelled = false;
                    return;
                }

                $("#uploadCompletedModal .modal-body").html(
                    "<p class=\"text-center text-danger\"><i class=\"fa fa-thumbs-o-down fa-fw fa-3x\"></i></p>" +
                    "<p class=\"text-center\"><span class=\"lead\">{{ trans('admin.narratives.upload.uploaded.failed') }}</span><br><small>{{ trans('admin.narratives.upload.uploaded.failedSorry') }}</small></p>" +
                    "<pre>" + xhr.statusCode() + "<br>" + xhr.status + "<br>" + xhr.responseText + "</pre>"
                );

                $("#uploadProgressModal").modal("hide");
                $("#uploadCompletedModal").modal("show");
            });
        });

    });
</script>
@stop
