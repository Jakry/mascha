<?php
function getImageStyle($image, $maxheight, $maxwidth) {
	$size = getimagesize("../".$image);
	
	if ($size[0] <= $size[1] && $size[1] > $maxheight) {
		return "style=\"max-height: ".$maxheight."px; border: none;\"";
	}
	
	$margintop = 0;
	if ($size[0] > $maxwidth) {
		$newheight = $size[1] * $maxwidth / $size[0];
		if ($newheight < $maxheight) {			
			$margintop = (int)(($maxheight - $newheight) / 2);
		}
				
	} else {
		if ($size[1] < $maxheight) {			
			$margintop = (int)(($maxheight - $size[1]) / 2);
		}
		
	}
	return "style=\"margin-top: ".$margintop."px; max-height: ".$maxheight."px; border: none;\"";	
}

require "../objects/sqlInterface.php";
require "../cms/objects/cms.php";

$picid = $_POST['picid'];
$nextpicid = $_POST['nextpicid'];
$maxheight = $_POST['maxheight'];
$maxwidth = $_POST['maxwidth'];

$picrows = sqlInterface::getRows("SELECT * FROM portrait ORDER BY sortierung");
$foundrow = $picrows[0];
for ($i = 0; $i < count($picrows); $i++) {
	if ($picid == $picrows[$i]['id']) {		
		$curid = $i + $nextpicid;
		if ($curid >= count($picrows)) {
			$curid -= count($picrows);
		} else if ($curid < 0) {
			$curid += count($picrows);
		}
		$foundrow = $picrows[$curid];
		break;
	}	
}

$cmsobj = new cms();
$cmsobj->createNewIcon("Portrait hinzuf&uuml;gen", "portrait", array("bild","sortierung"), array("file","number"), "top:0;left:0;", 6);
$cmsobj->createDeleteIcon("Das Portrait l&ouml;schen?", "portrait", array("id" => $foundrow['id']), "top:0; left: 35px;", 6);
$cmsobj->createViewIcon("Portrait&uuml;bersicht", "portrait", array(
					"id" => array("pk" => true), 
					"bild" => array(), 
					"fotograf" => array("editor" => "text"), 
					"sortierung" => array("editor" => "text")), null, "ORDER BY sortierung", "top: 0; left: 70px;", 6);

echo '<img id="backimage" src="'.$foundrow['bild'].'" rel="'.$foundrow['id'].'" '.getImageStyle($foundrow['bild'], $maxheight, $maxwidth).'>';

?>