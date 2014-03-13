@extends('admin.master')

@section('view_title')
Narratives
@stop

@section('styles')
<style>
    th {
        font-weight: 400;
        cursor: pointer;
    }
    .tablesorter-header.tablesorter-headerAsc {
        background-image: url('//cdn.jsdelivr.net/tablesorter/2.13.3/css/images/black-asc.gif');
        background-position: left center;
        background-repeat: no-repeat;
        font-style: italic;
    }
    .tablesorter-header.tablesorter-headerDesc {
        background-image: url('//cdn.jsdelivr.net/tablesorter/2.13.3/css/images/black-desc.gif');
        background-position: left center;
        background-repeat: no-repeat;
        font-style: italic;
    }
    .table-spinner td {
        text-align: center;
    }
    .table tr {
                transition: background-color 0.2s linear;
           -moz-transition: background-color 0.2s linear;
        -webkit-transition: background-color 0.2s linear;
    }
    td.category,
    td.published,
    td.flags {
        cursor: pointer;
    }
    .modal-dialog{
        width:700px;
    }
</style>
@stop

@section('content')
<div class="alert alert-info alert-dismissable fade in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <p class="lead">{{ trans('admin.narratives.tips.tip') }}</p>
    <p><small>{{ trans('admin.narratives.tips.updateNarrative') }}</small></p>
</div>

<table class="table narrative-table tablesorter">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('admin.narratives.table.name') }}</th>
            <th>{{ trans('admin.narratives.table.views') }}</th>
            <th>{{ trans('admin.narratives.table.comments') }}</th>
            <th>{{ trans('admin.narratives.table.category') }}</th>
            <th>{{ trans('admin.narratives.table.createdAt') }}</th>
            <th>{{ trans('admin.narratives.table.published') }}</th>
            <th>{{ trans('admin.narratives.table.flags') }}</th>
            <th>{{ trans('admin.narratives.table.manage') }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th colspan="9"><small><span class="row-count">0</span> {{ trans('admin.narratives.table.inTotal') }}</small></th>
        </tr>
    </tfoot>
    <tbody class="table-spinner">
        <tr class="active">
            <td colspan="9"><span><i class="fa fa-cog fa-spin"></i></span> {{ trans('admin.narratives.table.loading') }}</td>
        </tr>
    </tbody>
</table>

<div class="modal fade" id="comment-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Comments</h4>
      </div>
      <div class="modal-body">
            <table class="table comment-table tablesorter">
               <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('admin.comments.table.name') }}</th>
                        <th>Agrees</th>
                        <th>Disagrees</th>
                        <th>Comment</th>  
                        <th>{{ trans('admin.narratives.table.flags') }}</th>
                        <th>{{ trans('admin.narratives.table.manage') }}</th>
                    </tr>
                </thead>
                <tbody class="table-spinner">
                    <tr class="active">
                        <td colspan="9"><span><i class="fa fa-cog fa-spin"></i></span> {{ trans('admin.narratives.table.loading') }}</td>
                    </tr>
                </tbody>
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

@section('scripts')
<script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/tablesorter/2.13.3/js/jquery.tablesorter.min.js"></script>

