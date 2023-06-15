<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/administrador/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Detalles Vehículo - Hojas de vida</title>
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
        <?php require DOCUMENT_ROOT . '/clientes/administrador/assets/php/hoja_menu.php';?>
        <article id="main">
            <?php require DOCUMENT_ROOT . '/clientes/administrador/habeas/habeas_data.html';?>
            <header class="special container">
                <span class="icon solid fa-car-alt"></span>
                <h2>Detalles del vehículo</h2>
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
                    <!-- start accordion -->
                    <div class="col-12 align-center">
                        <h2 id="form_0_numero_vehiculo_div"></h2>
                        <h3 id="form_0_clase_vehiculo_div"></h3>
                        <div class="vh-placa" id="form_0_placa"></div>
                    </div>
                    <div class="col-12 align-right">
                        <b> Ordenado de A a Z <i class="fas fa-sort-alpha-down"></i></b>
                    </div>
                    <div class="col-12 align-right">
                        <button btn-id="<?=$_GET['id']?>" id="form_0_btn_link_pdf" class="button primary small"> <i
                                class="fas fa-file-pdf"></i> VER PDF </button>
                    </div>
                    <div class="col-12">

                        <div id="vehiculo_agregar_accordion">
                            <h3 class="accordion_vehiculo_consulta" data-id="1"> Información del vehículo</h3>
                            <div id="accordion_vehiculo_consulta_1">
                                <?php require 'vista/form_informacion_vehiculo.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="8"> Certificados</h3>
                            <div id="accordion_vehiculo_consulta_8">
                                <?php require 'vista/form_certificados.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="4"> Datos Técnicos del Vehículo</h3>
                            <div id="accordion_vehiculo_consulta_4">
                                <?php require 'vista/form_datos_tecnicos_del_vehiculo.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="10"> Fotografías del vehículo</h3>
                            <div id="accordion_vehiculo_consulta_10">
                                <?php require 'vista/form_fotografias_vehiculo.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="11"> Improntas del vehículo</h3>
                            <div id="accordion_vehiculo_consulta_11">
                                <?php require 'vista/form_improntas_vehiculo.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="12"> Licencia de transito</h3>
                            <div id="accordion_vehiculo_consulta_12">
                                <?php require 'vista/form_licencia_transito.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="7"> Pólizas</h3>
                            <div id="accordion_vehiculo_consulta_7">
                                <?php require 'vista/form_polizas.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="5"> Revisiones Preventivas</h3>
                            <div id="accordion_vehiculo_consulta_5">
                                <?php require 'vista/form_revision_preventiva.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="2"><b>( RTM )</b> Certificado de
                                revisión
                                técnico mecánica
                                y de emisiones contaminantes </h3>
                            <div id="accordion_vehiculo_consulta_2">
                                <?php require 'vista/form_certificado_rtm.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="3"><b>( SOAT )</b> Póliza Seguro
                                Obligatorio de Accidentes de Tránsito </h3>
                            <div id="accordion_vehiculo_consulta_3">
                                <?php require 'vista/form_poliza_soat.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="9"> Solicitudes</h3>
                            <div id="accordion_vehiculo_consulta_9">
                                <?php require 'vista/form_solicitudes.html';?>
                            </div>
                            <h3 class="accordion_vehiculo_consulta" data-id="6"> Tarjeta de Operación</h3>
                            <div id="accordion_vehiculo_consulta_6">
                                <?php require 'vista/form_tarjeta_de_operacion.html';?>
                            </div>
                        </div>
                    </div>
                    <!-- end accordion -->
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/clientes/administrador/assets/php/hoja_footer.php';?>
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