<?php
require '../../../objects/sqlInterface.php';
require '../../objects/cms.php';
require '../../objects/config.php';

$cms = new cms();
if (!$cms->isLoggedIn()) {
	header('Location: http://www.maschaobermeier.de');
	exit();
}

$valueArray = array();

$sql = "INSERT INTO ".$_POST['__tablename']. " (";
$values = " VALUES(";
foreach ($_POST as $key => $value) {
	if ($key != "__tablename" && $key != "__pageid") {		
		$sql .= "$key,";
		$values .= "?,";		
		array_push($valueArray, $value);
	}
}
foreach ($_FILES as $key => $file) {
	if ($file != null) {
		$sql .= "$key,";
		$values .= "?,";	
		
		$fpath = CONFIG::$filepath;
		if (isset(CONFIG::$fieldpaths[$_POST['__tablename']."_".$key])) {
			$fpath .= CONFIG::$fieldpaths[$_POST['__tablename']."_".$key];
		}
		
		array_push($valueArray, $fpath.$file['name']);
		move_uploaded_file($file['tmp_name'], '../../../'.$fpath.$file['name']);	
	}
}

$sql = substr($sql, 0, strlen($sql) - 1) . ")" . substr($values, 0, strlen($values) - 1) . ")";
sqlInterface::executeSql($sql, $valueArray);

if (isset($_POST['__pageid'])) {
	header('Location: http://www.maschaobermeier.de/?id='.$_POST['__pageid']);
}
exit();
?>