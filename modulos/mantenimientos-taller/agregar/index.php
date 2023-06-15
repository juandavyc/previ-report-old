<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Detalles del Mantenimiento - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?=$_SESSION['csrf_token']?>">
    <meta name="csrf-id" content="<?=$_GET['id']?>">
    <link rel="shortcut icon" type="image/jpg" href="/images/favicon.png" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link rel="stylesheet" href="/assets/css/jquery-ui.css" />
    <noscript>
        <link rel="stylesheet" href="/assets/css/noscript.css" />
    </noscript>
    <style>

    </style>

</head>

<body data-id="modulos" class="is-preload landing">
    <?php include 'vista/my_camera.html';?>
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php';?>
        <article id="main">
            <?php require DOCUMENT_ROOT . '/modulos/habeas/habeas_data.html'?>
            <header class="special container">
                <span class="icon solid fas fas fa-wrench"></span>
                <h2>Detalles del Mantenimiento</h2>
                <p><?=htmlspecialchars($_SESSION["session_user"][3]);?></p>
            </header>
            <section class="wrapper style4 container max">
                <div class="row gtr-50 gtr-uniform">

                    <div class="col-12 align-center">
                        <h2 id="form_0_numero_mantenimiento_div"></h2>
                        <h2 id="form_0_mantenimiento_placa">ABC123</h2>
                    </div>
                    <div class="col-12 align-right">
                        <b> Ordenado de A a Z <i class="fas fa-sort-alpha-down"></i></b>
                    </div>
                    <div class="col-12 align-right">
                        <button btn-id="<?php echo htmlspecialchars($_GET['id']); ?>" id="form_0_btn_link_pdf"
                            class="button primary small"> <i class="fas fa-file-pdf"></i> VER PDF </button>
                    </div>
                    <div class="col-12">
                        <div id="mantenimientos_agregar_accordion">
                            <h3 class="accordion-mantenimientos-consulta" data-url="informacion_mecanico_mantenimientos"
                                data-id="1"> Información del mantenimiento</h3>
                            <div id="acordion_mantenimiento_consulta_1">
                                <?php require 'vista/informacion_mecanico_mantenimientos.php';?>
                            </div>
                            <h3 class="accordion-mantenimientos-consulta" data-url="informacion_costos_mantenimiento"
                                data-id="4"> Costos mantenimiento</h3>
                            <div id="acordion_mantenimiento_consulta_4">
                                <?php require 'vista/informacion_costos_mantenimientos.php';?>
                            </div>
                            <h3 class="accordion-mantenimientos-consulta"
                                data-url="informacion_procedimiento_mantenimientos" data-id="2"> Procedimiento realizado
                                en el Mantenimiento</h3>
                            <div id="acordion_mantenimiento_consulta_2">
                                <?php require 'vista/informacion_procedimiento_mantenimientos.php';?>
                            </div>
                            <h3 class="accordion-mantenimientos-consulta" data-url="fotos_mantenimiento" data-id="3">
                                Fotos del mantenimiento</h3>
                            <div id="acordion_mantenimiento_consulta_3">
                                <?php require 'vista/fotos_mantenimiento.php';?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_footer.php';?>
    </div>

    <!-- Scripts -->

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.dropotron.min.js"></script>
    <script src="/assets/js/jquery.scrolly.min.js"></script>
    <script src="/assets/js/jquery.scrollex.min.js"></script>
    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/util.js"></script>
    <script src="/assets/js/jquery.tabs.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/jquery-confirm.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="../../assets/js/main_private.js"></script>
    <script src="../../assets/js/my_camera.js"></script>
    <script src="../../assets/js/my_canvas.js"></script>
    <script type="module" src="controlador/main.js"></script>
    <!--<script src="controlador/habeas.js"></script>-->

</body>

</html>