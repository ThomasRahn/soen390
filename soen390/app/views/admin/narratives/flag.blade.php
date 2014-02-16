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
<div class="message">
</div>
<table class="table narrative-table table-hover flag-table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('admin.narratives.table.narrativeName') }}</th>
            <th>{{ trans('admin.narratives.table.comment') }}</th>
	        <th>{{ trans('admin.narratives.table.manage') }}</th>
        </tr>
    </thead>
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
                    rows.push("<tr class='flag' id='"+ narrative.id + "' data-NarrativeID='"+narrative.narrativeID+"'>"
                        + "<td>" + narrative.id + "</td>"
                        + "<td>" + narrative.name + "</td>"
		              	+ "<td>" + narrative.comment + "</td>"
		              	+ "<td><a class='glyphicon glyphicon-trash' href='#' data-toggle='tooltip' data-placement='bottom' title='Remove Narrative' onclick='remove_narrative("+ narrative.narrativeID+")'></a>"
                        + " <a href='#' onclick='play_narrative("+ narrative.narrativeID +")'class='glyphicon glyphicon-play' data-toggle='tooltip' data-placement='bottom' title='Play Narrative'></a>"
                        + " <a class='glyphicon glyphicon-remove' href='#' data-toggle='tooltip' data-placement='bottom' title='Remove Flag' onclick='remove_flag("+ narrative.id+")'></a></td>"
                        + "</tr>");
                });

                if(rows.length == 0){
                    $(".message").html("There are currently no reported narratives");
                    $(".flag-table").remove();
                }

                $(".table-spinner").remove();

                $("<tbody/>", {
                    html: rows.join("")
                }).appendTo(".narrative-table");

            });
       
    });
    function play_narrative(id){//
        var popupWidth = screen.width * 0.75, 
            popupHeight = screen.height * 0.75,
            left = (screen.width / 2) - (popupWidth / 2),
            top = (screen.height / 2) - (popupHeight / 2);

        window.open('/narrative/' + id, 'Listen to narrative', 'toolbar=no,location=no,width=' + popupWidth + ',height=' + popupHeight + ',left=' + left + ',top=' + top).focus();
    }
    function remove_flag(id){//
        $.ajax({//
            type:'DELETE',
            url:'flag/'+id,
            success:function(data){//
                $("tr#"+id).remove();
                if($(".flag").length == 0){
                    $(".flag-table").remove();
                    $(".message").html("There are currently no reported narratives");
                }
            }
        });
    }
       function remove_narrative(id){//
        $.ajax({//
            type:'DELETE',
            url:'narrative/'+id,
            success:function(data){//
               $("[data-NarrativeID="+id+"]").remove();
                if($(".flag").length == 0){
                    $(".flag-table").remove();
                    $(".message").html("There are currently no reported narratives");
                }
            }
        });
    }
</script>

@stop
