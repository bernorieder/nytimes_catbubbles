<?php

include "conf.php";

$term = urlencode($term);
$term = preg_replace("/[^a-zA-Z.]/","",$term);
$folder = getcwd()."/json_".$term;

$list = scandir($folder);

array_shift ($list);
array_shift ($list);

$taglines = array();

foreach($list as $fn) {
	$json = file_get_contents($folder . "/".$fn);
	$json = json_decode($json);
	//print_r($json);

	foreach($json->keywords as $keyword) {

		if(!isset($taglines[$keyword->value])) {
			$taglines[$keyword->value] = array();
			$taglines[$keyword->value]["type"] = $keyword->name;
			$taglines[$keyword->value]["time"] = array();
			$taglines[$keyword->value]["full"] = 0;
			$taglines[$keyword->value]["full_wc"] = 0;				// word count
		}

		$year = substr($json->pub_date,0,4);

		if(!isset($taglines[$keyword->value]["time"][$year])) {
			$taglines[$keyword->value]["time"][$year] = 1;
		} else {
			$taglines[$keyword->value]["time"][$year]++;
		}
	}
}

//print_r($taglines);

$taglines_filtered = array();

foreach($taglines as $key => $value) {
	if(count($value["time"]) > 20 && $value["type"] == "subject") {
		$taglines_filtered[$key] = $value;
	}
}

//print_r($taglines_filtered);

/*
foreach($taglines_filtered as $key => $value) {
	if(!isset($lines[0])) { $lines[0] = "year"; }
	$lines[0] .=  ",".$key;
	for($i = 1969; $i <= 2012; $i++) {

		if(!isset($lines[$i])) { $lines[$i] = $i; }

		if(isset($value["time"][$i])) {
			$lines[$i] .= "," . $value["time"][$i];
		} else {
			$lines[$i] .= ",0";
		}
	}
}
*/

$content = "year,subject,value\n";
foreach($taglines_filtered as $key => $value) {
	for($i = 1969; $i <= 2013; $i++) {
		if(isset($value["time"][$i])) {
			$content .= $i . "," . $key . "," . $value["time"][$i] . "\n";
		}
	}
}

file_put_contents(getcwd() . "/data_". $term . ".csv",$content);

?>