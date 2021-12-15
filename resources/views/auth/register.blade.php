@extends("template.app")

@section("body")

<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
	<form action="{{ route('auth.register.store') }}" class="card p-5 col-11 col-sm-5 shadow" method="POST">
		<div class="card-body">
			<h1 class="fs-large mb-4 px-0">Create New Account <br> for {{ env('APP_NAME') }}</h1>
			<div class="row mb-3 mx-0">
				<label for="username" class="col-form-label px-0">Username</label>
				<input type="text" name="username" id="username" class="form-control">
			</div>
			<div class="row mb-3 mx-0">
				<label for="password" class="col-form-label px-0">Password</label>
				<input type="password" name="password" id="password" class="form-control">
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
				<label class="form-check-label" for="flexCheckDefault">
					Remember Me
				</label>
			</div>
			<div class="row mx-0">
				<button class="btn btn-primary w-100 mb-2">Create Account</button>
				<a href="{{ route('auth.login.index') }}" class="btn btn-secondary w-100">Log In</a>
			</div>
		</div>
	</form>
</div>

@endsection