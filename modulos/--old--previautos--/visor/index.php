<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Visor de PDF - Previautos</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="../../../images/favicon.png" />
    <link rel="stylesheet" href="../../../assets/css/main.css" />
    <link rel="stylesheet" href="../../../assets/css/jquery-ui.css" />

    <noscript>
        <link rel="stylesheet" href="../../../assets/css/noscript.css" />
    </noscript>
    <style>
    table.alt tbody tr td:nth-child(2),
    table.alt tbody tr td:nth-child(3) {
        font-weight: bold;
    }


    .container-sidebar {
        background: #EBF4FB;
        border: 1px solid #A6CEED;
        border-radius: 4px;
        padding: 1em;
    }

    .container-sidebar a {
        font-weight: bold;
        color: #569CD6;
    }

    .container-sidebar hr {
        background: #A6CEED;
    }

    .container-title {
        color: #255D88;
        font-weight: bold;
        background: #EBF4FB;
        border: 1px solid #A6CEED;
        border-radius: 4px;
    }

    .label-datos-alt {
        background: #F7F7F7;
        border-right: 3px solid #D5D5D5;
        color: #313131;
        font-size: 14px;
        min-height: 2.84em;
        line-height: 2.84em;
        font-weight: bold;
        border-radius: 4px;
        padding-left: 1em;
    }

    #resultado_table {
        max-height: 300px;
        overflow-y: auto;
    }
    </style>
</head>

<body data-id="modulos" class="is-preload landing">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php'; ?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-file-pdf"></span>
                <h2>Visor de PDF</h2>
                <p><?= htmlspecialchars($_SESSION["session_user"][3]); ?></p>
            </header>

            <div id="tab-visor">
                <ul>
                    <li><a href="#tab-1" class="icon solid fa-search"> Buscador </a></li>
                    <li><a href="#tab-2" class="icon solid fa-plus"> Agregar Revision </a></li>
                    <li><a href="#tab-3" class="icon solid fa-search"> Consulta - web </a></li>
                </ul>
                <div id="tab-1">
                    <?php require 'vista/buscador.html'; ?>
                </div>
                <div id="tab-2">
                    <?php require 'vista/agregar.html'; ?>
                </div>
                <div id="tab-3">
                    <?php require 'vista/consulta.html'; ?>
                </div>
            </div>

        </article>
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_footer.php'; ?>
    </div>
    <script src="../../../assets/js/jquery.min.js"></script>
    <script src="../../../assets/js/jquery.dropotron.min.js"></script>
    <script src="../../../assets/js/jquery.scrolly.min.js"></script>
    <script src="../../../assets/js/jquery.scrollex.min.js"></script>
    <script src="../../../assets/js/browser.min.js"></script>
    <script src="../../../assets/js/breakpoints.min.js"></script>
    <script src="../../../assets/js/util.js"></script>
    <script src="../../../assets/js/jquery.tabs.js"></script>
    <script src="../../../assets/js/main.js"></script>
    <script src="../../../assets/js/jquery-confirm.js"></script>
    <script src="../../../assets/js/jquery-ui.min.js"></script>
    <script src="../../assets/js/main_private.js"></script>
    <script type="module" src="controlador/main.js"></script>
    <!--  -->


    <script>
    
    </script>
</body>

</html>