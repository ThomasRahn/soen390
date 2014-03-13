@extends('admin.master')

@section('view_title')
Narratives
@stop

@section('content')


<table class="table comment-table tablesorter">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Agrees</th>
            <th>Disagrees</th>
            <th>Comment</th>
            <th>Reports</th>
            <th>Manage</th>
        </tr>
    </thead>
    <tbody class="table-spinner">
        <tr class="active">
            <td colspan="9"><span><i class="fa fa-cog fa-spin"></i></span> {{ trans('admin.narratives.table.loading') }}</td>
        </tr>
    </tbody>
</table>

@section('scripts')
<script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/tablesorter/2.13.3/js/jquery.tablesorter.min.js"></script>

<script type="text/javascript">
  $(document).ready(function () {
  	   var path = "{{ action('ApiCommentController@getNarrative', array('NarrativeID'=> $NarrativeID)) }}";
        $(".comment-table tbody").empty();
        $.getJSON(path,function(data){
                //forloop for comments
                var rows = [];

                $.each(data['return'],function(index,comment){
                    rows.push("<tr>"
                            + "<td>" + comment.comment_id + "</td>"
                            + "<td>" + comment.name + "</td>"
                            + "<td>" + comment.agrees + "</td>"
                            + "<td>" + comment.disagrees + "</td>"
                            + "<td>" + comment.body + "</td>"
                            + "<td><a href=\"#\">" + comment.report_count + "</a></td>"
                            + "</tr>");
                });
            $("<tbody/>", {
                html: rows.join("")
            }).appendTo(".comment-table");

        });
  });
</script>

@stop <!-- stop scripts-->
@stop <!-- stop Content-->

@stop<!-- stop extends-->
