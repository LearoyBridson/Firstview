<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Add company</title>
		<link rel="stylesheet" href="/css/Style.css" type="text/css" >
	</head>

	<body>
		<div class="container">
			@if (Auth::check())
				<br/>
				<a href="/" class="companiesList">Companies list</a>
				
				
				<h2>Company details</h2>
				<br/>
				<form method="POST" enctype="multipart/form-data" action="/company">
					{{ csrf_field() }}
					<table id="inputsTable">
						<tr>
							<td>Company name *:</td>
							<td>
								<input type="text" name="name" id="companyName" /><br/>
								<span id="nameMessage">
									@if (isset($errors) && $errors->has('name'))
										{{ $errors->first('name') }}
									@endif
								</span>
							</td>
						</tr>
						<tr>
							<td>Company email:</td>
							<td>
								<input type="text" name="email" id="companyEmail" /><br/>
								<span id="emailMessage">
									@if (isset($errors) && $errors->has('email'))
										{{ $errors->first('email') }}
									@endif
								</span>
							</td>
						</tr>
						<tr>
							<td>Company logo:</td>
							<td>
								<input type="file" name="logo" accept="Image/*" id="companyLogo" /><br/>
								<span id="logoMessage">
									@if (isset($errors) && $errors->has('logo'))
										{{ $errors->first('logo') }}
									@else
										<text>Minimum size 100 x 100 pixels.</text>
									@endif
								</span>
							</td>
						</tr>
						<tr>
							<td>Company website:</td>
							<td>
								<input type="text" name="website" id="companyWebsite" /><br/>
								<span id="websiteMessage">
									@if (isset($errors) && $errors->has('website'))
										{{ $errors->first('website') }}
									@endif
								</span>
							</td>
						</tr>
					</table>
					<br/>
					<br/>
					
					<button type="submit" class="btn btn-primary" id="submit">Add company</button>
					<input type="button" id="submitButton" value="Add Company" />
				</form>
				<br/>
				<br/>
				<div id="successMessage">
					@if (isset($success) && $success != false) 
						{{ $success }} <a href="/company/{{ $companyID }}">here</a>
					@endif
				</div>
			@else
				<h3>Please log in. <a href="/login">Click here to login</a></h3>
			@endif
		</div>
	</body>
	<script src="/js/CompanyDetails.js"></script>
	<script src="/js/CreateCompany.js"></script>
</html>