<?php

$url = 'YouTube/genesis1.json'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$jsonStuff = json_decode($data, true); // decode the JSON feed
$vtitle = array();
$vid = array();

foreach($jsonStuff['items'] as $val) {

	$vtitle[] = $val['snippet']['title'];
	$vid[] = $val['snippet']['resourceId']['videoId'];

}

//echo $vtitle[0].'-'.$vid[0];

?>