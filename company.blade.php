@extends('layouts.app');
			
@section('content')
<div class="content">
	<div class="container">
		@if (Auth::check())
			<br/>
			<a href="/viewCompanies">Back to companies list</a>
			<br/><br/>
			
			<div class="row justify-content-center">
				<h1>{{$company->name}}</h1>
				<br/>
				<h3>{{$company->email}}</h3>
				<br/>
				<img src="{{url('/images/'.$company->logo)}}" alt=""/>
				<br/><br/>
				@if ($company->website != "")
					<h3><a href="{{$company->website}}">{{$company->website}}</a></h3>
				@endif
			</div>
			
			<br/><br/><br/>
			
			<div class="container">
				<h3>Add a new asset:</h3>
				<form method="POST" action="/company/{{ $company->id }}">
					{{ csrf_field() }}
					<div class="form-group">
						<textarea name="description" placeholder="Description*"></textarea>
						<br/><br/>
						<input type="text" name="model" placeholder="Model*" />
						<br/><br/>
						<input type="text" name="value" placeholder="Value*" />
						<br/><br/>
						<hidden name="companyID" value="{{ $company->id }}" />
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Add Asset</button>
					</div>
				</form>
			</div>
			
			<br/><br/>
			
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Description</th>
						<th>Model</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($assets as $asset)
					<tr>
						<td>
							{{ $asset->description }}
						</td>
						<td>
							{{ $asset->model }}
						</td>
						<td>
							R{{ $asset->value }}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			
		@else
			<h3>Please log in. <a href="/login">Click here to login</a></h3>
		@endif
	</div>
</div>
@endsection
