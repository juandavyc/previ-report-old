<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
//https://medium.com/typecode/a-strategy-for-handling-multiple-file-uploads-using-javascript-eb00a77e15f
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Vehículo - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?=$_SESSION['csrf_token']?>">
    <link rel="shortcut icon" type="image/jpg" href="../images/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="../../assets/css/noscript.css" />
    </noscript>

    <style>
    /* DRAG AND DROP STYLES */
    .container_drag {
        padding: 50px 10%;
    }

    .box {
        position: relative;
        background: #ffffff;
        width: 100%;
    }

    .box-header {
        color: #444;
        display: block;
        padding: 10px;
        position: relative;
        border-bottom: 1px solid #f4f4f4;
        margin-bottom: 10px;
    }

    .box-tools {
        position: absolute;
        right: 10px;
        top: 5px;
    }

    .dropzone-wrapper {
        border: 2px dashed #91b0b3;
        color: #92b0b3;
        position: relative;
        height: 150px;
    }

    .dropzone-desc {
        position: absolute;
        margin: 0 auto;
        left: 0;
        right: 0;
        text-align: center;
        width: 40%;
        top: 50px;
        font-size: 16px;
    }

    .dropzone,
    .dropzone:focus {
        position: absolute;
        outline: none !important;
        width: 100%;
        height: 150px;
        cursor: pointer;
        opacity: 0;
    }

    .dropzone-wrapper:hover,
    .dropzone-wrapper.dragover {
        background: #ecf0f5;
    }

    .preview-zone {
        text-align: center;
    }

    .preview-zone .box {
        box-shadow: none;
        border-radius: 0;
        margin-bottom: 0;
    }
    </style>
</head>

<body class="no-sidebar is-preload" data-id="vehiculos">

    <div id="page-wrapper">

        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php';?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-question-circle"></span>
                <h2>asdasd</h2>
                <p><?=htmlspecialchars($_SESSION["session_user"][3]);?></p>
            </header>
            <section class="wrapper style4 container xlarge">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12 col-12-small">

                        <form id="form_save_file" enctype=multipart/form-data method=POST>

                            <div class="container_drag">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="control-label">Subir archivos</label>
                                            <div class="preview-zone hidden">
                                                <div class="box box-solid">
                                                    <div class="box-header with-border">
                                                        <div><b>Vista previa</b></div>
                                                        <div class="box-tools pull-right">
                                                            <button type="button"
                                                                class="btn btn-danger btn-xs remove-preview">
                                                                <i class="fa fa-times"></i> Reset
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="box-body"></div> -->
                                                    <div class="col-12" id="boxxx"></div>
                                                </div>
                                            </div>
                                            <div class="dropzone-wrapper">
                                                <div class="dropzone-desc">
                                                    <i class="glyphicon glyphicon-download-alt"></i>
                                                    <p>Seleccíone una imagen / archivo o arrastrelo aquí</p>
                                                </div>
                                                <input id="form_dropzone" type="file" name="img_logo" class="dropzone"
                                                    multiple="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary pull-right">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col-6 col-12-small">

                    </div>
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
    <script src="controlador/function.js"></script>
    <script>
    console.log(PROTOCOL_HOST);
    </script>


</body>

</html>
<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
//https://medium.com/typecode/a-strategy-for-handling-multiple-file-uploads-using-javascript-eb00a77e15f
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Vehículo - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?=$_SESSION['csrf_token']?>">
    <link rel="shortcut icon" type="image/jpg" href="../images/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="../../assets/css/noscript.css" />
    </noscript>

    <style>
    /* DRAG AND DROP STYLES */
    .box {
        position: relative;
        background: #ffffff;
        width: 100%;
    }

    .box-header {
        color: #444;
        display: block;
        padding: 10px;
        position: relative;
        border-bottom: 1px solid #f4f4f4;
        margin-bottom: 10px;
    }

    .box-tools {
        position: absolute;
        right: 10px;
        top: 5px;
    }

    .dropzone-wrapper {
        border: 2px dashed #91b0b3;
        color: #92b0b3;
        position: relative;
        height: 150px;
        margin: 1em 0em;
    }

    .dropzone-message {
        position: absolute;
        margin: 0 auto;
        left: 0;
        right: 0;
        text-align: center;
        width: 40%;
        top: 50px;
        font-size: 16px;
    }

    .dropzone,
    .dropzone:focus {
        position: absolute;
        outline: none !important;
        width: 100%;
        height: 150px;
        cursor: pointer;
        opacity: 0;
    }

    .dropzone-wrapper:hover,
    .dropzone-wrapper.dragover {
        background: #ecf0f5;
    }

    .preview-zone .box {
        box-shadow: none;
        border-radius: 0;
        margin-bottom: 0;
    }

    .preview-zone-temp-file {

        border: 1px solid #259d90;
        background: #68ccc1;
        font-weight: normal;
        color: #fff;
        padding: 2px 10px;
    }
    </style>
</head>

<body class="no-sidebar is-preload" data-id="vehiculos">

    <div id="page-wrapper">

        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php';?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-question-circle"></span>
                <h2>asdasd</h2>
                <p><?=htmlspecialchars($_SESSION["session_user"][3]);?></p>
            </header>
            <section class="wrapper style4 container xlarge">

                <form id="form_save_file" enctype=multipart/form-data method=POST>
                    <div class="row gtr-50 gtr-uniform">
                        <div class="col-10 col-12-mobilep">
                            <div class="dropzone-container">
                                <div class="row gtr-50 gtr-uniform" id="form_1_prueba_preview_zone">
                                </div>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-message">
                                        <i class="fas fa-cloud-upload-alt fa-3x"></i>
                                        <p>Seleccíone una imagen / archivo o arrastrelo aquí</p>
                                    </div>
                                    <input id="form_dropzone" type="file" name="img_logo"
                                        data-preview="form_1_prueba_preview_zone" class="dropzone" multiple="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-12-mobilep">
                            <div class="row gtr-50 gtr-uniform">
                                <div class="col-12">

                                    <button type="submit" class="btn btn-primary pull-right">Upload</button>

                                </div>
                                <div class="col-12">
                                    <button type="button" class="remove-preview" data-input="form_dropzone"
                                        data-preview="form_1_prueba_preview_zone">
                                        <i class="fa fa-times"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>


                    </div>
                </form>
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
    <script src="controlador/function.js"></script>
    <script>
    console.log(PROTOCOL_HOST);
    </script>


</body>

</html>