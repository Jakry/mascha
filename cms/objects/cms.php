<?php
class cms {	
	private $loggedIn = false;
	
	function __construct() {
		session_start();
		if (isset($_SESSION['id']) && isset($_SESSION['hash'])) {
			$userRow = sqlInterface::getRow("SELECT * FROM benutzer WHERE id=?", array($_SESSION['id']));
			if (count($userRow) > 0) {	
				if (((string)$_SESSION['hash']) == ((string)$userRow['passwort'])) {
					$this->loggedIn = true;
				}
			}
		}
	}
	
	public function isLoggedIn() {
		return $this->loggedIn;
	} 
	
	public function insertFiles() {
		if ($this->isLoggedIn()) {?>
			<!-- Slickgrid benötigt jquery mit der Version 1.7.1 -->
			<script src="cms/lib/slickgrid/lib/jquery-ui-1.8.16.custom.min.js"></script> 				
			<script src="cms/lib/slickgrid/lib/jquery.event.drag-2.2.js"></script>
			<script src="cms/lib/slickgrid/slick.core.js"></script>
			<script src="cms/lib/slickgrid/plugins/slick.cellrangedecorator.js"></script>
			<script src="cms/lib/slickgrid/plugins/slick.cellrangeselector.js"></script>
			<script src="cms/lib/slickgrid/plugins/slick.cellselectionmodel.js"></script>
			<script src="cms/lib/slickgrid/slick.formatters.js"></script>
			<script src="cms/lib/slickgrid/slick.editors.js"></script>
			<script src="cms/lib/slickgrid/slick.grid.js"></script>
			<link rel="stylesheet" href="cms/lib/slickgrid/slick.grid.css" type="text/css"/>
			<link rel="stylesheet" href="cms/lib/slickgrid/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>
			
			<script src="cms/js/cms.js"></script>
			<link rel="stylesheet" href="cms/style/cms.css">
			
		<?php }
	}
	
	public function createNewIcon($title, $tablename, $fieldnames, $fieldtypes, $style, $id, $addPk = null) {
		if ($this->isLoggedIn()) { ?>
			<div class="cms" style="position: absolute; <?php echo $style ?>">
				<a class="icon insert" href="javascript:void(0)" title="<?php echo $title; ?>"></a>
				<div class="formdata">					
					<form action="cms/posts/db/insert.php" method="post" enctype="multipart/form-data">
						<h5><?php echo $title; ?></h5>
						<input type="hidden" name="__tablename" value="<?php echo $tablename; ?>">
						<input type="hidden" name="__pageid" value="<?php echo $id; ?>">
						<?php
							if ($addPk != null) {
								foreach ($addPk as $key => $value) { ?>
									<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" >
								<?php }
							 }
							
							for ($i = 0; $i < count($fieldnames); $i++) { ?>								
								<div class="fieldset">
									<label for="<?php echo $fieldnames[$i]; ?>"><?php echo $fieldnames[$i]; ?></label>
									<?php
										if ($fieldtypes[$i] == "rtf") { ?>
											<textarea name="<?php echo $fieldnames[$i]; ?>">
												<?php echo $valueRow[$fieldnames[$i]]; ?>
											</textarea>
										<?php } else { ?>											
											<input type="<?php echo $fieldtypes[$i]; ?>" name="<?php echo $fieldnames[$i]; ?>" value="<?php echo $valueRow[$fieldnames[$i]]; ?>" />
										<?php }
									?>									
									<div class="clear"></div>
								</div>
							<?php }							
						?>
						<div class="buttons">
							<input type="submit" value="Speichern" />
							<a class="cancel" href="javascript:void(0);">Abbrechen</a>		
							<div class="clear"></div>
						</div>
					</form>
				</div>
			</div>
			<?php 
		}
	}		
	
	public function createDeleteIcon($title, $tablename, $primarykey, $style, $id) {
		if ($this->isLoggedIn()) { ?>
			<div class="cms" style="position: absolute; <?php echo $style ?>">
				<a class="icon delete" href="javascript:void(0)" title="<?php echo $title; ?>"></a>
				<div class="formdata">					
					<form action="cms/posts/db/delete.php" method="post" enctype="multipart/form-data">
						<h5><?php echo $title; ?></h5>
						<input type="hidden" name="__tablename" value="<?php echo $tablename; ?>">
						<input type="hidden" name="__pageid" value="<?php echo $id; ?>">
						<?php
							foreach ($primarykey as $key => $value) { ?>
								<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
							<?php }
						?>
						<div class="buttons">
							<input type="submit" value="L&ouml;schen" />
							<a class="cancel" href="javascript:void(0);">Abbrechen</a>		
							<div class="clear"></div>
						</div>
					</form>					
				</div>
			</div>
			<?php 
		}
	}
	
