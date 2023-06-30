<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Documentos / Conductores - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="/images/favicon.png" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link rel="stylesheet" href="/assets/css/jquery-ui.css" />
    <noscript>
        <link rel="stylesheet" href="/assets/css/noscript.css" />
    </noscript>
    <style>
        /* table.alt tbody tr td:nth-child(5) { */
        table.alt tbody tr td:nth-child(2),
        table.alt tbody tr td:nth-last-child(2) {
            font-weight: bold;
        }

        table.alt thead tr th:nth-child(1) {
            min-width: 50px;
            max-width: 50px;
        }

        table.alt thead tr th:nth-child(2) {
            width: 250px;
        }

        table.alt thead tr th:nth-last-child(2) {
            width: 200px;
        }

        table.alt th:last-child {
            width: 100px !important;
            max-width: 100px !important;
            min-width: 100px !important;
        }
    </style>
</head>

<body data-id="documentos" class="is-preload landing">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php'; ?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-folder-open"></span>
                <h2>Documentos / Conductores</h2>
                <p><?= htmlspecialchars($_SESSION["session_user"][3]); ?></p>
            </header>
            <section class="wrapper style4 container max" style="padding: 2em;">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-6 col-12-small">
                        <?php require 'vista/tabla-contenido.php'; ?>
                    </div>
                    <div class="col-6 col-12-small">
                        <?php require 'vista/instrucciones.php'; ?>
                    </div>
                    <div class="col-12">
                        <?php require 'vista/buscador.php'; ?>
                    </div>
                    <div class="col-12">
                        <div id="container-arl"></div>
                        <div id="container-contacto"></div>
                        <div id="container-eps"></div>
                        <div id="container-incapacidad"></div>
                        <div id="container-capacitacion"></div>
                        <div id="container-contrato"></div>
                        <div id="container-examen"></div>
                        <div id="container-licencia"></div>
                        <div id="container-comparendo"></div>
                        <div id="container-cursos"></div>
                        <div id="container-fondo"></div>
                    </div>
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_footer.php'; ?>
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
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/modulos/assets/js/main_private.js"></script>
    <script src="controlador/main.js" type="module"></script>


</body>

</html>