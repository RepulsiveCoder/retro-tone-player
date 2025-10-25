<?php

defined('TONE_CORE') or die('Direct Access to this place is not Permitted');

$homebaseurl = dirname($_SERVER['SCRIPT_NAME']);
if (empty($baseURL) && php_sapi_name() != 'cli') {
	global $baseURL;
	$baseURL = dirname($_SERVER['SCRIPT_NAME']);
	$baseURL = str_replace('\\', '/', $baseURL);

	if (substr($baseURL, -1) != '/') {
		$baseURL .= '/';
	}
}

$slug = substr($_SERVER['REQUEST_URI'], strlen($baseURL));
$index = isset($_REQUEST['index']) ? $_REQUEST['index'] : 3;

$songs = json_decode($songsJson);

if (!empty($songs) && $index > count($songs)) {
	$index = 1;
}

list ($src, $index, $slug, $pageTitle, $songTitle, $ogImage) = processSongs($songs, $index, $slug);

function processSongs($songs, $index, $slug) {
	global $pageTitle;
	$ogImage = 'assets/retro-tone-player.png';
	$found = false;
	$src = '';
	$fsrc = '';

	if (strpos($slug, '?') !== false || strpos($slug, '=') !== false){
		$slug = '';
	}

	if (!empty($songs)) {
		$i = 1;
		foreach ($songs as $song) {
			$notes = explode(',', $song->notes);

			$ls = [];
			$ns = [];
			foreach ($notes as $note) {
				preg_match('/[a-z\-#]/i', $note, $matches, PREG_OFFSET_CAPTURE);
				$l = substr($note, 0, $matches[0][1]);
				$n = substr($note, $matches[0][1]);
				if (strpos($n, '#') !== false && substr($n, 0, -1) != '#') {
					$n = '#'.str_replace('#', '', $n);
				}

				$ls[] = $l;
				$ns[] = $n;
			}

			$song->link = 'assets/retro-tone-player.swf?m='.rawurlencode($song->title).'&t='.$song->tempo.'&n='.implode(',', array_map(function ($n) { return urlencode($n); }, $ns)).'&l='.implode(',', $ls).'&a='.rawurlencode($song->composer).'&d='.rawurlencode($song->date).'&r='.($song->repeat??1);
			unset($ls);
			unset($ns);

			if ($i == 1) {
				$fsrc = $song->link;
			}

			if (!empty($slug)) {
				if ($song->slug == $slug) {
					$found = true;
					$src = $song->link;
					$index = $i;
					$pageTitle .= ' - '.$song->title;
					$songTitle = $song->title;
				}
			} else if (!empty($index) && $i == $index) {
				$found = true;
				$src = $song->link;
				$pageTitle .= ' - '.$song->title;
				$songTitle = $song->title;
				$slug = $song->slug;
			}
			++$i;
		}
	}

	if ($found === false) {
		$src = $fsrc;
		$index = 1;
	} else if (file_exists('assets/og_images/'.$slug.'.png')) {
		$ogImage = 'assets/og_images/'.$slug.'.png';
	}

	return [$src, $index, $slug, $pageTitle, $songTitle, $ogImage];
}