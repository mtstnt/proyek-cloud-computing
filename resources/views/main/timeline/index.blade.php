@extends("template.app")

@section("body")
<div class="bg-gray postion-relative min-vh-100">
	<!-- ================= Appbar ================= -->
	<div class="bg-white d-flex align-items-center fixed-top shadow" style="min-height: 56px; z-index: 5">
		<div class="container-fluid">
			<div class="row align-items-center">
				<!-- search -->
				<div class="col d-flex align-items-center">
					<!-- search bar -->
					<h2 class="text-success fw-bold">ShareIn</h2>
				</div>
				<!-- nav -->
				<div class="col d-none d-xl-flex justify-content-center">
					<!-- home -->
					<div class="mx-4 nav__btn nav__btn-active">
						<button type="button" class="btn px-4">
							<i class="fas fa-home text-muted fs-4"></i>
						</button>
					</div>
				</div>
				<!-- menus -->
				<div class="col d-flex align-items-center justify-content-end">
					<!-- avatar -->
					<div class="align-items-center justify-content-center d-none d-xl-flex">
						<img src="https://source.unsplash.com/collection/happy-people" class="rounded-circle me-2" alt="avatar" style="width: 38px; height: 38px; object-fit: cover" />
						<p class="m-0">{{ Auth::user()->username }}</p>
					</div>

					<!-- secondary menu -->
					<div class=" rounded-circle p-1 bg-gray d-flex align-items-center justify-content-center mx-2
				" style="width: 38px; height: 38px" type="button" id="secondMenu" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
						<i class="fas fa-caret-down"></i>
					</div>
					<!-- secondary menu dd -->
					<ul class="dropdown-menu border-0 shadow p-3" aria-labelledby="secondMenu" style="width: 23em">
						<!-- avatar -->
						<li class="dropdown-item p-1 rounded d-flex" type="button">
							<img src="https://source.unsplash.com/collection/happy-people" alt="avatar" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover" />
							<div>
								<p class="m-0">Michael Kevin</p>
							</div>
						</li>
						<hr />
						<!-- options -->
						<li class="dropdown-item p-1 my-3 rounded" type="button">
							<ul class="navbar-nav">
								<li class="nav-item">
									<a href="./index.html" class="d-flex text-decoration-none text-dark">
										<i class="fas fa-cog bg-gray p-2 rounded-circle"></i>
										<div class="
							ms-3
							d-flex
							justify-content-between
							align-items-center
							w-100
						  ">
											<p class="m-0">Log Out</p>
										</div>
									</a>
								</li>
							</ul>
						</li>
					</ul>
					<!-- end -->
				</div>
			</div>
		</div>
	</div>

	<!-- ================= Main ================= -->
	<div class="container-fluid">
		<div class="row justify-content-evenly">
			<div class="col-12 col-lg-6 pb-5">
				<div class="d-flex flex-column justify-content-center w-100 mx-auto" style="padding-top: 56px; max-width: 680px">

					@include("template.notice")
					<div id="show-uploading" class="alert alert-success mt-3 shadow" style="display: none;">One of your content is still uploading! Please wait...</div>

					<div class="bg-white p-3 mt-3 rounded border shadow">
						<!-- avatar -->
						<div class="d-flex" type="button">
							<div class="p-1">
								<img src="https://source.unsplash.com/collection/happy-people" alt="avatar" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
							</div>
							<button id="upload-button" class="form-control text-start rounded-pill px-4 border-0 bg-gray pointer" data-bs-toggle="modal" data-bs-target="#createModal">What's happening?</button>
						</div>
						<!-- create modal -->
						<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="false">
							<div class="modal-dialog modal-dialog-centered">
								<form class="modal-content" action="{{ route('main.upload.store') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<!-- head -->
									<div class="modal-header align-items-center">
										<h5 class="text-dark text-center w-100 m-0" id="exampleModalLabel">
											Create Post
										</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<!-- body -->
									<div class="modal-body">
										<div class="p-1">
											<div class="d-flex flex-column">
												<!-- text -->
												<textarea cols="30" rows="5" class="form-control bg-gray border-0 mb-3" name="caption" placeholder="Tell a story.."></textarea>
												<!-- options -->
												<input type="file" class="form-control" name="upload">
											</div>
										</div>
										<!-- end -->
									</div>
									<!-- footer -->
									<div class="modal-footer">
										<button type="submit" class="btn btn-success w-100">Post
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div id="cards">
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<template id="card-tmpl">

	<div class="bg-white p-4 rounded shadow mt-3">
		<!-- author -->
		<div class="d-flex justify-content-between">
			<!-- avatar -->
			<div class="d-flex">
				<img src="https://source.unsplash.com/collection/happy-people" alt="avatar" class="avatar rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover" />
				<div>
					<p class="m-0 fw-bold user">Michael Kevin</p>
					<span class="text-muted fs-7 date">July 17 at 1:23 pm</span>
				</div>
			</div>
			<!-- edit -->
			<i class="fas fa-ellipsis-h" type="button" id="post1Menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
			<!-- edit menu -->
			<ul class="dropdown-menu border-0 shadow" aria-labelledby="post1Menu">
				<li class="d-flex align-items-center">
					<a class=" dropdown-item d-flex justify-content-around align-items-center fs-7" href="#">
						Delete Post</a>
				</li>
			</ul>
		</div>
		<!-- post content -->
		<div class="mt-3">
			<!-- content -->
			<div>
				<p class="caption">
					Lorem ipsum, dolor sit amet consectetur adipisicing elit.
					Quae fuga incidunt consequatur tenetur doloremque officia
					corrupti provident tempore vitae labore?
				</p>
				<video src="" class="img-fluid rounded video d-none"></video>
				<img src="https://source.unsplash.com/random/12" alt="post image" class="img-fluid rounded image d-none" />
			</div>
			<!-- likes & comments -->
			<div class="post__comment mt-3 position-relative">
				<!-- likes -->
				<div class=" d-flex align-items-center top-0 start-0 position-absolute" style="height: 50px; z-index: 5">
					<div class="me-2">
						<i class="text-success fas fa-thumbs-up"></i>
						<i class="text-danger fab fa-gratipay"></i>
						<i class="text-warning fas fa-grin-squint"></i>
					</div>
					<p class="m-0 text-muted fs-7">Phu, Tuan, and 3 others</p>
				</div>
				<!-- comments start-->
				<div class="accordion" id="accordionExample">
					<div class="accordion-item border-0">
						<!-- comment collapse -->
						<h2 class="accordion-header" id="headingTwo">
							<div class=" accordion-button collapsed pointer d-flex justify-content-end" data-bs-toggle="collapse" data-bs-target="#collapsePost1" aria-expanded="false" aria-controls="collapsePost1">
							</div>
						</h2>
						<hr />
						<!-- comment & like bar -->
						<div class="d-flex justify-content-around">
							<div class="dropdown-item rounded d-flex justify-content-center align-items-center pointer text-muted p-1">
								<i class="fas fa-thumbs-up me-3"></i>
								<p class="m-0">Like</p>
							</div>
						</div>
					</div>
					<!-- end -->
				</div>
			</div>
		</div>
	</div>

