<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/clientes/supervisor/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Vehículo - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="../images/favicon.png" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="../../assets/css/noscript.css" />
    </noscript>
</head>

<body class="no-sidebar is-preload" data-id="vehiculos">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hoja_menu.php'; ?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-question-circle"></span>
                <h2>Ayuda</h2>
                <p><?= htmlspecialchars($_SESSION["session_user"][3]); ?></p>
            </header>
            <section class="wrapper style4 container max">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-6 col-12-small">

                    </div>
                    <div class="col-6 col-12-small">

                    </div>
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/clientes/supervisor/assets/php/hoja_footer.php'; ?>
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
    <script src="../assets/js/jquery.tabs.js"></script>
    <script src="../assets/js/main_private.js"></script>
    <script>
    console.log(PROTOCOL_HOST);
    </script>
</body>

</html>