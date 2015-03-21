<div id="film">
	<?php
		$cms = new cms();
	
		$rows = sqlInterface::getRows("SELECT * FROM film ORDER BY id DESC");
		$i = 0;
		foreach ($rows as $row) { ?>
			<div class="wrapvid">		
				<?php $cms->createDeleteIcon("Film l&ouml;schen?", "film", array("id" => $row["id"]), "left: 0; top: 0;", 8); ?>
				<?php echo $row['frame']; ?>		
			</div>			
		<?php }
		
		$cms->createNewIcon("Film hinzuf&uuml;gen", "film", array("frame"), array("rtf"), "bottom: 0; right: 0;", 8);
	?>
	
</div>
