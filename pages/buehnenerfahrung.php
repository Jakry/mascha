<div id="berfahrung">
	<?php
		$cms = new cms();		
				
		$rows = sqlInterface::getRows("SELECT * FROM buehnenerfahrung ORDER BY id DESC");
		$i = 0;
		foreach ($rows as $row) { ?>
			<div class="row">
				<?php
					$cms->createUpdateIcon("B&uuml;hnenerfahrung bearbeiten", "buehnenerfahrung", array("text"), array("rtf"), array("id" => $row['id']), "left: -35px; top: 0;", 4);
					$cms->createDeleteIcon("B&uuml;hnenerfahrung l&ouml;schen", "buehnenerfahrung", array("id" => $row['id']), "left: -70px; top: 0;", 4);
				?>
				
				<div class="logo"><img src="<?php echo $row['jahreslogo'] ;?>"></div>
				<div class="btext"><?php echo $row['text']; ?></div>
				<div class="clear"></div>
			</div>
			
			<?php 
			if ($i + 1 < count($rows)) { ?>
				<div class="footline"></div>
			<?php }
			$i++;
		}
		
		$cms->createNewIcon("B&uuml;hnenerfahrung hinzuf&uuml;gen", "buehnenerfahrung", 
			array("jahreslogo", "text"), array("file", "rtf"), "bottom: 0; right: 0;", 4);
	?>
</div>
