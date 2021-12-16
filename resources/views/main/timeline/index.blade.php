@extends("template.app")

@section("body")
	<div class="container-fluid px-0">

		<a class="btn btn-primary" href="{{ route("main.upload.index") }}">Upload new file</a>

		<div class="row">
			<div class="col-12 col-sm-5 mx-auto" id="cards">
			</div>
		</div>

	</div>

	<template id="card-tmpl">
		<div class="card col-12 shadow mb-3">
			<div class="card-body">
				<div class="row mb-3">
					<div class="w-100 text-center" style="background-color: #ddd">
						<img src="" class="d-none rounded" alt="" style="max-width: 500px; max-height: 800px">
						<video src="" class="d-none rounded" style="max-width: 500px; max-height: 800px"></video>
					</div>
				</div>
	
				<div class="row mb-4 mx-0">
					<p class="caption"></p>
				</div>
			</div>
		</div>
	</template>
@endsection

@section("js")

	<script>
		const url = "{{ route('main.timeline.get_posts') }}";

		const cards = document.getElementById('cards');
		const cardTmpl = document.getElementById('card-tmpl');

		async function loadPosts() {
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

			for (let post of postsJson) {
				const template = cardTmpl.content;

				template.querySelector('img').src = post.url;
				template.querySelector('.caption').innerText = post.caption;
				template.querySelector('img').classList.remove('d-none');

				cards.appendChild(template.cloneNode(true));
			}
		}

		loadPosts();
	</script>

@endsection