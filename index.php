<!doctype html>
<html>
	<head>
		<title>HTML5 video demo</title>
		<link href="demo.css" rel="stylesheet">
	</head>
	<body>

		<video id="player" autoplay preload loop data-origin-x="20" data-origin-y="40">
			<source src="video/pitcher.mp4" type="video/mp4">
			<source src="video/pitcher.webm" type="video/webm">
		</video>

		<select id="select">
			<option value="">Default example</option>
			<option value="minHeightWidth">Minimum height/width</option>
			<option value="transform">CSS Transform</option>
			<option value="transform-origin">CSS Transform-Origin</option>
		</select>

		<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="demo.js"></script>

	</body>
</html>