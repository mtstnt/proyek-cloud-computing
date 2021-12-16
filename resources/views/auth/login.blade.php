@extends("template.app")

@section("body")

<div class="bg-gray">
    <!-- Login -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100 flex-sm-row flex-column">
        <!-- heading -->
		<div class="text-center d-block d-sm-none mb-3">
            <h1 class="text-success fw-bold fs-0">ShareIn</h1>
		</div>
        <div class="text-center text-lg-start col-4 d-none d-sm-block">
            <h1 class="text-success fw-bold fs-0">ShareIn</h1>
            <p class="w-75 mx-auto fs-5 mx-lg-0">Matthew Sutanto C14190085</p>
            <p class="w-75 mx-auto fs-5 mx-lg-0">Michael Kevin T C14190167</p>
            <p class="w-75 mx-auto fs-5 mx-lg-0">Krisna Lazarus Bei C14190226</p>
        </div>
        <!-- form card -->
        <div style="max-width: 28rem; width: 100%" class="mx-5">
			@include('template.notice')
            <div class="bg-white shadow rounded p-3 input-group-lg">
				<form action="{{ route('auth.login.store') }}" method="POST">
					@csrf
					<input type="text" class="form-control my-3 fs-6" placeholder="Username" name="username" required />
					<input type="password" class="form-control my-3 fs-6" placeholder="Password" name="password" required />
					<button type="submit" class="btn btn-success w-100">Log In</button>
				</form>
                <!-- create form -->
                <hr />
                <div class="text-center">
                    <button class="btn btn-success btn-lg fs-6" type="button" data-bs-toggle="modal"
                        data-bs-target="#createModal">Create New Account</button>
                </div>
                <!-- create modal -->
                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- head -->
                            <div class="modal-header">
                                <div>
                                    <h2 class="modal-title" id="exampleModalLabel">Sign Up</h2>
                                    <span class="text-muted fs-7">It's quick and easy.</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <!-- body -->
                            <div class="modal-body">
                                <form class="my-0" action="{{ route("auth.register.store") }}" method="POST">
									@csrf
                                    <!-- names -->
									<input type="text" class="form-control" placeholder="Username" name="username" required />
									<div class="row my-3">
										<div class="col-sm-6 col">
											<input type="password" class="form-control" name="password" id="password" placeholder="New password" required/>
										</div>
										<div class="col-sm-6 col">
											<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required/>
										</div>
									</div>
                                    <div class="text-center w-100">
                                        <button class="btn btn-success btn-lg w-100 fs-6"
                                            type="submit">Sign Up</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end -->
            </div>
        </div>
    </div>
</div>

@endsection