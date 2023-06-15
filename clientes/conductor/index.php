<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/conductor/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Inicio - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="../../images/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
        <link rel="stylesheet" href="../../assets/css/jquery-ui.css" />
    <noscript>
        <link rel="stylesheet" href="../../assets/css/noscript.css" />
    </noscript>
</head>

<body data-id="inicio">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/clientes/conductor/assets/php/hoja_menu.php'; ?>
        <article id="main">
            <?php require DOCUMENT_ROOT . '/clientes/conductor/habeas/habeas_data.html'; ?>
            <header class="special container">
                <span class="icon solid fa-laugh-beam"></span>
                <h2>INICIO</h2>
                <p><?= htmlspecialchars($_SESSION["session_user"][3]); ?></p>
            </header>

            <section class="wrapper style4 container small">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12 align-center">
                        <span style='font-size:44px; border-bottom: 3px solid #FFB900; padding-bottom: 6px;'>
                            &#128662;&#128653;&#128664;&#128757; </span>
                    </div>
                    <div class="col-12 align-center">
                        <h3> Bienvenido, ¿Qué desea hacer? </h3>
                    </div>
                   
                    <div class="col-6 col-12-small">
                        <a href="/clientes/conductor/siniestros/visor/" class="button primary small fit"> REGISTRAR SINIESTRO</a>
                    </div>
                    <div class="col-6 col-12-small">
                    <a href="/clientes/conductor/preoperacional-super/visor/" class="button primary small fit"> REGISTRAR PREOPERATIVO</a>
                    </div>
                     <div class="col-12 align-center">
                        <br>
                        <hr>
                        <h4>¿Tiene alguna duda?</h4>
                        <p> Nuestro equipo de profesionales está listo para atenderte </p> <a href="https://previreport.com/contacto_cliente/" class="button small icon solid fa-phone-alt">
                        Contáctenos</a>
                    </div>
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/clientes/conductor/assets/php/hoja_footer.php'; ?>
    </div>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/jquery.dropotron.min.js"></script>
    <script src="../../assets/js/jquery.scrolly.min.js"></script>
    <script src="../../assets/js/jquery.scrollex.min.js"></script>
    <script src="../../assets/js/browser.min.js"></script>
    <script src="../../assets/js/breakpoints.min.js"></script>
    <script src="../../assets/js/jquery-ui.min.js"></script>
    <script src="../../assets/js/util.js"></script>
    <script src="../../assets/js/main.js"></script>
    <script src="../../assets/js/jquery-confirm.js"></script>
    <script src="../../assets/js/jquery.tabs.js"></script>
    <script src="assets/js/my_canvas.js"></script>
    <script src="assets/js/main_private.js"></script>
    <script src="assets/js/habeas.js"></script>
    <script>

    </script>
</body>

</html>