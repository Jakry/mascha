<div id="buehne">
	<div class="wrapbuehne">
		<?php 
			$cms = new cms();
			
			$index = 0;
			$rows = sqlInterface::getRows("SELECT * FROM buehne ORDER BY datum DESC");
			foreach ($rows as $row) { ?>
				<div class="brow">
					<div class="bcol">
						<h3><?php echo $row['titel']; ?></h3>
						<div class="picslider">
							<div class="bigpic">
								<?php $cms->createNewIcon("B&uuml;hnenbild hinzuf&uuml;gen", "buehnenbilder", array("bild", "thumb"), array("file", "file"), "top:0;right:0;", 6, array("pid" => $row['id'])); ?>
								<div class="wrapbigpics">
									<?php
										$picRows = sqlInterface::getRows("SELECT * FROM buehnenbilder WHERE pid=? ORDER BY id", array($row['id']));									
										foreach ($picRows as $picRow) { ?>
											<div class="wrapfancy">
												<a class="fancyme" href="<?php echo $picRow['bild']; ?>">
													<img src="<?php echo $picRow['thumb']; ?>">												
												</a>					
												<?php $cms->createDeleteIcon("B&uuml;hnenbild l&ouml;schen", "buehnenbilder", array("id" => $picRow['id']), "top:0; left: 0;", 6); ?>
											</div>			
										<?php }							
									?>
								</div>
							</div>
							<div class="picslist">
								<a class="parrow up" href="javascript:;"></a>
								<a class="parrow down" href="javascript:;"></a>
							</div>						
						</div>
					</div>
					<div class="bcol">
						<div class="btxt">
							<h4>Beschreibung</h4>			
							<?php echo $row['beschreibung']; ?>
						</div>
					</div>
					<div class="bcol">
						<div class="btxt">
							<h4>Kritik</h4>						
							<?php echo $row['kritik']; ?>
						</div>
					</div>
					<div class="clear"></div>
					<?php $cms->createUpdateIcon("St&uuml;ck bearbeiten", "buehne", array("titel", "beschreibung", "kritik"), array("text", "rtf", "rtf"), array("id" => $row['id']), "right: 0; bottom: 35px;", 6); ?>
					<?php $cms->createDeleteIcon("St&uuml;ck l&ouml;schen", "buehne", array("id" => $row['id']), "right: 0; bottom: 0px;", 6); ?>
				</div>
				<?php
					if (++$index < count($rows)) { ?>
						<div class="bline"></div>		
					<?php }  			
				?>
			<?php }				
			$cms->createNewIcon("St&uuml;ck hinzuf&uuml;gen", "buehne", array("titel", "beschreibung", "kritik", "datum"), array("text", "rtf", "rtf", "date"), "right: 0; top: 0px;", 6);
		?>
	</div>
	<a href="javascript:;" class="arrow down"></a>
</div>
