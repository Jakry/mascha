<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
"http://www.w3.org/TR/html4/frameset.dtd">

<?php
require 'objects/sqlInterface.php';

$pageid = 1;
if (isset($_GET['id'])) {
	$pageid = $_GET['id'];	
}
$pageRow = sqlInterface::getRow("SELECT * FROM struktur WHERE id=$pageid;");
if ($pageRow == null) {
	echo "invalid url";
	exit();
}

$parentRow = $pageRow;
if ($pageRow['pid'] != null) {	
	$parentRow = sqlInterface::getRow("SELECT * FROM struktur WHERE id=".$pageRow['pid'].";");	
}
?>

<html>
	
	<head>		
		<title>Mascha Obermeier</title>		
		<script src="cms/lib/slickgrid/lib/jquery-1.7.min.js"></script> <!-- Slickgrid - das im CMS verwendet wird - benötigt aktuell diese JQUERY-Version --> 		
		<!-- Libaries -->
		<script src="lib/jplayer/jquery.jplayer.min.js"></script>
		<script src="lib/mediaelement/build/mediaelement-and-player.min.js"></script>
		<link rel="stylesheet" href="lib/mediaelement/build/mediaelementplayer.min.css">		
		<script src="lib/fancybox/jquery.fancybox.pack.js"></script>
		<link rel="stylesheet" href="lib/fancybox/jquery.fancybox.css">
		
		
		<script src="js/main.js"></script>
		<script src="js/search.js"></script>			
		
		<?php 
			require 'cms/objects/cms.php';
			$cmsobj = new cms();
			$cmsobj->insertFiles();			 
		?>
		
		<link rel="stylesheet" href="style/main.css">
		
		<link rel="stylesheet" href="style/<?php echo $parentRow['name']; ?>.css">
		<script src="js/<?php echo $parentRow['name'] ?>.js"></script>	
	</head>
	
	<body>					
		<div id="banner">
			<div id="menu">
				<div id="centermenu">
					<ul class="main">
						<?php
							$rows = sqlInterface::getRows("SELECT * FROM struktur WHERE pid is NULL AND hidden = 0 ORDER BY sort");
							foreach ($rows as $row) {
								$active = '';
								if ($row['id'] == $parentRow['id']) {
									$active = 'class="active"';
								}
								echo '<li><a '.$active.' href="?id='.$row['id'].'">'.$row['anzeigename'].'</a>';
								$subrows = sqlInterface::getRows("SELECT * FROM struktur WHERE pid=? AND hidden=0 ORDER BY sort", array($row['id']));
								if (count($subrows) > 0) {
									echo '<ul class="sub">';
									foreach ($subrows as $subrow) {
										echo '<li><a href="?id='.$subrow['id'].'#'.$subrow['name'].'">'.$subrow['anzeigename'].'</a></li>';
									}								
									echo '</ul>';
								}
								echo '</li>';
							}							
						?>
						<li class="lastwithglass"><form id="search"><input type="text" /></form><a id="glass" href="javascript:void(0)"></a></li>
					</ul>
				</div>
			</div>						
			<div id="backimagecontainer">
				<div id="imagebanner">
					<img id="backimage" src="<?php echo $parentRow['bild']; ?>" rel="0">
				</div>										
			</div>						
		</div>							
		<div id="content">
			<?php
				if ($parentRow['inhalt'] == 1) { ?>
					<div class="innercontent">
						<?php require 'pages/'.$parentRow['name'].'.php'; ?>
					</div>
				<?php }
				$subrows = sqlInterface::getRows("SELECT * FROM struktur WHERE pid=? AND hidden=0 ORDER BY sort", array($parentRow['id']));				
				foreach ($subrows as $subrow) {
					if ($subrow['inhalt'] == 1) { ?>										
						<div class="pagetitle">							
							<div class="centerh2">
								<h2><?php echo $subrow['anzeigename']; ?></h2>
							</div>
							<div class="titleline"></div>
						</div>					
						<div class="innercontent">																	
							<?php require 'pages/'.$subrow['name'].'.php'; ?>
						</div>	
					<?php }
				}
			?>
		</div>		
		<div id="footer">
			<div id="footercontent">
				<div id="footstruct">
					<div class="footcol">
						<h5>Rubriken</h5>
						<ul>
							<?php
								$structRows = sqlInterface::getRows("SELECT * FROM struktur WHERE id>1 AND pid IS NULL ORDER BY sort");							
								foreach ($structRows as $structRow) {
									if ($structRow['id'] != 12 && $structRow['hidden'] == 0) { // Außer Kontakt
										?>								
										<li><a href="?id=<?php echo $structRow['id']; ?>"><?php echo $structRow['anzeigename'] ?></a>
										<?php
											$structSubRows = sqlInterface::getRows("SELECT * FROM struktur WHERE pid=? ORDER BY sort", array($structRow['id']));
											if (count($structSubRows) > 0) { ?>
												<ul>
												<?php
													foreach ($structSubRows as $structSubRow) { ?>
														<li><a href="?id=<?php echo $structSubRow['id']; ?>"><?php echo $structSubRow['anzeigename'] ?></a></li>
														<?php
													} ?>
												</ul>
												<?php
											}
										?>
										</li>
										<?php
									}
								}
							?>
						</ul>
					</div>	
					<div class="footcol right">
						<h5>St&uuml;cke</h5>
						<ul>
							<?php
								$buhnenRows = sqlInterface::getRows("SELECT * FROM buehne ORDER BY datum");							
								foreach ($buhnenRows as $buhnenRow) { ?>								
									<li><a href="?id=9"><?php echo $buhnenRow['titel'] ?></a></li>																			
								<?php }
							?>
						</ul>
					</div>
					<div class="footcol middle">
						<h5>Empfehlungen</h5>
						<ul>
							<li><a href="#">Theater Sommerhausen</a></li>
							<li><a href="#">Theater Giebelstadt</a></li>
						</ul>
					</div>
					<div class="logo">
						<img src="style/images/Logo.png" />
					</div>					
					<div class="clear"></div>
				</div>				
				<div class="footline"></div>
				<div id="impdat">
					<div>
						<a href="?id=15">Impressum</a>&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; 
						<a href="?id=16">Datenschutz</a>&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
						<a href="">Kontakt</a>&nbsp;&nbsp;&nbsp;
					</div>
				</div>			
			</div>
		</div>
	</body>	
</html>