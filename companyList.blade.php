@extends('layouts.app')

@section('content')
<div class="content">
	<div class="container">
		@if (Auth::check())
			<a href="/addCompany">Add a company</a>
			<br/>
		
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Logo</th>
						<th>Website</th>
					</tr>
				</thead>
				<tbody>
					@foreach($companies as $company)
					<tr>
						<td>
							<a href="{{url('/company/'. $company->id)}}">{{$company->name}}</a>
						</td>
						<td>
							{{$company->email}}
						</td>
						<td>
							{{$company->logo}}
						</td>
						<td>
							{{$company->website}}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{!! $companies->render() !!}
		@else
			<h3>Please log in. <a href="/login">Click here to login</a></h3>
		@endif
	</div>
</div>
@endsection
