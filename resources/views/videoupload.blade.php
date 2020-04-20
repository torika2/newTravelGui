<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="http://localhost:8000/api/upload_video" method="post" enctype="multipart/form-data">
		<input type="file" name="video">

	<form action="http://localhost:8000/api/make_clips" method="post" enctype="multipart/form-data">
		<input type="file" name="photo">

		<button>send</button>
	</form>
	<video  width="320" height="240" controls>
		<source src="{{ asset('uploads/videos/5e5bc500100d50.mp4') }}" type="video/mp4">

	</video>
</body>
</html>