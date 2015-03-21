<?php
require '../../../objects/sqlInterface.php';
require '../../objects/cms.php';
require '../../objects/config.php';

$cms = new cms();
if (!$cms->isLoggedIn()) {
	header('Location: http://www.maschaobermeier.de');
	exit();
}

function createWhere($keyValArr, &$sqlWhere, &$valueArray) {
	$sqlWhere = " WHERE ";
	$valueArray = array();
	foreach ($keyValArr as $key => $value) {
		if ($key != "__tablename" && $key != "__pageid") {		
			$sqlWhere .= "$key=? AND ";		
			array_push($valueArray, $value);
		}
	}
	$sqlWhere = substr($sqlWhere, 0, strlen($sqlWhere) - 4);
}
function deleteFiles($tablename, $sqlWhere, $valueArray) {	
	if (isset(CONFIG::$imageFields[$tablename])) {		
		$sql = "SELECT ";
		foreach (CONFIG::$imageFields[$tablename] as $field) {
			$sql .= $field . ",";
		}
		$sql = substr($sql, 0, strlen($sql) - 1) . " FROM " . $tablename . $sqlWhere;
				
		$imagerows = sqlInterface::getRows($sql, $valueArray);
		foreach ($imagerows as $imagerow) {			
			foreach (CONFIG::$imageFields[$tablename] as $field) {				
				if (file_exists("../../../".$imagerow[$field])) {					
					unlink("../../../".$imagerow[$field]);
				}
			}
		}
	}
}

$valueArray = array();
$sqlWhere = "";

if (isset(CONFIG::$relationFields[$_POST['__tablename']])) {	
	foreach (CONFIG::$relationFields as $parenttablename => $arr) {
		if ($parenttablename == $_POST['__tablename']) {			
			foreach ($arr as $childtablename => $fieldarr) {
				$newFieldValues = array();
				foreach ($fieldarr as $parentfield => $childfield) {
					$newFieldValues[$childfield] = $_POST[$parentfield];
				}				
				createWhere($newFieldValues, $sqlWhere, $valueArray);
				deleteFiles($childtablename, $sqlWhere, $valueArray);
				
				$sql = "DELETE FROM $childtablename $sqlWhere";				
				sqlInterface::executeSql($sql, $valueArray);
			}
			break;
		}
	}
}

createWhere($_POST, $sqlWhere, $valueArray);
deleteFiles($_POST['__tablename'], $sqlWhere, $valueArray);

$sql = "DELETE FROM ".$_POST['__tablename']. " $sqlWhere";
sqlInterface::executeSql($sql, $valueArray);

if (isset($_POST['__pageid'])) {
	header('Location: http://www.maschaobermeier.de/?id='.$_POST['__pageid']);
}
exit();
?>