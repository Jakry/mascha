<?php
require '../../objects/sqlInterface.php';
$userRow = sqlInterface::getRow("SELECT * FROM benutzer WHERE name=?", array($_POST['benutzer']));
if (count($userRow) > 0) {
	$md5pwd = md5($_POST['passwort']);				
	if (((string)$md5pwd) == ((string)$userRow['passwort'])) {		
		session_start();
					
		$_SESSION['id'] = $userRow['id'];
		$_SESSION['hash'] = $md5pwd;
				
		header('Location: http://www.maschaobermeier.de');
		exit();
	}
}
header('Location: http://www.maschaobermeier.de/cms?fail');
exit();
?>