	public function createUpdateIcon($title, $tablename, $fieldnames, $fieldtypes, $primarykey, $style, $id) {
		if ($this->isLoggedIn()) { 
			$keyarray = array();
			$sql = "SELECT ";
			foreach ($fieldnames as $field) {
				$sql .= "$field,";
			} 
			$sql = substr($sql, 0, strlen($sql) - 1) . " FROM $tablename WHERE ";
			foreach ($primarykey as $key => $value) {
				$sql .= "$key=? AND";
				array_push($keyarray, $value);
			}
			$sql = substr($sql, 0, strlen($sql) - 3);
			$valueRow = sqlInterface::getRow($sql, $keyarray);			
			?>
			<div class="cms" style="position: absolute; <?php echo $style ?>">
				<a class="icon update" href="javascript:void(0)" title="<?php echo $title; ?>"></a>
				<div class="formdata">					
					<form action="cms/posts/db/update.php" method="post" enctype="multipart/form-data">
						<h5><?php echo $title; ?></h5>
						<input type="hidden" name="__tablename" value="<?php echo $tablename; ?>">
						<input type="hidden" name="__pageid" value="<?php echo $id; ?>">
						<?php
							foreach ($primarykey as $key => $value) { ?>
								<input type="hidden" name="pk_<?php echo $key; ?>" value="<?php echo $value; ?>" />								
							<?php }
							for ($i = 0; $i < count($fieldnames); $i++) { ?>
								<div class="fieldset">
									<label for="<?php echo $fieldnames[$i]; ?>"><?php echo $fieldnames[$i]; ?></label>
									<?php
										if ($fieldtypes[$i] == "rtf") { ?>
											<textarea name="<?php echo $fieldnames[$i]; ?>">
												<?php echo $valueRow[$fieldnames[$i]]; ?>
											</textarea>
										<?php } else { ?>											
											<input type="<?php echo $fieldtypes[$i]; ?>" name="<?php echo $fieldnames[$i]; ?>" value="<?php echo $valueRow[$fieldnames[$i]]; ?>" />
										<?php }
									?>
									<div class="clear"></div>
								</div>
							<?php }
						?>						
						<div class="buttons">
							<input type="submit" value="Speichern" />
							<a class="cancel" href="javascript:void(0);">Abbrechen</a>		
							<div class="clear"></div>
						</div>
					</form>					
				</div>
			</div>
			<?php 
		}
	}

	public function createViewIcon($title, $tablename, $fieldoptions, $primarykey, $orderby, $style, $id) {
		if ($this->isLoggedIn()) {
			$keyarray = null;
			$sql = "SELECT ";
			foreach ($fieldoptions as $name => $opts) {
				$sql .= "$name,";
			} 	
			$sql = substr($sql, 0, strlen($sql) - 1) . " FROM $tablename $orderby";
			if ($primarykey != null) {
				$keyarray = array();
				$sql .= "WHERE ";
				foreach ($primarykey as $key => $value) {
					$sql .= "$key=? AND";
					array_push($keyarray, $value);
				}
				$sql = substr($sql, 0, strlen($sql) - 3);
			}
			$rows = sqlInterface::getRows($sql, $keyarray);
			?>
			<div class="cms" style="position: absolute; <?php echo $style ?>">
				<a class="icon view" href="javascript:void(0)" title="<?php echo $title; ?>"></a>
				<div class="formdata">					
					<form action="cms/posts/db/view.php" method="post" enctype="multipart/form-data">
						<h5><?php echo $title; ?></h5>
						<input type="hidden" name="__tablename" value="<?php echo $tablename; ?>">
						<input type="hidden" name="__pageid" value="<?php echo $id; ?>">
						<div class="fieldoptions">
							<?php
								foreach ($fieldoptions as $name => $opt) {
									$options = ""; 
									foreach ($opt as $key => $o) {
										$options .= "$key=\"$o\"";
									}
									?>
									<input class="field-option" type="hidden" name="<?php echo $name; ?>" <?php echo $options; ?>>
								<?php } 
							?>
						</div>
						<div class="fieldvalues">
							<?php 
								foreach ($rows as $row) {
									$i = 0;
									foreach ($fieldoptions as $name => $opts) {
										if ($i++ > 0) {
											echo "{;}";
										}
										echo $row[$name];
									}
									echo "{;;;}";
								}
							?>
						</div>
						<div class="slickgrid"></div>
						
						<div class="buttons">
							<div class="loading"><img src="cms/style/images/loading.gif"></div>
							<input type="submit" value="Fertig" />
							<a class="cancel" href="javascript:void(0);">Abbrechen</a>		
							<div class="clear"></div>
						</div>
					</form>					
				</div>
			</div>
			
			<?php
		} 
	}
}
?>