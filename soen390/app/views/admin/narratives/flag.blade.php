@extends('admin.narratives.flagMaster')

@section('view_title')
Flagged Narrative(s)
@stop

@section('content')
<div class="message">
</div>
<table class="table narrative-table table-hover flag-table">
    <thead>
        <tr>
            <th style="width:100px;">#</th>
            <th style="width:150px;">{{ trans('admin.narratives.table.narrativeName') }}</th>
            <th style="width:750px;">{{ trans('admin.narratives.table.comment') }}</th>
	        <th style="width:100px;">{{ trans('admin.narratives.table.manage') }}</th>
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
            "{{ action('ApiFlagController@index', array('NarrativeID' => $NarrativeID )) }}",
            function (data) {
                var rows = [];

                $.each(data, function(index, narrative) {
                    rows.push("<tr class='flag' id='"+ narrative.id + "' data-NarrativeID='"+narrative.narrativeID+"'>"
                        + "<td>" + narrative.id + "</td>"
                        + "<td>" + narrative.name + "</td>"
		              	+ "<td>" + narrative.comment + "</td>"
                        + "<td>"
                        + "<div class=\"btn-group btn-group-xs\">"
                        + "<button type=\"button\" class=\"btn btn-default\" onclick=\"remove_flag("+ narrative.id+")\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Remove Flag\"><i class=\"fa fa-times fa-fw\"></i></button>"
                        + "</td></tr>");
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
            url:'/admin/narrative/flag/'+id,
            success:function(data){//
                $("tr#"+id).remove();
                if($(".flag").length == 0){
                   alert("There are no more reports for this narrative. Window closing....");
                   window.close();
                }
            }
        });
    }
       function remove_narrative(id){//
        if(confirm("Are you sure you want to remove the entire narrative?")){
            $.ajax({//
                type:'DELETE',
                url:'/admin/narrative/narrative/'+id,
                success:function(data){//
                    window.close();
                }
            });
        }
    }
</script>

@stop
