<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/assets/php/hoja_public_config.php';
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Contáctenos - Hojas de vida</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
	<link rel="shortcut icon" type="image/jpg" href="/images/favicon.png" />
	<link rel="stylesheet" href="/assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="/assets/css/noscript.css" />
	</noscript>
</head>

<body data-id="contactenos" class="is-preload landing">
	<div id="page-wrapper">
		<?php require DOCUMENT_ROOT . '/hoja_menu.php'; ?>
		<article id="main">

			<header class="special container">
				<span class="icon solid fa-mail-bulk"></span>
				<h2>CONTACTANOS</h2>
				<p>Previautos Colombia, Diligencie el siguiente <b>formulario </b> </p>
			</header>
			<section class="wrapper style3 container medium">
				<div class="row gtr-25 gtr-uniform">
					<div class="col-4 col-12-small">
						<div class="row gtr-25 gtr-uniform">
							<div class="col-12 align-center">
								<i class="fas fa-map fa-2x"></i>
								<hr class="hr-text" data-content="CONTACTANOS">
							</div>
							<div class="col-12">
								<b>UBICACIÓN</b>,
								Av.Calle 13 No 96a- 35 Bogotá Fontibón.
								<br />
								<b>LINEA WHATSAPP ATENCIÓN AL CLIENTE</b>,
								(57) 3157004193
								<br />
								<b> CORREO ELECTRÓNICO</b>
								marketingpreviautos@gmail.com
							</div>
						</div>
					</div>
					<div class="col-8 col-12-small">
						<form id="form_contacto_cliente">
							<div class="row gtr-25 gtr-uniform">
								<div class="col-12 align-center">
									<i class="fas fa-table fa-2x"></i>
									<hr class="hr-text" data-content="Formulario de contacto">
								</div>

								<div class="col-3 col-12-small">
									<label class="label-datos-alt"> Asunto</label>
								</div>
								<div class="col-9 col-12-small">
									<div class="input-container">
										<i class="fas fa-question icon-input"></i>
										<select name="asunto">
											<option value="FELICITACION" selected>FELICITACION</option>
											<option value="SUGERENCIA">SUGERENCIA</option>
											<option value="QUEJA">QUEJA</option>
											<option value="RECLAMO">RECLAMO</option>
											<option value="OTRO">OTRO</option>
										</select>
									</div>
								</div>

								<div class="col-3 col-12-small">
									<label class="label-datos-alt"> Nombre completo</label>
								</div>
								<div class="col-9 col-12-small">
									<div class="input-container">
										<i class="fas fa-file-signature icon-input"></i>
										<input type="text" name="nombre_completo" maxlength="25" required="" placeholder="NOMBRE COMPLETO" autocomplete="off">
									</div>
								</div>
								<div class="col-3 col-12-small">
									<label class="label-datos-alt"> Celular</label>
								</div>
								<div class="col-9 col-12-small">
									<div class="input-container">
										<i class="fas fa-mobile-alt icon-input"></i>
										<input type="text" name="celular" maxlength="25" required="" placeholder="CELULAR" autocomplete="off">
									</div>
								</div>
								<div class="col-3 col-12-small">
									<label class="label-datos-alt"> Correo</label>
								</div>
								<div class="col-9 col-12-small">
									<div class="input-container">
										<i class="fas fa-at icon-input"></i>
										<input type="text" name="correo" maxlength="25" required="" placeholder="CORREO" autocomplete="off">
									</div>
								</div>

								<div class="col-3 col-12-small">
									<label class="label-datos-alt"> Mensaje</label>
								</div>
								<div class="col-9 col-12-small">

									<textarea name="mensaje" placeholder="MENSAJE" maxlength="250" required></textarea>
								</div>

								<div class="col-12 align-center">
									<hr class="hr-text" data-content="Opciones">
									<input type="submit" value="ENVIAR" class="primary small fit">
								</div>
							</div>
						</form>
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
	<script src="/assets/js/jquery-confirm.js"></script>
	<script src="/contactenos/controlador/contacto.js"></script>
	<script>
		// $.alert(navigator.userAgent);
	</script>
</body>

</html>