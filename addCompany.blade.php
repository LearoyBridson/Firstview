@extends('layouts.app')

@section('content')
<div class="content">
	<div class="container">
		@if (Auth::check())
			<br/>
				<a href="/viewCompanies">Back to companies list</a>
			<br/><br/>
			<h3>Add a new company:</h3>
			<form method="POST" enctype="multipart/form-data" action="/company">
				{{ csrf_field() }}
				<div class="form-group">
					<div class="container">
						<input type="text" name="name" placeholder="Company name*">
						<br/><br/>
						<input type="text" name="email" placeholder="email" /><br/>
						<br/><br/>
						<label for="logo">Image should be greater then 100px for height and width</label>
						<br/><br/>
						<input type="file" name="logo" accept="Image/*" id="logo" /><br/>
						<br/><br/>
						<input type="text" name="website" placeholder="website" />
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" >Add Company</button>
				</div>
			</form>
			<br/>
		@else
			<h3>Please log in. <a href="/login">Click here to login</a></h3>
		@endif
	</div>
</div>
@endsection
