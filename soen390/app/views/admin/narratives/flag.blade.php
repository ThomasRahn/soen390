@extends('admin.master')

@section('view_title')
Flagged Narrative(s)
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
            <th>{{ trans('admin.narratives.table.narrativeName') }}</th>
            <th>{{ trans('admin.narratives.table.comment') }}</th>
	    <th>{{ trans('admin.narratives.table.manage') }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="7"><small><span class="row-count">0</span> {{ trans('admin.narratives.table.inTotal') }}</small></th>
        </tr>
    </tfoot>
    <tbody class="table-spinner">
        <tr class="active">
            <td colspan="7"><span><i class="fa fa-cog fa-spin"></i></span> {{ trans('admin.narratives.table.loading') }}</td>
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
            "{{ action('ApiFlagController@index') }}",
            function (data) {
                var rows = [];

                $.each(data, function(index, narrative) {
                    rows.push("<tr>"
                        + "<td>" + narrative.id + "</td>"
                        + "<td>" + narrative.name + "</td>"
			+ "<td>" + narrative.comment + "</td>"
			+ "<td><a class='glyphicon glyphicon-trash' href='#'></a> <a href='' class='' ></a></td>"
                        + "</tr>");
                });

                if (rows.length === 0)
                    rows.push("<tr><td colspan=\"7\"><span class=\"text-center\">{{ trans('admin.narratives.table.empty') }}</span></td></tr>");

                $(".table-spinner").remove();

                $("<tbody/>", {
                    html: rows.join("")
                }).appendTo(".narrative-table");

                $(".row-count").html(rows.length);
            });

    });
</script>

@stop
