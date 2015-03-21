<div id="steckbrief">
	<table>
		<?php
			$cms = new cms();
			
			$rows = sqlInterface::getRows("SELECT * FROM steckbrief");
			$i = 0;
			foreach ($rows as $row) { ?>				
				<tr>
					<td class="attr"><?php echo $row['attribut']; ?></td>
					<td class="val"><?php echo $row['wert']; ?></td>
				</tr>									
			<?php } 
		?>		
	</table>	
	<?php
		for ($i = 0; $i < count($rows); $i++) {																
			$top = $i * 45;			
			$cms->createUpdateIcon("Eigenschaft &auml;ndern", "steckbrief", array("attribut", "wert"), array("text", "text"), array("id" => $rows[$i]['id']), "top: ".$top."px; left: 300px;", 3);
			$cms->createDeleteIcon("Eigenschaft l&ouml;schen", "steckbrief", array("id" => $row['id']), "top: ".$top."px; left: 335px;", 3);							 
		}		
	?>
	<div class="place">
		<?php $cms->createNewIcon("Eigenschaft hinzuf&uuml;gen", "steckbrief", array("attribut", "wert"), array("text", "text"), "top: 0; right: 0;", 3); ?>
	</div>
	<div class="works">
		<h4>Workshops</h4>
		<div class="wrapborder">			
			<div class="inner">				
				<?php
					$workrows = sqlInterface::getRows("SELECT * FROM workshops ORDER BY jahr DESC");
					foreach ($workrows as $wrow) { ?>
						<div class="row">
							<div class="col-attr">
								<?php 
									echo $wrow['jahr'];
									$cms->createUpdateIcon("Workshop bearbeiten", "workshops", array("jahr", "event"), array("number", "rtf"), 
										array("id" => $wrow['id']), "left: -35px; top: 0;", 3);
									$cms->createDeleteIcon("Workshop l&ouml;schen", "workshops", array("id" => $wrow['id']), "left: -70px; top: 0;", 3); 
								?>
							</div>
							<div class="col-val"><?php echo $wrow['event']; ?></div>
							<div class="clear"></div>
						</div>
					<?php }
					$cms->createNewIcon("Workshop hinzuf&uuml;gen", "workshops", array("jahr", "event"), array("number", "rtf"), "left: 0; bottom: -50px;", 3);
				?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="zert">
		<h4>Zertifikate u. Auszeichnungen</h4>				
		<div class="inner">				
			<?php
				$zertrows = sqlInterface::getRows("SELECT * FROM zertifikate ORDER BY jahr DESC");
				foreach ($zertrows as $zrow) { ?>
					<div class="row">
						<div class="col-attr">
							<?php 
								echo $zrow['jahr'];
								$cms->createUpdateIcon("Zertifikat bearbeiten", "zertifikate", array("jahr", "zertifikat"), array("number", "rtf"), 
									array("id" => $zrow['id']), "right: -35px; top: 0;", 3);
								$cms->createDeleteIcon("Zertifikat l&ouml;schen", "zertifikate", array("id" => $zrow['id']), "right: -70px; top: 0;", 3); 
							?>
						</div>
						<div class="col-val"><?php echo $zrow['zertifikat']; ?></div>
						<div class="clear"></div>
					</div>
				<?php }
				$cms->createNewIcon("Zertifikat hinzuf&uuml;gen", "zertifikate", array("jahr", "zertifikat"), array("number", "rtf"), "right: 0; bottom: -50px;", 3);
			?>
		</div>		
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="place"></div>
</div>