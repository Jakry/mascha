<?php
class CONFIG {
	// Datenbankfelder, mit Dateipfaden (<Tabellenname> => array(<Feld1>, <Feld2>))
	public static $imageFields = array(
		"portrait" => array("bild"), 
		"buehnenbilder" => array("bild", "thumb"), 
		"stimme" => array("audio"),
		"terminbild" => array("bild"),
		"buehnenerfahrung" => array("jahreslogo")
	);
	
	// Grundpfad aller Dateien	
	public static $filepath = "contents/";	
	
	// Lokationen der jeweiligen Dateien (<Tabellenname>_<Feld> => <Lokation>)	
	public static $fieldpaths = array(
		"portrait_bild" => "images/portrait/",
		"buehnenbilder_bild" => "images/buehne/", 	
		"buehnenbilder_thumb" => "images/buehne/",
		"stimme_audio" => "stimme/",
		"terminbild_bild" => "images/termine/",
		"buehnenerfahrung" => "images/jahreslogos/"
	); 	 
	
	// Relationen zwischen den Tabellen (um Kinddatensätze mit Dateipfaden zu berücksichtigen)
	public static $relationFields = array(
		"buehne" => array(
			"buehnenbilder" => array("id" => "pid")
		),
		"termin" => array(
			"terminzeiten" => array("id" => "pid"),
			"terminbild" => array("id" => "pid")
		)
	);	
}

	
?>