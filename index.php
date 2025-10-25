<?php

error_reporting(E_ALL);
define('TONE_CORE', 1);
require_once('config.php');
require_once('core.php');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $pageTitle; ?></title>
	<link rel="author" href="https://repulsivecoder.pro" />
	<meta name="author" content="RepulsiveCoder" />
	<link rel="author" href="https://abdullahibnealam.com" />
	<meta name="author" content="Abdullah Ibne Alam" />
	<meta name="keywords" content="RetroTone Player - Created with Flash" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="RetroTone Player - Created with Flash" />
    <meta property="og:title" content="<?php echo $pageTitle; ?>"/>
    <meta property="og:description" content="RetroTone Player - Created with Flash"/>
    <meta property="og:image" content="<?php echo $ogImage; ?>"/>
    <meta property="og:type" content="website"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="<?php echo $pageTitle; ?>"/>
    <meta name="twitter:description" content="RetroTone Player - Created with Flash"/>
    <meta name="twitter:image" content="<?php echo $ogImage; ?>"/>
	<link rel="shortcut icon" type="image/png" href="assets/favicon.png">
	<link rel="stylesheet" href="assets/style.css?v=1.0.0.1" type="text/css" />
</head>
<body>
	<div id="parentContainer">
		<div class="page-title">
			<div class="title"><a href=""><img src="assets/music-note-logo.png" /></a></div>
			<div class="clear"></div>
		</div>
		<div id="mainContainer" class="main-container center">
			<div class="window center" style="max-width: 1024px; margin-left: auto; margin-right: auto;">
				<h3>RetroTone Player <span id="playerSongTitle"><?php echo !empty($songTitle) ? ' - '.$songTitle : ''; ?></span><small class="grey"></small></h3>
				<div class="playerAndPlayListContainer">
					<div class="player">
						<object>
							<embed id="flashPlayer" src="<?php echo $src; ?>" width="700" height="520" autoplay="on" />
						</object>
						<div class="window" style="margin-bottom: 0">Thanks to <a href="https://ruffle.rs/">https://ruffle.rs/</a> for Bringing Back Flash Player Emulator</div>
					</div>
					<div class="playList">
						<h3 style="margin: 0 0 10px; padding: 5px 10px;">Select Song</h3>
						<div style="max-height: 554px; overflow-y: scroll">
							<ul class="songSelection">
								<?php $i = 1; ?>
								<?php foreach ($songs as $song): ?>
								<li <?php echo $i++ == $index ? 'class="selected"' : ''; ?> >
									<a onclick="return selectSong(this, '<?php echo $song->link; ?>', '<?php echo $song->slug; ?>', '<?php echo addslashes($song->title); ?>')">
										<?php echo $song->title; ?>
									</a>
								</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="footer-container">
			<span class="copyright" onclick="$('.showMessage').slideDown().fadeTo(2000, 1).delay(5000).fadeTo(5000, 0.2).delay(100).slideUp(2000);">Copyright &copy; 2004</span>
			<span class="credit">Developed by <a href="https://www.repulsivecoder.pro" target="_blank">RepulsiveCoder</a></span>
		</div>
	</div>
	<script>
		window.RufflePlayer = window.RufflePlayer || {};
		window.RufflePlayer.config = {
			"autoplay": "on",
			"unmuteOverlay": "hidden",
		};
	</script>
	<script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
	<!-- <script src=" https://cdn.jsdelivr.net/npm/@ruffle-rs/ruffle@0.1.0-nightly.2024.7.7/ruffle.min.js "></script> -->
</body>
<script type="text/javascript">
<!--
	var pageBaseTitle = '<?php echo $pageBaseTitle; ?>';
	var baseURL = '<?php echo $baseURL; ?>';

	function playerResizeToFit() {
		const maxWidth = window.innerWidth;
		const itm = document.getElementById('flashPlayer');

		if (maxWidth < 800) {
			itm.width = Math.min(maxWidth - 70, 700);
		}
	}

	function selectSong(elm, src, slug, title) {
		document.getElementById('flashPlayer').src = src;
		Array.from(elm.parentNode.parentNode.children).forEach(n => n.classList.remove('selected'));
		elm.parentNode.classList.add('selected');
		history.pushState({page: slug}, `${pageBaseTitle} - ${title}`, `${baseURL}${slug}`);
		document.title = `${pageBaseTitle} - ${title}`;
		document.getElementById('playerSongTitle').innerHTML = `- ${title}`;
	}

	document.addEventListener('DOMContentLoaded', () => {
		playerResizeToFit();
	});

	window.addEventListener('resize', () => {
		playerResizeToFit();
	});
//-->
</script>

<style>

</style>
</html>