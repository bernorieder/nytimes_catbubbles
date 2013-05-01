<?php

set_time_limit(60*60);

include "conf.php";

// prepare term
$term = urlencode($term);

// bing query into a "folderable" format
$folder = getcwd()."/json_".preg_replace("/[^a-zA-Z.]/","",$term);

// create folder for JSON files
if(!file_exists($folder)) { mkdir($folder); }

$hits = 1000;
$counter = 0;
$pagecounter = 0;

while($counter < $hits) {

	$url = "http://api.nytimes.com/svc/search/v2/articlesearch.json?q=".$term."&sort=oldest&api-key=".$key_search."&page=" . $pagecounter;

	$data = file_get_contents($url);
	if($data === FALSE) {
		sleep(5);
 		continue;
	}
	$data = json_decode($data);

	foreach($data->response->docs as $doc) {
		$counter++;
		file_put_contents($folder."/".$counter.".json", json_encode($doc));
	}

	echo $counter . " "; flush(); ob_flush();

	$hits = $data->response->meta->hits;
	$pagecounter++;

	usleep(100000);								// let's be polite and wait 100ms between each query
}

echo "done";

?>