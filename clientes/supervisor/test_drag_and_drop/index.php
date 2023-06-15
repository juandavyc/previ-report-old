<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
//https://medium.com/typecode/a-strategy-for-handling-multiple-file-uploads-using-javascript-eb00a77e15f

?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Test - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?=$_SESSION['csrf_token']?>">
    <link rel="shortcut icon" type="image/jpg" href="../images/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="../../assets/css/noscript.css" />
    </noscript>

    <style>
    /**  CSS CANVAS **/


    canvas {
        cursor: url('http://192.168.1.50/assets/css/images/pencil.png') 1 30, auto;
    }
    </style>
</head>

<body data-id="vehiculos">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php';?>


        <article id="main">
            <header class="special container">
                <span class="icon solid fa-question-circle"></span>
                <h2>asdasd</h2>
                <p><?=htmlspecialchars($_SESSION["session_user"][3]);?></p>
            </header>
            <section class="wrapper style4 container max">



                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <div class="canvas-container" id="canvas_firma_1"></div>
                    </div>
                    <div class="col-6 col-12-small">
                        <button class="button small" id="get_blob">get blob</button>
                        <button class="button small" id="reset_canvas">reset</button>
                        <button class="button small" id="set_blop">set blob</button>
                    </div>
                    <div class="col-12">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto delantera</label>
                                <input type="text" id="src_photo_test" value="/images/IMAGEN_PREVIAUTOS.jpg" readonly
                                    required>
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-camera-open" id="btn-src_photo_test"
                                    data-folder="pruebas" data-id="src_photo_test"></button>
                                <button class="button primary small btn-camera-show" data-id="src_photo_test"> </button>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto delantera</label>
                                <input type="text" id="src_photo_test_1" value="/images/IMAGEN_PREVIAUTOS.jpg" readonly
                                    required>
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-camera-open" id="btn-src_photo_test_1"
                                    data-folder="pruebas" data-id="src_photo_test_1"></button>
                                <button class="button primary small btn-camera-show" data-id="src_photo_test_1">
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-12-small">323</div>

                </div>



            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_footer.php';?>
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
    <script src="../assets/js/main_private.js"></script>
    <!--<script src="../assets/js/my_camera.js"></script>-->
    <script src="../assets/js/my_canvas.js"></script>
    <!-- <script src="controlador/function.js"></script> -->
    <script>
    // fun_camera_photo('https://192.168.1.50/modulos/test_drag_and_drop/', 30, 0);
    </script>
</body>

</html>