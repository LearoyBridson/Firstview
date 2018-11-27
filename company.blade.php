<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Company Details</title>
		<link rel="stylesheet" href="/css/EditStyle.css" type="text/css" >
	</head>

	<body>
		@if (Auth::check())
		<aside>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="http://localhost:8000/logout"
				   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					Logout
				</a>

				<form id="logout-form" action="http://localhost:8000/logout" method="GET" style="display: none;">
					<input type="hidden" name="_token" value="43mNkFfQQT8jx9l99Os1rnwjlt36QPbOQ7qdy1TK">
				</form>
			</div>
		</aside>
		<div class="container">
			
				<a href="/" class="companiesList">Companies list</a>
				
				@if (isset($company->name))
				<section class="companyDetails">
					<br/>
					<br/>
					<form>
						<input type="hidden" id="companyID" value="{{$company->id}}" />
						<table>
							<tr>
								<td>
									<img src="{{url('/images/' . $company->logo)}}" width="100" height="100" alt="" id="originalLogo" />
								</td>
								<td><input type="file" name="logo" accept="Image/*" id="companyLogo" /></td>
								<td>
									<span id="logoMessage">
										@if (isset($errors) && $errors->has('logo'))
											{{ $errors->first('logo') }}
										@endif
									</span>
								</td>
							</tr>
							<tr>
								<td><h1 id="originalName">{{$company->name}}</h1></td>
								<td><input type="text" id="companyName" placeholder="Name"/></td>
								<td>
									<span id="nameMessage">
										@if (isset($errors) && $errors->has('name'))
											{{ $errors->first('name') }}
										@endif
									</span>
								</td>
							</tr>
							<tr>
								<td><h3 id="originalEmail">{{$company->email}}</h3></td>
								<td><input type="text" id="companyEmail" placeholder="Email"/></td>
								<td>
									<span id="emailMessage">
										@if (isset($errors) && $errors->has('website'))
											{{ $errors->first('website') }}
										@endif
									</span>
								</td>
							</tr>
							<tr>
								<td>
									<h3 id="originalWebsite">
										@if ($company->website != "")
											{{$company->website}}
										@endif
									</h3>
								</td>
								<td><input type="text" id="companyWebsite" placeholder="Website" /></td>
								<td>
									<span id="websiteMessage">
										@if (isset($errors) && $errors->has('website'))
											{{ $errors->first('website') }}
										@endif
									</span>
								</td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2">
									<input type="button" id="edit" value="Edit" />
									<input type="button" id="cancel" value="Cancel" />
									<input type="button" id="save" value="Save" />
								</td>
							</tr>
						</table>
					</form>
					<br/>
				</section>
				
				<section class="createAsset">
					<form method="POST" action="/company/{{ $company->id }}">
						{{ csrf_field() }}
						<table>
							<tr>
								<td>Description</td>
								<td>
									<textarea name="description" id="description"></textarea><br/>
									<span id="descriptionMessage">
										@if (isset($errors) && $errors->has('description'))
											{{ $errors->first('description') }}
										@endif
									</span>
								</td>
							</tr>
							<tr>
								<td>Model</td>
								<td>
									<input type="text" name="model" id="model"/><br/>
									<span id="modelMessage">
										@if (isset($errors) && $errors->has('model'))
											{{ $errors->first('model') }}
										@endif
									</span>
								</td>
							</tr>
							<tr>
								<td>Value</td>
								<td>
									<input type="text" name="value" id="value"/><br/>
									<span id="valueMessage">
										@if (isset($errors) && $errors->has('value'))
											{{ $errors->first('value') }}
										@endif
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="2"><input type="button" id="submitAsset" value="Add an asset" /></td>
							</tr>
						</table>
						<!--<hidden name="companyID" value="{{ $company->id }}" />-->
					</form>
					<div id="addedAsset">
						The asset has been added!
					</div>
				</section>
				
				<h2>Company Assets</h2>
				<br/>
				<table class="assetTable">
					<thead>
						<tr>
							<th>Description</th>
							<th>Model</th>
							<th>Value</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="tableBody">
						
					</tbody>
				</table>
				<br/>
				<div class="paginationButtons">
					<input type="button" id="left" value="<" />
					<input type="button" id="right" value=">" />
					<br/>
				</div>
				@endif
		</div>
		@else
			<h3>Please log in. <a href="/login">Click here to login</a></h3>
		@endif
	</body>
	
	<script src="/js/Pagination.js"></script>
	<script src="/js/CompanyDetails.js"></script>
	<script src="/js/EditCompany.js"></script>
	
</html>