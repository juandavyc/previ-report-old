<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Detalles Taller - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?=$_SESSION['csrf_token']?>">
    <meta name="csrf-id" content="<?=$_GET['id']?>">
    <link rel="shortcut icon" type="image/jpg" href="../../../../images/favicon.png" />
    <link rel="stylesheet" href="../../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../../../assets/css/jquery-ui.css" />
    <noscript>
        <link rel="stylesheet" href="../../../../assets/css/noscript.css" />
    </noscript>
    <style>

    </style>
</head>

<body data-id="modulos">
    <?php include 'vista/my_camera.html';?>
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hoja_menu.php';?>
        <article id="main">
        <?php require DOCUMENT_ROOT . '/clientes/supervisor/habeas/habeas_data.html';?>
            <header class="special container">
                <span class="icon solid fa-industry"></span>
                <h2>Detalles del Taller</h2>
                <p><?=htmlspecialchars($_SESSION["session_user"][3]);?></p>
            </header>
            <section class="wrapper style4 container max">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-7 col-12-small">
                        <a href="../visor/" class="button icon solid fa-long-arrow-alt-left"> Volver al
                            visor</a>
                    </div>
                    <div class="col-5 col-12-small">
                        <aside class="note-wrap note-yellow ">
                            Señor usuario si la información suministrada <b>no corresponde</b>, por favor
                            comuníquese
                            con soporte técnico.
                        </aside>
                    </div>
                    <!-- start accordion -->
                    <div class="col-12 align-center">
                        <h2 id="form_0_numero_taller_div"></h2>
                        <h3 id="form_0_nombre_taller_div"></h3>
                        <h4 id="form_0_nit_taller_div"></h4>
                    </div>
                    <div class="col-12">
                        <div id="vehiculo_agregar_accordion">
                            <h3 class="accordion_consulta" data-id="0"> Información del Taller</h3>
                            <div id="accordion_consulta_0">
                                <?php require 'vista/form_informacion_taller.html';?>
                            </div>
                        </div>
                    </div>
                    <!-- end accordion -->
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hoja_footer.php';?>
    </div>

    <!-- Scripts -->

    <script src="../../../../assets/js/jquery.min.js"></script>
    <script src="../../../../assets/js/jquery.dropotron.min.js"></script>
    <script src="../../../../assets/js/jquery.scrolly.min.js"></script>
    <script src="../../../../assets/js/jquery.scrollex.min.js"></script>
    <script src="../../../../assets/js/browser.min.js"></script>
    <script src="../../../../assets/js/breakpoints.min.js"></script>
    <script src="../../../../assets/js/util.js"></script>
    <script src="../../../../assets/js/main.js"></script>
    <script src="../../../../assets/js/jquery-confirm.js"></script>
    <script src="../../../../assets/js/jquery-ui.min.js"></script>
    <script src="../../../../assets/js/jquery.viewbox.min.js"></script>
    <script src="../../../assets/js/main_private.js"></script>
    <script src="../../../assets/js/my_camera.js"></script>
    <script src="../../../assets/js/my_canvas.js"></script>
    <script type="module" src="controlador/main.js"></script>
    <script src="controlador/habeas.js"></script>
    <script>
    // $.alert("xx");
    </script>
</body>

</html>