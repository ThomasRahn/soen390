@extends('admin.master')

@section('view_title')
@lang('admin.sidebar.topics')
@stop

@section('styles')
<style>
    th {
        font-weight: 400;
        cursor: pointer;
    }
</style>
@stop

@section('content')
<div id="action-alert" class="alert hide"></div>

<table class="table table-hover topics-table">
    <thead>
        <tr>
            <th>#</th>
            <th>@lang('admin.topic.index.table.code')</th>
            <th>@lang('admin.topic.index.table.description')</th>
            <th>@lang('admin.topic.index.table.narratives')</th>
            <th>@lang('admin.topic.index.table.published')</th>
            <th>@lang('admin.topic.index.table.manage')</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="6">
                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#add-topic-modal">
                    <i class="fa fa-fw fa-plus-circle"></i>
                    @lang('admin.topic.index.table.add')
                </button>
            </td>
        </tr>
    </tfoot>
    <tbody>
        @if (count($topics) === 0)
        <tr>
            <td colspan="6">@lang('admin.topic.index.table.empty')</td>
        </tr>
        @else
            @foreach ($topics as $t)
            <tr data-topic-id="{{ $t->id }}"{{ $t->published ? '' : ' class="warning"' }}>
                <td class="topic-id">{{{ $t->id }}}</td>
                <td class="topic-code"><code>{{{ $t->code }}}</code></td>
                <td class="topic-description">{{{ $t->description }}}</td>
                <td class="topic-narratives">{{{ $t->narratives }}}</td>
                <td class="topic-published">
                    <button class="btn btn-xs btn-default btn-publish" data-topic-id="{{ $t->id }}">
                        <i class="fa fa-fw fa-{{ ($t->published == true ? 'check-square-o' : 'square-o') }}"></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-xs btn-default btn-edit-topic" data-topic-id="{{ $t->id }}"><i class="fa fa-pencil"></i></button>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>

<div id="add-topic-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">@lang('admin.topic.index.addModal.title')</h4>
            </div>
            <div class="modal-body">
                <div id="add-topic-alert" class="alert hide"></div>

                <form id="add-topic-form" class="form-horizontal">
                    {{ Form::token() }}
                    <div class="form-group">
                        <label for="topic-code" class="col-sm-3 control-label">@lang('admin.topic.index.addModal.code')</label>
                        <div class="col-sm-4">
                            <input type="text" name="code" class="form-control" id="topic-code" placeholder="e.g. `oil-transport`" maxlength="255" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="topic-description-en" class="col-sm-3 control-label">@lang('admin.topic.index.addModal.descEn')</label>
                        <div class="col-sm-9">
                            <input type="text" name="descEn" class="form-control" id="topic-description-en" placeholder="e.g. `Pipelines vs. Rail`" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="topic-description-fr" class="col-sm-3 control-label">@lang('admin.topic.index.addModal.descFr')</label>
                        <div class="col-sm-9">
                            <input type="text" name="descFr" class="form-control" id="topic-description-fr" placeholder="e.g. `Pipelines contre Trains`" required>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary">@lang('admin.topic.index.addModal.addButton')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/tablesorter/2.13.3/js/jquery.tablesorter.min.js"></script>
<script>

    $(document).ready(function() {

        // Handle submission of add-topic-form
        $("#add-topic-form").submit(function(e) {
            e.preventDefault();

            $.post(
                "{{ action('AdminTopicController@postAdd') }}",
                $("#add-topic-form").serialize()
            ).done(function(data) {
                var topic = data.return;

                $(".topics-table > tbody:last").append(
                    "<tr data-topic-id=\"" + topic.id + "\" class=\"success\">"
                    + "<td class=\"topic-id\">" + topic.id + "</td>"
                    + "<td class=\"topic-code\"><code>" + topic.name + "</code></td>"
                    + "<td class=\"topic-description\">" + topic.description + "</td>"
                    + "<td class=\"topic-narratives\">" + topic.narrativeCount + "</td>"
                    + "<td class=\"topic-published\">"
                    + "<button class=\"btn btn-xs btn-default btn-publish\" data-topic-id=\"" + topic.id + "\">"
                    + "<i class=\"fa fa-fw fa-"
                    + (topic.published == true ? "check-square-o" : "square-o")
                    + "\"></i>"
                    + "</button></td>"
                    + "<td>"
                    + "<button type=\"button\" class=\"btn btn-xs btn-default btn-edit-topic\" data-topic-id=\"" + topic.id + "\"><i class=\"fa fa-pencil\"></i></button>"
                    + "</td>"
                    + "</tr>"
                );

                $("#add-topic-modal").modal("hide");
            }).fail(function(jqxhr, textStatus, errorThrown) {
                var returnObj  = JSON.parse(jqxhr.responseText),
                    returnText = returnObj.return;

                if (returnText.validator) {
                    returnText = JSON.stringify(returnText.validator);
                }

                $("#add-topic-alert").html(returnText);
                $("#add-topic-alert").addClass("alert-danger").removeClass("hide");
            });
        });

        // Handle publish toggling
        $(".btn-publish").click(function(e) {
            e.preventDefault();

            var topicID = $(this).data("topic-id");
            var row = $(this).parent().parent();

            $.ajax({
                type: "PUT",
                url: "/admin/topic/toggle-publish/" + topicID
            }).done(function(data) {
                console.log(data);

                var buttonIcon = $("tr[data-topic-id=" + topicID + "] .btn-publish i");

                if (data.return.published == "1") {
                    row.removeClass("warning");
                    buttonIcon.removeClass("fa-square-o fa-check-square-o").addClass("fa-check-square-o");
                } else {
                    row.addClass("warning");
                    buttonIcon.removeClass("fa-square-o fa-check-square-o").addClass("fa-square-o");
                }
            }).fail(function(jqxhr, textStatus, errorThrown) {
                
            });
        });

    });
</script>
@stop