<?php

require '../../../objects/sqlInterface.php';
require '../../objects/cms.php';

$cms = new cms();
if (!$cms->isLoggedIn()) {
	header('Location: http://www.maschaobermeier.de');
	exit();
}

$valueArray = array();
$sql = "UPDATE ".$_POST['__tablename']." SET ";
foreach ($_POST as $key => $value) {
	if (strpos($key, "pk_") !== 0 && $key != "__tablename" && $key != "__pageid") {
		$sql .= " $key=?,";
		array_push($valueArray, $value);
	}
}
$sql = substr($sql, 0, strlen($sql) - 1) . " WHERE ";
foreach ($_POST as $key => $value) {
	if (strpos($key, "pk_") === 0) {
		$sql .= substr($key, 3) . "=? AND ";		
		array_push($valueArray, $value);
	}
}
$sql = substr($sql, 0, strlen($sql) - 4);
sqlInterface::executeSql($sql, $valueArray);

if (isset($_POST['__pageid'])) {
	header('Location: http://www.maschaobermeier.de/?id='.$_POST['__pageid']);
}
exit();

?>