<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Company List</title>
		<link rel="stylesheet" href="/css/CompanyListStyle.css" type="text/css" >
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
			
			<br/>
			<a href="/addCompany" class="addCompany">Add a company</a>
			<input type="hidden" id="userID" value="{{Auth::user()->id}}" />
			<h2>Companies List</h2>
			<br/>
			<table class="table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Logo</th>
						<th>Website</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="tableBody">
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
			
			<br/>
			<div class="paginationButtons">
				<input type="button" id="left" value="<" />
				<input type="button" id="right" value=">" />
				<br/>
			</div>
		</div>
		@else
			<h3>Please log in. <a href="/login">Click here to login</a></h3>
		@endif
	</body>
	
	<script src="/js/Pagination.js"></script>
	<script src="/js/CompanyList.js"></script>
</html>