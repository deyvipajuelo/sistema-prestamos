<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo(COMPANY) ?></title>

    <?php include('./Views/partials/css.php') ?>

</head>
<body>

	<?php
		$peticionAjax = false;
		$vc = new ViewsControllers();
		$vista = $vc->getViewsController();
		if ($vista === 'login' || $vista === '404') {
			include('./Views/contents/'.$vista.'-view.php');
		}else {
			session_start(['name'=>'SPM']);
	?>	
	
	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
        <?php include('./Views/partials/sidebar.php') ?>
		
		<!-- Page content -->
		<section class="full-box page-content">
			
			<?php 
				include('./Views/partials/navbar.php');
				include($vista);
			?>

		</section>
	</main>
	
    <?php
		}
		include('./Views/partials/script.php');
	?>
</body>
</html>