</template>

<style>
	.refresh {
		position: fixed;
		right: 0;
		bottom: 0;
	}
</style>
<button class="refresh btn btn-success text-white rounded-circle m-4" style="aspect-ratio: 1 / 1; width: 60px" onclick="loadPosts">
	<i class="fas fa-sync"></i>
</button>
@endsection

@section("js")
<script>
	const uploadButton = document.getElementById('upload-button');

	const url = "{{ route('main.timeline.get_posts') }}";
	const pullUrl = "{{ route('main.timeline.get_uploaded_status') }}"

	const showUploading = document.getElementById('show-uploading')

	const cards = document.getElementById('cards');
	const cardTmpl = document.getElementById('card-tmpl');

	async function pullUploadInformation() {
		const uploadStatus = await fetch(pullUrl, {
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}",
			},
			body: JSON.stringify({
				_token: "{{ csrf_token() }}",
			}),
		});

		const uploadStatusJson = await uploadStatus.json();

		console.log(uploadStatusJson);

		return !(uploadStatusJson['url'] == null || uploadStatusJson['caption'] == null)
	}

	async function loadPosts() {
		cards.innerHTML = "<h3 class='my-4 text-center'>Loading...</h3>";

		const posts = await fetch(url, {
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}",
			},
			body: JSON.stringify({
				_token: "{{ csrf_token() }}",
			}),
		});

		let postsJson = await posts.json();

		cards.innerHTML = "";

		for (let post of postsJson) {
			const template = cardTmpl.content;
			const card = template.cloneNode(true);

			cards.appendChild(card);

			const c = cards.children[cards.children.length - 1];

			c.querySelector('.user').innerText = post.user.username;
			c.querySelector('.date').innerText = post.date;
			c.querySelector('.caption').innerText = post.caption;

			if (post.url.split('.').pop() == 'mp4') {
				c.querySelector('.video').src = post.url;
				c.querySelector('.video').load();
				c.querySelector('.video').classList.remove('d-none');
			}
			else {
				c.querySelector('.image').src = post.url;
				c.querySelector('.image').classList.remove('d-none');
			}
		}
	}

	loadPosts();
	pullUploadInformation();

	let int = setInterval(async () => {
		let isUploaded = await pullUploadInformation();

		console.log(isUploaded);

		if (isUploaded) {
			clearInterval(int);
			uploadButton.disabled = false;
			showUploading.style.display = 'none';
		}
		else {
			uploadButton.disabled = true;
			showUploading.style.display = 'block';
		}

	}, 3000);
</script>

@endsection