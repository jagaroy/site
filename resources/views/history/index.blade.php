@extends('layouts.app')
@section('content')
<div class="container-fluid app-body">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<h3>Histories

	</h3>
	<style type="text/css">
		form label {
			width: 20%;
		}
		form input {
			width: 20%;
		}
		form select {
			width: 20%;
		}
		.submit{
			display: none;
			/*width: 10%*/
		}
		.clear{
			width: 10%
		}
				
		
	</style>

	<div class="row">
		<div class="col-md-12">
			<?php
				// echo '<pre>'; print_r($histories->groupInfo); echo '</pre>';
			?>
			<form class="form-inline" action="" method="post" id="search">
				{{csrf_field()}}
				<input name="group_name" type="text" class="form-control" id="group_name">
				<label for="date">&nbsp;</label>
				<input name="date" type="date" class="form-control" id="date">
				<label for="group_type">&nbsp;</label>
				<select name="group_type" class="form-control" id="group_type" style="width: 20%">

				</select>

				<button type="submit" class="btn btn-primary submit" >Submit</button>
			</form> 
			<!-- <form class="form-inline" action="">
				<input name="clear" type="text" class="form-control clear" value="1" id="clear" >
			</form> -->

			<script type="text/javascript">
				$(document).ready(function() {
					$('#search').on('submit', function(event) {
						event.preventDefault();

						console.log("group_name:", $('#group_name').val());

						var data = $(this).serializeArray();
						console.log("data", data);
						$.ajax({
							url: '{{route('search-history')}}',
							type: 'POST',
							dataType: 'json',
							data: data,
						})
						.done(function(res) {
							if (res.res=='success') {
								location.reload();
							}
							console.log("success");
						})
						.fail(function(res) {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
						});
						

					});
				});
			</script>

			<table class="table table-hover social-accounts"> 
				<thead> 
					<tr><th>Group Name</th> <th>Group Type</th> <th>Account Name</th> <th>Post Text</th> <th>Time</th> </tr> 
				</thead>
				<tbody>

					@foreach ($histories as $history)
					<tr>
						<td>{{$history->group_name}}</td>
						<td>{{$history->group_type}}</td>
						<td>{{$history->account_name}}</td>
						<td>{{$history->buffer_postings_post_text}}</td>
						<td width="10%">{{$history->buffer_postings_updated_at}}</td>
					</tr>

					@endforeach

				</tbody> 
			</table>

			{{$histories->links()}}

		</div>
	</div>
</div>
@endsection
