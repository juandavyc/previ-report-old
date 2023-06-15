<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Visor de Usuarios - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?=$_SESSION['csrf_token']?>">
    <link rel="shortcut icon" type="image/jpg" href="/images/favicon.png" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link rel="stylesheet" href="/assets/css/jquery-ui.css" />
    <noscript>
        <link rel="stylesheet" href="/assets/css/noscript.css" />
    </noscript>
    <style>
    table.alt tbody tr td:nth-child(2),
    table.alt tbody tr td:nth-child(6),
    table.alt tbody tr td:nth-child(7) {
        font-weight: bold;
    }
    </style>
</head>

<body data-id="modulos" class="is-preload landing">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php';?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-users"></span>
                <h2>Visor de usuarios</h2>
                <p><?=htmlspecialchars($_SESSION["session_user"][3]);?></p>
            </header>
            <div id="tab-visor">
                <ul>
                    <li><a href="#tab-1" class="icon solid fa-search"> Buscador </a></li>
                    <li><a href="#tab-2" class="icon solid fa-plus"> Agregar usuario </a></li>
                </ul>
                <div id="tab-1">
                    <?php require 'vista/buscador.html';?>
                </div>
                <div id="tab-2">
                    <?php require 'vista/agregar.html';?>
                </div>
            </div>
        </article>
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_footer.php';?>
    </div>
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
    <script type="module" src="controlador/main.js"></script>
    <script>

    </script>
</body>

</html>