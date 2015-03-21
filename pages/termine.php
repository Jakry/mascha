<div id="termine">
	<?php
		$cms = new cms();
		
		$rows = sqlInterface::getRows("SELECT t.id, t.name, t.form, tb.bild, tb.id as tbid, tz.id AS tzid, tz.datum, tz.zeit, tz.ort 
			FROM termine t LEFT JOIN terminzeiten tz ON t.id = tz.pid LEFT JOIN terminbild tb ON t.id = tb.pid ORDER BY t.id, tz.datum" );
	?>
	
	<div class="table">
		<div class="thead">
			<div class="fullhead"></div>
			<div class="name">Titel</div>
			<div class="form">Form</div>
			<div class="datum">Datum</div>
			<div class="zeit">Zeit</div>
			<div class="ort">Ort</div>
			<div class="clear"></div>			
		</div>
		<div class="tbody">
			<?php 
				$ltid = -1;				
				foreach ($rows as $row) {
					$name = "";
					$form = "";
					if ($row['id'] != $ltid) { // nächster Termin
						if ($ltid != -1) { ?>
							<div class="tline"></div>
						<?php }
						$ltid = $row['id'];						
												
						$name = $row['name'];
						$form = $row['form'];							
					}
					
					?>
					<div class="row">		
						<?php
							if ($name != "") {
								$cms->createNewIcon("Terminzeiten hinzuf&uuml;gen", "terminzeiten", 
									array("datum", "zeit", "ort"), array("date", "text", "text"), "left: -35px; top: 0;", 11, array("pid" => $row['id']));
								$cms->createUpdateIcon("Name des Termins &auml;ndern", "termine", 
									array("name", "form"), array("text", "text"), array("id" => $row['id']), "left: -35px; top: 35px;", 11);
								$cms->createDeleteIcon("Termin l&ouml;schen", "termine", array("id" => $row['id']), "left: -35px; top: 70px;", 11);
								
								?>
								<div class="tpic">
									<?php
										if ($row['bild'] != null) { ?>
											<a class="fancyme" href="<?php echo $row['bild'] ?>">Flyer</a>										
										 	<?php $cms->createDeleteIcon("Terminbild l&ouml;schen", "terminbild", array("id" => $row['tbid']), "left: 60px; top: 0;", 11);
										} else {
											$cms->createNewIcon("Terminbild hinzuf&uuml;gen", "terminbild", array("bild"), array("file"), "left: 60px; top: 0;", 11, array("pid" => $row['id']));
										} 
									?>
								</div>
								<?php								
								
							}
							
							$datum = $row['datum'];
							if ($datum != null) {
								$datum = date('d.m.Y', strtotime($row['datum']));
							}
							$zeit = $row['zeit'];
							if ($zeit != null) {
								$zeit = date('H:i', strtotime($row['zeit']));
							}
						?>			
						<div class="col name"><?php echo $name; ?></div>
						<div class="col form"><?php echo $form; ?></div>
						<div class="col datum"><?php  echo $datum; ?></div>
						<div class="col zeit"><?php echo $zeit; ?></div>
						<div class="col ort">
							<a target="_blank" href="https://www.google.de/maps/place/<?php echo str_replace(" ", "+", $row['ort']); ?>"> <?php echo $row['ort']; ?></a>
							<?php 
								if ($row['datum'] != "") {
									$cms->createUpdateIcon("Terminzeit bearbeiten", "terminzeiten", 
										array("datum", "zeit", "ort"), array("date", "text", "text"), array("id" => $row['tzid']), "right: 0px; top: 0;", 11);
									$cms->createDeleteIcon("Terminzeit l&ouml;schen", "terminzeiten", array("id" => $row['tzid']), "right: 35px; top: 0px;", 11);
								}	 
							?>
						</div>
						<div class="clear"></div>
					</div>
					<?php
				} ?>
		</div>
	</div>
	<?php $cms->createNewIcon("Termin hinzuf&uuml;gen", "termine", array("name", "form"), array("text", "text"), "right: 0; bottom: -35px;", 11); ?>
</div>
