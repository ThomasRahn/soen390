@extends('admin.master')

@section('view_title')
Narratives
@stop

@section('styles')
<style>
    th {
        font-weight: 400;
    }
    .table-spinner td {
        text-align: center;
    }
</style>
@stop

@section('content')
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" arai-hidden="true">&times;</button>
    <p class="lead">{{ trans('admin.narratives.tips.tip') }}</p>
    <p><small>{{ trans('admin.narratives.tips.togglePublication') }}</small></p>
</div>

<table class="table narrative-table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('admin.narratives.table.name') }}</th>
            <th>{{ trans('admin.narratives.table.views') }}</th>
            <th>{{ trans('admin.narratives.table.comments') }}</th>
            <th>{{ trans('admin.narratives.table.category') }}</th>
            <th>{{ trans('admin.narratives.table.createdAt') }}</th>
            <th>{{ trans('admin.narratives.table.published') }}</th>
            <th>{{ trans('admin.narratives.table.manage') }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="8"><small><span class="row-count">0</span> {{ trans('admin.narratives.table.inTotal') }}</small></th>
        </tr>
    </tfoot>
    <tbody class="table-spinner">
        <tr class="active">
            <td colspan="8"><span><i class="fa fa-cog fa-spin"></i></span> {{ trans('admin.narratives.table.loading') }}</td>
        </tr>
    </tbody>
</table>
@stop

@section('scripts')
<script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>

<script>
    function togglePublished(narrativeID, currentStatus, narrativeRow) {
	var toggledStatus = false == currentStatus;

        console.log("Toggle publication status for narrative " + narrativeID + " from " + (currentStatus) + " to " + (toggledStatus));

        $.ajax({
            type: "PUT",
            url: "/api/narrative/" + narrativeID,
            data: { published: toggledStatus },
            success: function(data) {
                var narrative = data.return;

                if (narrative.Published == false) {
                    narrativeRow.addClass("warning");
                    narrativeRow.children(".published").html("<i class=\"fa fa-eye-slash fa-fw\"></i>");
                    narrativeRow.children(".published").data("published", false);
                } else {
                    narrativeRow.removeClass("warning");
                    narrativeRow.children(".published").html("<i class=\"fa fa-eye fa-fw\"></i>");
                    narrativeRow.children(".published").data("published", true);
                }

                console.log(narrative);
            },
            error: function(data) {
                alert("{{ trans('admin.narratives.update.error') }}");
		console.log(data);
            },
            dataType: "json"
        });
    }

    $(document).ready(function () {

        // Fetch the narratives from the API and display them.
        var narratives = $.getJSON(
            "{{ action('ApiNarrativeController@index', array('withUnpublished' => 1)) }}",
            function (data) {
                var rows = [];

                $.each(data['return'], function(index, narrative) {
                    rows.push("<tr" + (narrative.published == false ? " class=\"warning\"" : "") + " data-narrative-id=\"" + narrative.id + "\">"
                        + "<td class=\"id\">" + narrative.id + "</td>"
                        + "<td class=\"name\">" + narrative.name + "</td>"
                        + "<td class=\"views\">" + narrative.views + "</td>"
                        + "<td class=\"comments\">" + 0 + "</td>"
                        + "<td class=\"category\">" + narrative.stance + "</td>"
                        + "<td class=\"createdAt\">" + narrative.createdAt + "</td>"
                        + "<td class=\"published\" data-published=\"" + narrative.published + "\"><i class=\"fa fa-eye" + (narrative.published == false ? "-slash" : "") + " fa-fw\"></i></td>"
                        + "<td>"
                        + "<div class=\"btn-group btn-group-xs\">"
                        + "<button type=\"button\" class=\"btn btn-default\"><i class=\"fa fa-pencil fa-fw\"></i></button>"
                        + "<button type=\"button\" class=\"btn btn-default\"><i class=\"fa fa-trash-o fa-fw\"></i></button>"
                        + "<button type=\"button\" class=\"btn btn-default\"><i class=\"fa fa-play fa-fw\"></i></button>"
                        + "</td>"
                        + "</tr>");
                });

                if (rows.length === 0)
                    rows.push("<tr><td colspan=\"8\"><span class=\"text-center\">{{ trans('admin.narratives.table.empty') }}</span></td></tr>");

                $(".table-spinner").remove();

                $("<tbody/>", {
                    html: rows.join("")
                }).appendTo(".narrative-table");

                $(".row-count").html(data['return'].length);
            }
        );

        // Handle clicking on table rows.
        $(document).on("click", ".narrative-table td", function(e) {
            var column = $(this);

            // Check to see if this is the published column.
            if (column.hasClass("published")) {
                // Retrieve the row details.
                var narrativeID   = column.parent().data("narrative-id"),
                    currentStatus = column.data("published");

                togglePublished(narrativeID, currentStatus, column.parent());
            }
        });

    });
</script>
@stop
