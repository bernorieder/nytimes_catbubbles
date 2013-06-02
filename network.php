<?php

/**
* New York Times Bubble Explorer
*
* @author Bernhard Rieder <rieder@uva.nl>, @riederb
* @version 0.1
* @license GPLv3 <http://www.gnu.org/licenses/gpl.txt>
*/

require_once("Gexf.class.php");

// adapt to desired value
$minyears = 10;		// specifies the number of year a category has to appear in order to be included

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
$gexf = new Gexf();
$gexf->setTitle("NY Times Categories");
$gexf->setEdgeType(GEXF_EDGE_UNDIRECTED);
$gexf->setMode(GEXF_MODE_STATIC);
$gexf->setTimeFormat(GEXF_TIMEFORMAT_DATE);
$gexf->setCreator("polsys.net");

//print_r($gexf);

// iterate over all JSON files
foreach($list as $fn) {
	$json = file_get_contents($folder . "/".$fn);
	$json = json_decode($json);
	//print_r($json);
	//exit;


	// iterate over keywords
	for($i= 0; $i < count($json->keywords); $i++) {
		$node1 = new GexfNode(strtolower($json->keywords[$i]->value));
		$node1->addNodeAttribute("type",$json->keywords[$i]->name,$type="string");
		$gexf->addNode($node1);
		for($j= $i; $j < count($json->keywords); $j++) {
			//echo $json->keywords[$i]->value."|";
			//echo $json->keywords[$j]->value."\n";
			$node2 = new GexfNode(strtolower($json->keywords[$j]->value));
			$node2->addNodeAttribute("type",$json->keywords[$j]->name,$type="string");
			$gexf->addNode($node2);

			if(strtolower($json->keywords[$i]->value) != strtolower($json->keywords[$j]->value)) {
				$gexf->addEdge($node1, $node2);
			}
		}
	}
	//print_r($gexf);
	//break;
}

/*
0,node1,10
1,node2,20
2,node3,15
3,node4,5
edgedef>node1 VARCHAR,node2 VARCHAR
0,1
1,2
2,3
0,2
*/

$gexf->render();

file_put_contents(getcwd() . "/data_". $term . ".gexf",$gexf->gexfFile);

echo "done";

?>