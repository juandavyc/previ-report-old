<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/conductor/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Documentación - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?=$_SESSION['csrf_token']?>">
    <link rel="shortcut icon" type="image/jpg" href="../../images/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="../../assets/css/noscript.css" />
    </noscript>
    <style>
    .ol-mapa {
        counter-reset: item;
        margin: 0px;
    }

    .ol-mapa li {
        display: block
    }

    .ol-mapa li:before {
        content: counters(item, ".") ". ";
        counter-increment: item
    }

    .video-container {
        padding-top: 56.25%;
        height: 0px;
        position: relative;
    }

    #video-title {
        background: #4B4B4B;
        border-radius: 4px;
        margin-bottom: 4px;
        color: #FFF;
        font-weight: bold;
    }

    .video {
        border-radius: 4px;
        box-shadow: 0 0 5px #4B4B4B;
        border: 5px solid #4B4B4B;
        background: #F5F5F5;
        width: 100%;
        height: 95%;
        position: absolute;
        top: 0px;
        left: 0;
    }



    #listado-videos ul,
    #listado-videos ol {
        margin: 0px;
    }

    .li-video {
        border-bottom: 1px dotted;
    }

    .li-video:hover {
        background-color: #F7F7F7;
        cursor: pointer;
    }
    </style>
</head>

<body data-id="documentacion">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/clientes/conductor/assets/php/hoja_menu.php';?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-question-circle"></span>
                <h2>Documentación </h2>
                <p><?=htmlspecialchars($_SESSION["session_user"][3]);?></p>
            </header>
            <section class="wrapper style4 container medium" style="padding: 2em;">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-4 col-12-small">
                        <hr class="hr-text-alt" data-content="Mapa del sitio">
                        <ol class="ol-mapa">
                            <li> <a href="<?=ROOT?>/clientes/conductor/">Inicio</a> </li>
                            <li> <a href="<?=ROOT?>/clientes/conductor/documentacion.php">Documentacion </a></li>
                            <li> Modulos</li>
                            <ol class="ol-mapa">
                                <li>
                                    <a href="<?=ROOT?>/clientes/conductor/siniestros/visor/">Siniestro
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=ROOT?>/clientes/conductor/preoperacional-super/visor/">Preoperacional
                                    </a>
                                </li>
                            </ol>
                            <li> Mi cuenta</li>
                            <ol class="ol-mapa">
                                <li>
                                    <a id="cerrar_sesion_act" name="cerrar_sesion_act"
                                        href="<?=ROOT?>/clientes/conductor/cerrar.php">Cerrar
                                        sesion</a>
                                </li>
                            </ol>
                        </ol>
                    </div>
                    <div class="col-8 col-12-small">
                        <hr class="hr-text-alt" data-content="Condiciones de documentación">
                        <div class="row gtr-50 gtr-uniform">
                            <div class="col-3 col-12-small">
                                <label class="label-datos">
                                    fecha de entrega
                                </label>
                            </div>
                            <div class="col-9 col-12-small">
                                <label class="label-resultados"> 24 / DIC / 2021 </label>
                            </div>
                            <div class="col-3 col-12-small">
                                <label class="label-datos">
                                    Desarrolladores
                                </label>
                            </div>
                            <div class="col-9 col-12-small">
                                <label class="label-resultados">
                                    Juan Yara Cifuentes <br>
                                    Yeferson Devia Diaz <br>
                                    Esteban Sanchez Carvajal
                                </label>
                            </div>
                            <div class="col-3 col-12-small">
                                <label class="label-datos">
                                    Aclaración
                                </label>
                            </div>
                            <div class="col-9 col-12-small">
                                <p>Esta documentación se entrega bajo los
                                    requerimientos
                                    establecidos con fecha de
                                    entrega
                                    <b>(24 / DIC /
                                        2021)</b>, los módulos añadidos después del <b>(24 / DIC / 2021)</b>, es
                                    probable
                                    que no
                                    tengan documentación.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr class="hr-text-alt" data-content="Documentación en video">
                        <div class="row gtr-50 gtr-uniform">
                            <div class="col-3 col-12-small">
                                <label class="label-datos"> <b>Ver documentación de: </b></label>
                            </div>
                            <div class="col-9 col-12-small">
                                <div class="input-container">
                                    <i class="fas fa-list icon-input"></i>
                                    <select id="tipo-video-select" required="">
                                        <option value="0" selected>Inicio</option>
                                        <option value="1" disabled>Documentacion</option>
                                        <optgroup label="Modulos">
                                            <option value="6">Siniestro</option>
                                            <option value="8">Preoperacional</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 col-12-small">
                                <div id="listado-videos">
                                    <label class="icon solid fa-video"> inicio</label>
                                    <ul>
                                        <li>Sin video</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-9 col-12-small align-center">
                                <div id="video-title"> </div>
                                <div class="video-container">
                                    <video class="video" id="video-player" poster="documentacion/sources/portada.jpg"
                                        controls>
                                        <source src="documentacion/sources/video_demo.mp4" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/clientes/mecanico/assets/php/hoja_footer.php';?>
    </div>

    <!-- Scripts -->

    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/jquery.dropotron.min.js"></script>
    <script src="../../assets/js/jquery.scrolly.min.js"></script>
    <script src="../../assets/js/jquery.scrollex.min.js"></script>
    <script src="../../assets/js/browser.min.js"></script>
    <script src="../../assets/js/breakpoints.min.js"></script>
    <script src="../../assets/js/util.js"></script>
    <script src="../../assets/js/main.js"></script>
    <script src="../../assets/js/jquery-confirm.js"></script>
    <script src="../assets/js/main_private.js"></script>
    <script src="documentacion/controlador.js"></script>
</body>

</html>