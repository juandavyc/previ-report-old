<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Inicio - Hojas de vida</title>
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
        <article id="main">
          
                <header id="header">
                    <h1 id="logo"><a href="index.php" class="icon solid fa-flag"> Hojas de vida <span>v 1.0</span></a></h1>
                    <nav id="nav">
                        <ul>
                            <li id="menu-inicio">
                                <a href="/modulos/index.php">Inicio</a>
                            </li>
                            <li>
                                <a id="cerrar_sesion_act" name="cerrar_sesion_act" href="/modulos/cerrar.php">Cerrar sesion</a>
                            </li>

                        </ul>
                    </nav>
                </header>
                <!-- <span class="icon solid fas fa-lock"></span> -->
            <section class="wrapper style4 container max">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12 col-12-small align-center">
                    <i class="fas fa-lock fa-3x"></i>
                    </div>
                    <div class="col-12 col-12-small align-center">
                        <label>Esta página no está disponible. Disculpa las molestias.</label>
                    </div>
                    <div class="col-12 col-12-small align-center">
                        <a href="/modulos/" class="button icon solid">IR A UN LUGAR SEGURO</a>
                    </div>

                </div>
            </section>
        </article>

        <?php require DOCUMENT_ROOT . '/clientes/assets/php/hoja_footer.php'; ?>
    </div>

    <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.dropotron.min.js"></script>
    <script src="../assets/js/jquery.scrolly.min.js"></script>
    <script src="../assets/js/jquery.scrollex.min.js"></script>
    <script src="../assets/js/browser.min.js"></script>
    <script src="../assets/js/breakpoints.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/jquery-confirm.js"></script>
    <script src="../assets/js/jquery.tabs.js"></script>
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