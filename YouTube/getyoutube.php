<?php

if ($book == 'Gen') {
	$url = 'YouTube/genesis1.json';
} elseif ($book == 'Exod') {
	$url = 'YouTube/exodus1.json';
} elseif ($book == 'Lev') {
	$url = 'YouTube/leviticus1.json';
} elseif ($book == 'Num') {
	$url = 'YouTube/numbers1.json';
} elseif ($book == 'Deut') {
	$url = 'YouTube/deuteronomy1.json';
} elseif ($book == 'Josh') {
	$url = 'YouTube/joshua1.json';
} elseif ($book == 'Judg') {
	$url = 'YouTube/judges1.json';
} elseif ($book == '1Sam') {
	$url = 'YouTube/1samuel1.json';
} elseif ($book == '2Sam') {
	$url = 'YouTube/2samuel1.json';
} elseif ($book == '1Kgs') {
	$url = 'YouTube/1kings1.json';
}  
else {
	$url = '';
}

if ($url <> '') {
	$data = file_get_contents($url); // put the contents of the file into a variable
	$jsonStuff = json_decode($data, true); // decode the JSON feed
	$vtitle = array();
	$vid = array();


	foreach($jsonStuff['items'] as $val) {

		$vtitle[] = $val['snippet']['title'];
		$vid[] = $val['snippet']['resourceId']['videoId'];

	}
}

?>