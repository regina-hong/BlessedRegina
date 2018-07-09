<?php

if ($book == 'Gen') {
	$url = 'YouTube/genesis1.json';
} elseif ($book == 'Exod') {
	$url = 'YouTube/exodus1.json';
} elseif ($book == 'Lev') {
	$url = 'YouTube/leviticus1.json';
} elseif ($book == 'Num') {
	$url = 'YouTube/numbers1.json';
} 
else {
	$url = 'YouTube/genesis1.json';
}


$data = file_get_contents($url); // put the contents of the file into a variable
$jsonStuff = json_decode($data, true); // decode the JSON feed
$vtitle = array();
$vid = array();

foreach($jsonStuff['items'] as $val) {

	$vtitle[] = $val['snippet']['title'];
	$vid[] = $val['snippet']['resourceId']['videoId'];

}

?>