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
<table class="table narrative-table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('admin.narratives.table.name') }}</th>
            <th>{{ trans('admin.narratives.table.views') }}</th>
            <th>{{ trans('admin.narratives.table.comments') }}</th>
            <th>{{ trans('admin.narratives.table.category') }}</th>
            <th>{{ trans('admin.narratives.table.uploadedOn') }}</th>
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
    $(document).ready(function () {

        var narratives = $.getJSON(
            "{{ action('ApiNarrativeController@index', array('withUnpublished' => 1)) }}",
            function (data) {
                var rows = [];

                $.each(data['return'], function(index, narrative) {
                    rows.push("<tr" + (narrative.published == false ? " class=\"warning\"" : "") + ">"
                        + "<td>" + narrative.id + "</td>"
                        + "<td>" + narrative.name + "</td>"
                        + "<td>" + narrative.views + "</td>"
                        + "<td>" + 0 + "</td>"
                        + "<td>" + narrative.stance + "</td>"
                        + "<td>" + narrative.createdAt + "</td>"
                        + "<td><i class=\"fa fa-eye" + (narrative.published == false ? "-slash" : "") + " fa-fw\"></i></td>"
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
            });

    });
</script>
@stop
