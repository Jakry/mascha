<div id="stimme">
	<?php 
		$cms = new cms();
	
		$index = 0;
		$rows = sqlInterface::getRows("SELECT * FROM stimme ORDER BY datum DESC");		
		foreach ($rows as $row) { ?>
			<div class="audiofield">		
				<div class="player">	
					<?php $cms->createUpdateIcon("Titel &auml;ndern", "stimme", array("titel"), array("text"), array("id" => $row['id']), "top: 0; left: 0;", 10) ?>
					<?php $cms->createDeleteIcon("Stimme l&ouml;schen", "stimme", array("id" => $row['id']), "top: 35px; left: 0;", 10) ?>
					<div id="jquery_jplayer_<?php echo $index; ?>" class="jp-jplayer" music="<?php echo $row['audio']; ?>"></div>  
					<div id="jp_container_<?php echo $index++; ?>" class="jp-audio">  
						<div class="jp-type-single">  
					  		<div class="jp-background">
					  			<div class="cont"></div>					    			
					    	</div>
					    	<div class="jp-title">  
					      		<ul>  
					        		<li><?php echo $row['titel']; ?></li>  
					      		</ul>  
					    	</div>  					  		
					    	<div class="jp-gui jp-interface">
					    		<div class="jp-controls">
						        	<div class="jp-play"></div>
						        	<div class="jp-pause"></div>   
						        </div>  
					  			<div class="jp-progress">  
							        <div class="jp-seek-bar">  
							        	<div class="jp-play-bar">
							        		<div class="linebut"></div>
							        	</div>  
							        </div>  
						        </div>  
						  		<div class="jp-time-holder">  
						        	<span class="jp-current-time"></span> / 
						        	<span class="jp-duration"></span>
						        </div>
					  			<div class="jp-no-solution">  
							    	<span>Update Required</span>  
							      	To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.  
							    </div>  
					  		</div>  
						</div>
					</div>
				</div>		
			</div>
		<?php }
		$cms->createNewIcon("Stimme hinzuf&uuml;gen", "stimme", array("titel", "audio", "datum"), array("text", "file", "date"), "bottom: 0; right: 0;", 10);
	?>	
	<div class="clear"></div>
</div>
