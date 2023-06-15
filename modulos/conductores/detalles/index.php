<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Detalles del Conductor - Hojas de vida</title>
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
                <span class="icon solid far fa-user"></span>
                <h2>Detalles del Conductor</h2>
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
                            Señor usuario si la información suministrada <b>NO CORRESPONDE</b>, por favor
                            comuníquese
                            con soporte técnico.
                        </aside>
                    </div>

                    <?php //require 'vista/modal/modal_agregar_vehiculo.html'; ?>
                    <?php // require 'vista/modal/modal_agregar_empresa.html'; ?>

                    <div class="col-12 align-center">
                        <h2 id="form_0_numero_conductor_div"></h2>
                        <h3 id="form_0_documento_conductor_div"></h3>
                        <h4 id="form_0_nombre_conductor_div"></h4>
                    </div>
                    <div class="col-12 align-right">
                        <b> Ordenado de A a Z <i class="fas fa-sort-alpha-down"></i></b>
                    </div>
                    <div class="col-12">
                        <div id="conductor_agregar_accordion">
                            <h3 class="accordion-conductor-consulta" data-url="informacion_basica_conductor"
                                data-id="1"> Información del conductor</h3>
                            <div id="acordion_conductor_consulta_1">
                                <?php require 'vista/informacion_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="4"><b> ( ARL ) </b>Administradoras de
                                Riesgos Laborales</h3>
                            <div id="acordion_conductor_consulta_4">
                                <?php require 'vista/informacion_arl_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="10"> Capacitaciones</h3>
                            <div id="acordion_conductor_consulta_10">
                                <?php require 'vista/informacion_capacitaciones_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="7"> Comparendos, multas y/o sanciones
                            </h3>
                            <div id="acordion_conductor_consulta_7">
                                <?php require 'vista/informacion_comparendos_multas_sanciones.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="2"> Contactos de emergencia</h3>
                            <div id="acordion_conductor_consulta_2">
                                <?php require 'vista/informacion_contacto_emergencia_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="13"> Contrato(s) </h3>
                            <div id="acordion_conductor_consulta_13">
                                <?php require 'vista/asignar_empresa_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="9"> Cursos </h3>
                            <div id="acordion_conductor_consulta_9">
                                <?php require 'vista/informacion_cursos_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="3"> <b> ( EPS )</b> Entidades Promotoras
                                de Salud</h3>
                            <div id="acordion_conductor_consulta_3">
                                <?php require 'vista/informacion_eps_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="8"> Examenes Ocupacionales</h3>
                            <div id="acordion_conductor_consulta_8">
                                <?php require 'vista/informacion_examenes_ocupacionales.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="5"> Fondo de pensión </h3>
                            <div id="acordion_conductor_consulta_5">
                                <?php require 'vista/informacion_fondo_pension_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="11"> Incapacidades </h3>
                            <div id="acordion_conductor_consulta_11">
                                <?php require 'vista/informacion_incapacidades_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="6"> Licencia de conduccion</h3>
                            <div id="acordion_conductor_consulta_6">
                                <?php require 'vista/informacion_licencia_conductor.php';?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="12"> Vehiculo Asignado</h3>
                            <div id="acordion_conductor_consulta_12">
                                <?php require 'vista/informacion_vehiculo_conductor.php';?>
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
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/jquery-confirm.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/js/excanvas.js"></script>
    <script src="../../assets/js/main_private.js"></script>
    <script src="../../assets/js/my_canvas.js"></script>
    <script src="../../assets/js/my_camera.js"></script>
    <script type="module" src="controlador/main.js"></script>
    

</body>

</html>