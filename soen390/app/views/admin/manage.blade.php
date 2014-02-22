@extends('master')

@section('content')

<header>
        <div class="container">
                <h3><a href="#" class="muted pull-left">TalkTank</a></h3>
                <a href="/logout" class="pull-right">Logout</a>
                <div class="clear"></div>
        </div>
</header>
<div class="container">
        <div class="row">
          <div class="options span2">
              <ul class="nav nav-pills nav-stacked">
                <li><a class="glyphicon glyphicon-home" href="/admin"> Home</a></li>
                <li class="active"><a href="#" class="glyphicon glyphicon-list"> Narratives</a></li>
                <li><a href="/admin/upload" class="glyphicon glyphicon-upload"> Upload</a></li>
                <li><a href="#" class="glyphicon glyphicon-cog"> Configurations</a></li>
                <li><a href="#" class="glyphicon glyphicon-ban-circle"> Reported</a></li>
              </ul>
      	  </div>
	  <div class="span8">
		<table class="table table-hover">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Total Views</th>
				<th>Actions</th>
			</thead>
			<tbody>
				@foreach ($narratives as $narrative)
					<tr>
						<td>{{ $narrative->NarrativeID }}</td>
						<td>{{ $narrative->Name }}</td>
						<td>{{ $narrative->Views }}</td>
						<td> <a href="" class="glyphicon glyphicon-trash"></a>  <a href="" class="glyphicon glyphicon-pencil"></a></td>
					</tr>
				@endforeach				
			</tbody>
		</table>

	  </div>
	</div>
</div>
@stop
