<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/assets/php/hoja_public_config.php';
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Quienes somos - Hojas de vida</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
	<link rel="shortcut icon" type="image/jpg" href="/images/favicon.png" />
	<link rel="stylesheet" href="/assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="/assets/css/noscript.css" />
	</noscript>
</head>

<body data-id="quienes-somos" class="is-preload landing">
	<div id="page-wrapper">
		<?php require DOCUMENT_ROOT . '/hoja_menu.php'; ?>
		<article id="main">
			<header class="special container">
				<span class="icon solid fa-briefcase"></span>
				<h2>Quienes somos</h2>
				<p>CENTRO INTEGRAL DE SERVICIO AUTOMOTRIZ</p>
			</header>
			<section class="wrapper style3 container medium">
				<div class="row gtr-25 gtr-uniform">
					<div class="col-6 col-12-small">
						<label class="label-important label-datos-alt"> Marca</label>
						<div class="input-container">
							<i class="fas fa-code-branch icon-input"></i>
							<div class="autocomplete-container">
								<input type="text" id="ingreso-marca-text" value="" placeholder="Marca" autocomplete="off" style="height: 35px;">
								<div class="icon-container">
									<i class="loader"></i>
								</div>
								<input type="hidden" name="marca" id="ingreso-marca-select" value="1" data-default="1">
							</div>
						</div>
					</div>
				</div>
			</section>
		</article>
		<?php require DOCUMENT_ROOT . '/hoja_footer.php'; ?>
	</div>
	<!-- Scripts -->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/jquery.dropotron.min.js"></script>
	<script src="/assets/js/jquery.scrolly.min.js"></script>
	<script src="/assets/js/jquery.scrollex.min.js"></script>
	<script src="/assets/js/browser.min.js"></script>
	<script src="/assets/js/breakpoints.min.js"></script>
	<script src="/assets/js/util.js"></script>
	<script src="/assets/js/main.js"></script>
</body>
</html>