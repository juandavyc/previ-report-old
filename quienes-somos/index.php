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

	<style>
		.image.left {
			float: left;
			top: 0.25em;
		}
		.image.right {
			float: right;
			top: 0.25em;
		}

		.image.left img,
		.image.right img {
			width: 100%;
		}

		.image img {
			border-radius: 0.375em;
			display: block;
		}
	</style>
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
				<p>
					<span class="image left">
						<img src="/images/fachada.jpg" alt="">
					</span>
					<b> PREVIAUTOS S.A.S</b> <br />
					<i>CENTRO INTEGRAL DE SERVICIO AUTOMOTRIZ</i> <br />
					Es una empresa colombiana comprometida al 100% con la seguridad vial,
					que brinda servicios integrales al sector de transporte público y privado. Además,
					apoya a los organismos de control y vigilancia para cumplir con la normatividad vigente,
					como decretos, leyes, resoluciones y circulares,
					alentando buenos hábitos de comportamiento en la carretera para todos los actores viales.
					<br /><br /> 
					<span class="image right">
						<img src="/images/principal.jpg" alt="">
					</span>
					Con este fin, hemos diseñado un <b>amplio portafolio</b> de servicios que incluye apoyo
					administrativo y operativo para empresas públicas, privadas y personas naturales.
					<br />
					Nuestro objetivo es convertirnos en la empresa líder en <b>Colombia</b> en la promoción de servicios que
					fomenten la prevención de accidentes, conductas seguras, buenos hábitos y comportamientos en las vías.
				</p>
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