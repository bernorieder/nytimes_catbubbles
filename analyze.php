<?php

/**
* New York Times Bubble Explorer
*
* @author Bernhard Rieder <rieder@uva.nl>, @riederb
* @version 0.1
* @license GPLv3 <http://www.gnu.org/licenses/gpl.txt>
*/

// adapt to desired value
$minyears = 10;		// specifies the number of years a category has to appear in order to be included

// search query and api key are in:
include "conf.php";

// prepare term
$term = urlencode($term);
$term = preg_replace("/[^a-zA-Z.]/","",$term);
$folder = getcwd()."/json_".$term;

$list = scandir($folder);

// shave off . and ..
array_shift ($list);
array_shift ($list);

// initialize some variables
$taglines = array();
$oldest = 20000;
$newest = 0;

// iterate over all JSON files
foreach($list as $fn) {
	$json = file_get_contents($folder . "/".$fn);
	$json = json_decode($json);
	//print_r($json); exit;

	// iterate over keywords
	foreach($json->keywords as $keyword) {

		$keyword->value = strtoupper($keyword->value);
		$keyword->value = preg_replace("/,/"," ", $keyword->value);

		if(!isset($taglines[$keyword->value])) {
			$taglines[$keyword->value] = array();
			$taglines[$keyword->value]["type"] = $keyword->name;
			$taglines[$keyword->value]["time"] = array();
		}

		$year = substr($json->pub_date,0,4);

		if($year < $oldest) { $oldest = $year; }
		if($year > $newest) { $newest = $year; }

		if(!isset($taglines[$keyword->value]["time"][$year])) {
			$taglines[$keyword->value]["time"][$year] = array();
			$taglines[$keyword->value]["time"][$year]["count"] = 1;
			$taglines[$keyword->value]["time"][$year]["wordcount"] = $json->word_count;
		} else {
			$taglines[$keyword->value]["time"][$year]["count"]++;
			$taglines[$keyword->value]["time"][$year]["wordcount"] += $json->word_count;
		}
	}
}

// filter out keywords that don't appear often enough
$taglines_filtered = array();
foreach($taglines as $key => $value) {
	if(count($value["time"]) >= $minyears && $value["type"] == "subject") {
		$taglines_filtered[$key] = $value;
	}
}

// compose and write data format that plays nice with R
$content = "year,subject,count,wordcount\n";
foreach($taglines_filtered as $key => $value) {
	for($i = $oldest; $i <= $newest; $i++) {
		if(isset($value["time"][$i])) {
			$content .= $i . "," . $key . "," . $value["time"][$i]["count"] . "," . $value["time"][$i]["wordcount"] . "\n";
		}
	}
}

file_put_contents(getcwd() . "/data_". $term . ".csv",$content);

echo "done";

?>