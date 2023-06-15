<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Gestionar mi cuenta - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="../../images/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <link rel="stylesheet" href="../../assets/css/jquery-ui.css" />
    <noscript>
        <link rel="stylesheet" href="../../assets/css/noscript.css" />
    </noscript>
    <style>
    .icon-right {
        border-right: 1px solid #d5d5d5;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 2px;
        ;
    }

    .icon-right:hover {
        background: #c6c6c6;
    }
    </style>
</head>

<body data-id="cuenta">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php'; ?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-folder"></span>
                <h2>Gestionar mi cuenta</h2>
                <p><?= htmlspecialchars($_SESSION["session_user"][3]); ?></p>
            </header>
            <section class="wrapper style4 container max">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12 align-right">
                        <b> Ordenado de A a Z <i class="fas fa-sort-alpha-down"></i></b>
                    </div>
                    <div class="col-12">
                        <div id="gestion_accordion">
                            <h3 class="accordion-conductor-consulta" data-id="0"> Información de mi cuenta</h3>
                            <div id="acordion_conductor_consulta_1">
                                <?php require 'vista/informacion.php'; ?>
                            </div>
                            <h3 class="accordion-conductor-consulta" data-id="1"> Cambiar contraseña </h3>
                            <div id="acordion_conductor_consulta_1">
                                <?php require 'vista/contrasenia.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_footer.php'; ?>
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
    <script src="../../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/main_private.js"></script>
    <script type="module" src="controlador/main.js"></script>
    <script>
    console.log(PROTOCOL_HOST);
    </script>
</body>

</html>