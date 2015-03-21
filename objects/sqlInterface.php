<?php
class sqlInterface {
	private static $DB_CONNECTION = null;

	private static final function getNewPdoConnection() {		
		self::$DB_CONNECTION = new PDO('mysql:host=r2sql7.masterlogin.de;dbname=maschaobwesql9db1', 'maschaobwesql9', 'F$v!gLr0', null);
		self::$DB_CONNECTION->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    	return self::$DB_CONNECTION;
	}
  
	private static final function getPdoConnection() {
		try {
			return (is_null(self::$DB_CONNECTION)) ? self::getNewPdoConnection() : self::$DB_CONNECTION;
		} catch (Exception $e) {
			echo $e->getTraceAsString();
		}
	}
	
	public static final function getRows($sql, $params = null) {
		$stmt = sqlInterface::getPdoConnection()->prepare($sql);
		$stmt->execute($params);		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static final function getRow($sql, $params = null) {
		$stmt = sqlInterface::getPdoConnection()->prepare($sql);
		$stmt->execute($params);		
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 
		return $rows[0];
	}
	public static final function executeSql($sql, $params = null) {
		$stmt = sqlInterface::getPdoConnection()->prepare($sql);
		$stmt->execute($params);
	}

}
?>