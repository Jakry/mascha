<?php
	session_start();
	session_destroy();
	header('Location: http://www.maschaobermeier.de');
	exit();
?>