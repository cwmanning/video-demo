<!doctype html>
<html>
	<head>
		<title>HTML5 video demo</title>
		<style>

/* Default */
body {
	height: 100%;
	margin: 0;
	overflow: hidden;
	position: absolute;
	width: 100%;
}
video {
	display: block;
	height: 100%;
	width: 100%;
}
#select {
	background-color: #fff;
	background-image: none;
	border-radius: 4px;
	border: 1px solid #ccc;
	box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	color: #555;
	display: block;
	font-size: 14px;
	height: 34px;
	line-height: 1.42857143;
	padding: 6px 12px;
	position: absolute;
	right: 3%;
	top: 3%;
}

/* Minimum height/width */

.minHeightWidth {
	height: auto;
	width: auto;
	min-height: 100%;
	min-width: 100%;
	position: absolute;
}

/* CSS Transforms */

.transform {
/* See below, value set with javascript.
	transform: scale(1);
	-webkit-transform: scale(1);
*/
}

/* CSS Transform-Origin */

.transform-origin {
/* See below, value set with javascript.
	transform-origin: 20% 40%;
	-webkit-transform-origin: 20% 40%;
*/
}

		</style>
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
		<script>
			var $player = $('#player');
			var player = $player.get(0);
			var $parent = $player.parent();
			var $win = $(window);
			var resizeTimeout = null;
			var shouldResize = false;
			var shouldPosition = false;
			var videoRatio = 16 / 9;

			var resize = function() {
				if (!shouldResize) { return; }

				var height = $parent.height();
				var width = $parent.width();
				var viewportRatio = width / height;
				var scale = 1;

				if (videoRatio < viewportRatio) {
					// viewport more widescreen than video aspect ratio
					scale = viewportRatio / videoRatio;
				} else if (viewportRatio < videoRatio) {
					// viewport more square than video aspect ratio
					scale = videoRatio / viewportRatio;
				}

				var offset = positionVideo(scale, width, height);
				setVideoTransform(scale, offset);
			};

			var setVideoTransform = function(scale, offset) {
				offset = $.extend({ x: 0, y: 0 }, offset);
				var transform = 'translate(' + Math.round(offset.x) + 'px,' + Math.round(offset.y) + 'px) scale(' + scale  + ')';
				$player.css({
					'-webkit-transform': transform,
					'transform': transform
				});
			};

			// accounts for transform origins on scaled video
			var positionVideo = function(scale, width, height) {
				if (!shouldPosition) { return false; }

				var x = parseInt($player.data('origin-x'), 10);
				var y = parseInt($player.data('origin-y'), 10);
				setVideoOrigin(x, y);

				var viewportRatio = width / height;
				var scaledHeight = scale * height;
				var scaledWidth = scale * width;
				var percentFromX = (x - 50) / 100;
				var percentFromY = (y - 50) / 100;
				var offset = {};

				if (videoRatio < viewportRatio) {
					offset.x = (scaledWidth - width) * percentFromX;
				} else if (viewportRatio < videoRatio) {
					offset.y = (scaledHeight - height) * percentFromY;
				}

				return offset;
			};

			var setVideoOrigin = function(x, y) {
				var origin = x + '% ' + y + '%';
				$player.css({
					'-webkit-transform-origin': origin,
					'transform-origin': origin
				});
			};

			player.volume = 0;

			$win.on('resize', function() {
				clearTimeout(resizeTimeout);
				resizeTimeout = setTimeout(resize, 100);
			});

			$('#select').on('change', function(e) {
				var selected = $(this).children(':selected');
				var value = selected.val();
				player.setAttribute('style', '');
				switch (value) {
					case 'transform':
						shouldResize = true;
						shouldPosition = false;
						resize();
						break;

					case 'transform-origin':
						shouldResize = true;
						shouldPosition = true;
						resize();
						break;

					default:
						shouldResize = false;
						shouldPosition = false;
				}
				player.setAttribute('class', value);
			});
		</script>

	</body>
</html>