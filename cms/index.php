<html>
	<head>
		<link rel="stylesheet" href="style/cms.css">
	</head>
	<body>
		<div class="logincontent">
			<?php
				if (isset($_GET['fail'])) { ?>
					<div class="fail">
						Benutzername oder Passwort falsch
					</div>
				<?php }
			?>
			<form action="posts/login.php" method="post">				
				<div class="fieldset">
					<span>Benutzername</span>
					<input type="text" name="benutzer" />
					<div class="clear"></div>					
				</div>
				<div class="fieldset">
					<span>Passwort</span>
					<input type="password" name="passwort" />
					<div class="clear"></div>		
				</div>
				<input type="submit" value="Einloggen" />
				<div class="clear"></div>
			</form>
		</div>
	</body>
</html>