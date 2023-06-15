<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Inicio - Previreport</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="../images/favicon.png" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="../assets/css/noscript.css" />
    </noscript>
</head>

<body data-id="inicio">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/clientes/assets/php/hoja_menu.php'; ?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-laugh-beam"></span>
                <h2>INICIO</h2>
                <p><?= htmlspecialchars($_SESSION["session_user"][3]); ?></p>
            </header>


            <section class="wrapper style4 container max">
                <!-- <div class="row gtr-50 gtr-uniform">
                    <div class="col-6 col-12-small">
                        <input type="button" value="REGISTRAR SINIESTRO" class="primary small fit">
                    </div>
                    <div class="col-6 col-12-small">
                        <input type="button" value="REALIZAR PREOPERACIONAL" class="primary small fit">
                    </div>
                </div> -->
            </section>
        </article>



        <div id="camera-content" hidden>
            <div class="container-camera">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12" id="camera-name">
                        <label> My Camera V3 </label>
                    </div>
                    <div class="col-12 align-center" id="camera-message-top">
                        ESTE LADO ARRIBA
                    </div>
                    <div class="col-12 align-center" id="camera-canvas">
                        <input type="hidden" value="" id="camera_canvas_folder">
                        <video id="camera_video" class="camera_video_off" style="">
                            Video stream not available.
                        </video>
                        <canvas id="camera_canvas"></canvas>
                    </div>
                    <div class="col-12" id="camera-control">


                        <div class="row gtr-50 gtr-uniform">
                            <div class="col-6 col-12-mobilep" style="padding-top: 8px;">
                                <button id="btn-camera-upload" class="button primary small fit btn-camera">
                                    Guardar</button>
                            </div>
                            <div class="col-6 col-12-mobilep" style="padding-top: 8px;">
                                <button id="btn-camera-take" class="button primary small fit btn-camera"> Tomar foto
                                </button>
                            </div>
                            <div class="col-6 col-12-mobilep" style="padding-top: 8px;">
                                <button id="btn-camera-reload" class="button primary small fit btn-camera"> Corregir
                                </button>
                            </div>
                            <div class="col-6 col-12-mobilep" style="padding-top: 8px;">
                                <button id="btn-camera-exit" class="button primary small fit btn-camera"> Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require DOCUMENT_ROOT . '/clientes/assets/php/hoja_footer.php'; ?>
    </div>

    <!-- Scripts -->

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.dropotron.min.js"></script>
    <script src="../assets/js/jquery.scrolly.min.js"></script>
    <script src="../assets/js/jquery.scrollex.min.js"></script>
    <script src="../assets/js/browser.min.js"></script>
    <script src="../assets/js/breakpoints.min.js"></script>
    <script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/jquery-confirm.js"></script>
    <script src="../assets/js/jquery.tabs.js"></script>
    <script src="assets/js/main_private.js"></script>
 
    <script>
    const $tabs = $('#tab-login');
    $tabs.responsiveTabs({
        rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
        setHash: false
    });
    </script>
</body>

</html>