<script>
    var editingRow = null;

    function togglePublished(narrativeID, currentStatus, narrativeRow) {
	var toggledStatus = false == currentStatus;

        console.log("Toggle publication status for narrative " + narrativeID + " from " + (currentStatus) + " to " + (toggledStatus));

        updateNarrative(narrativeID, { published : toggledStatus}, narrativeRow);
    }

    function handleCategoryChange(e, obj) {
        var select = $(obj),
            row    = select.parent().parent();
    	console.log(obj);

        console.log("Change category for " + row.data("narrative-id") + " to " + select.val());

        updateNarrative(row.data("narrative-id"), { category: select.val() }, row);
    }

    function updateNarrative(narrativeID, jsonData, narrativeRow) {
        $.ajax({
            type: "PUT",
            url: "/api/narrative/" + narrativeID,
            data: jsonData,
            success: function(data) {
                var narrative = data.return;

                // Highlight table row
                narrativeRow.css("background-color", "#dff0d8");

                // Update category value
                narrativeRow.children(".category").data("category", narrative.stance);
                narrativeRow.children(".category").html(narrative.stance);

                // Update publication status
                if (narrative.published == false) {
                    narrativeRow.addClass("warning");
                    narrativeRow.children(".published").html("<i class=\"fa fa-square-o fa-fw\"></i>");
                    narrativeRow.children(".published").data("published", false);
                } else {
                    narrativeRow.removeClass("warning");
                    narrativeRow.children(".published").html("<i class=\"fa fa-check-square-o fa-fw\"></i>");
                    narrativeRow.children(".published").data("published", true);
                }

                editingRow = null;

                setTimeout(function() {
                    narrativeRow.css("background-color", "");
                }, 200);

                console.log(narrative);
            },
            error: function(data) {
                narrativeRow.css("background-color", "#f2dede");

                alert("{{ trans('admin.narratives.update.error') }}");
                console.log(data);

                setTimeout(function() {
                    narrativeRow.css("background-color", "");
                }, 1250);
            },
            dataType: "json"
        });
    }

    function playNarrative(id) {
        var popupWidth = screen.width * 0.75, 
            popupHeight = screen.height * 0.75,
            left = (screen.width / 2) - (popupWidth / 2),
            top = (screen.height / 2) - (popupHeight / 2);

        window.open('/player/play/' + id, 'Listen to narrative', 'toolbar=no,location=no,width=' + popupWidth + ',height=' + popupHeight + ',left=' + left + ',top=' + top).focus();
    }

    function remove_narrative(id) {
        if(confirm("Are you sure you want to remove the entire narrative?")){
            $.ajax({//
                type:'DELETE',
                url:'/admin/narrative/narrative/'+id,
                success:function(data){//
                    $('[data-narrative-id = '+id+']').remove();
                }
            });
        }
    }

    function openFlagWindow(id) {
      var popupWidth = screen.width * 0.75, 
            popupHeight = screen.height * 0.75,
            left = (screen.width / 2) - (popupWidth / 2),
            top = (screen.height / 2) - (popupHeight / 2);

        window.open('/admin/narrative/flag/' + id, 'Listen to narrative', 'toolbar=no,location=no,width=' + popupWidth + ',height=' + popupHeight + ',left=' + left + ',top=' + top).focus();
    }
    function remove_comment(id) {
        if(confirm("Are you sure you want to remove the comment?")){
            $.ajax({//
                type:'DELETE',
                url:'/admin/narrative/comment/'+id,
                success:function(data){//
                    $('[data-comment-id = '+id+']').remove();
                }
            });
        }
    }
    function loadCommentModal(id){  
        var path = "{{ action('ApiCommentController@getNarrative') }}" +"/"+id;
        $(".comment-table tbody").empty();
        $.getJSON(path,function(data){
                //forloop for comments
                var rows = [];

                $.each(data['return'],function(index,comment){
                    rows.push("<tr data-comment-id=\"" + comment.comment_id + "\">"
                            + "<td>" + comment.comment_id + "</td>"
                            + "<td>" + comment.name + "</td>"
                            + "<td>" + comment.agrees + "</td>"
                            + "<td>" + comment.disagrees + "</td>"
                            + "<td>" + comment.body + "</td>"
                            + "<td><a href=\"#\">" + comment.report_count + "</a></td>"
                            + "<td><button type=\"button\" class=\"btn btn-default\" onclick=\"remove_comment("+ comment.comment_id+")\"><i class=\"fa fa-trash-o fa-fw\"></i></button></td>"
                            + "</tr>");
                });
            $("<tbody/>", {
                html: rows.join("")
            }).appendTo(".comment-table");

        });

        $("#comment-modal").modal("show");
    }
    $.tablesorter.addParser({
        id:     'publishedSort',
        is:     function(s) { return false; },
        format: function(s, table, cell, cellIndex) {
                    return $(cell).attr("data-published");
                },
        type:   'text'
    });

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
                        + "<td class=\"comments\"><a href=\"#\" onclick=\"loadCommentModal("+ narrative.id +")\"data-toggle=\"modal\" data-target=\"#comment-modal\">" + narrative.comments + "</a></td>"
                        + "<td class=\"category\" data-category=\"" + narrative.stance + "\">" + narrative.stance + "</td>"
                        + "<td class=\"createdAt\">" + narrative.createdAt + "</td>"
                        + "<td class=\"published\" data-published=\"" + narrative.published + "\"><i class=\"fa " + (narrative.published == false ? "fa-square-o" : "fa-check-square-o") + " fa-fw\"></i></td>"
                        + "<td> <a href=\"#\" onclick=\"openFlagWindow(" + narrative.id+")\">" + narrative.flags +"</a></td>"
                        + "<td>"
                        + "<div class=\"btn-group btn-group-xs\">"
                        + "<button type=\"button\" class=\"btn btn-default\" onclick=\"playNarrative("+ narrative.id+")\"><i class=\"fa fa-play fa-fw\"></i></button>"
                        + "<button type=\"button\" class=\"btn btn-default\" onclick=\"remove_narrative("+ narrative.id+")\"><i class=\"fa fa-trash-o fa-fw\"></i></button>"
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

                $(".narrative-table").tablesorter({
                    headers: {
                        6: { sorter: "publishedSort" }
                    }
                });
            }
        );

        // Handle clicking published column.
        $(document).on("click", ".narrative-table td.published", function(e) {
            var column = $(this);

            // Retrieve the row details.
            var narrativeID   = column.parent().data("narrative-id"),
                currentStatus = column.data("published");

            togglePublished(narrativeID, currentStatus, column.parent());
        });

        // Handle clicking on category column.
        $(document).on("click", ".narrative-table td.category", function(e) {
             var column = $(this);

             if (editingRow === null) {
                // Set the working row
                editingRow = column.parent();

                // Fetch available categories
                $.getJSON("{{ action('ApiCategoryController@index') }}").done(function(data) {
                    var select = "<select class=\"category-edit-select\">";

                    $.each(data.return, function(i, e) {
                        var currentCategory = column.data("category") == e.Description;
                        select += "<option value=\"" + e.CategoryID + "\"" + (currentCategory ? " selected=\"selected\"" : "") + ">" + e.Description + "</option>";
                    });

                    select += "</select>";

                    column.html(select);

                    $(".category-edit-select").focus();
                });
             }

        });

        // Handle change event on category selection.
        $(document).on("change", ".narrative-table td.category select", function(e) { handleCategoryChange(e, this); });
        $(document).on("blur", ".narrative-table td.category select", function(e) { handleCategoryChange(e, this); });

    });
</script>
@stop
