@extends("template.app")

@section("body")
<div class="container col-6">
	@include("template.notice")
	<form class="card col-12 shadow" action="{{ route('main.upload.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="card-body">
			<div class="row mb-3">
				<div class="w-100 text-center" style="background-color: #ddd">
					<img src="" id="image-result" class="d-none rounded" alt="" style="max-width: 500px; max-height: 800px">
					<video src="" id="video-result" class="d-none rounded" style="max-width: 500px; max-height: 800px"></video>
				</div>
				<div id="cover" class="w-100 rounded" style="height: 500px; background-color: #ddd"></div>
				<p id="info-area" class="mt-3 d-none"></p>
			</div>
			
			<div class="row mb-3 mx-0">
				<label for="caption" class="col-form-label px-0">Image/Video</label>
				<input class="form-control" name="upload" id="upload" type="file">
			</div>

			<div class="row mb-4 mx-0">
				<label for="caption" class="col-form-label px-0">Caption</label>
				<textarea class="form-control" name="caption" id="caption" maxlength="160" placeholder="What's happening?" cols="30" rows="5"></textarea>
			</div>

			<div class="row mb-3 mx-0">
				<button class="btn btn-primary w-100 py-2">Upload!</button>
			</div>
		</div>
	</form>
</div>
@endsection

@section('js')
<script>
	var upload = document.getElementById('upload');
	var infoArea = document.getElementById('info-area');
	var cover = document.getElementById('cover');
	var imageResult = document.getElementById('image-result');
	var videoResult = document.getElementById('video-result');

	const extImg = ['jpg', 'jpeg', 'png'];
	const extVideo = ['mp4']

	upload.addEventListener('change', (event) => {
		readURL(upload);
		var input = event.srcElement;
		var fileName = input.files[0].name;
		infoArea.textContent = 'Uploaded: ' + fileName;
	});

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				var extension = input.files[0].name.split('.').pop().toLowerCase();

				cover.classList.add('d-none');
				infoArea.classList.remove('d-none');

				if (extImg.indexOf(extension) > -1) {
					videoResult.classList.add('d-none');
					imageResult.classList.remove('d-none');
					imageResult.src = e.target.result;
				}
				else {
					videoResult.classList.remove('d-none');
					imageResult.classList.add('d-none');
					videoResult.src = e.target.result;
				}
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection