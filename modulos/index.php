<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Inicio - PreviReport</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="/images/favicon.png" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="/assets/css/noscript.css" />
    </noscript>
</head>

<body data-id="inicio" class="is-preload landing">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php'; ?>
        <article id="main">
            <?php require DOCUMENT_ROOT . '/modulos/habeas/habeas_data.html'?>
            <header class="special container">
                <span class="icon solid fa-laugh-beam"></span>
                <h2>INICIO</h2>
                <p><?= htmlspecialchars($_SESSION["session_user"][3]); ?></p>
            </header>

            <section class="wrapper style4 container small">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12 align-center">
                        <span style='font-size:44px; border-bottom: 3px solid #FFB900; padding-bottom: 6px;'>
                            &#128662;&#128653;&#128664;&#128757; </span>
                    </div>
                    <div class="col-1 col-12-small"></div>
                    <div class="col-10 col-12-small">
                        <span class="image fit"><img src="/images/home.jpg" alt=""></span>
                    </div>
                    <div class="col-1 col-12-small"></div>
                    <div class="col-12 align-center">
                        <h3> PORTAFOLIO DE SERVICIOS </h3>
                        <hr>
                    </div>

                    <div class="col-3 col-6-xsmall">
                        <a href="https://www.previautos.com/serviciospesados/" target="_blank">
                            <span class="image fit">
                                <img src="/images/portada/pesado_1.jpg" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-3 col-6-xsmall">
                        <a href="https://www.previautos.com/serviciospesados/" target="_blank">
                            <span class="image fit"><img src="/images/portada/liviano_1.jpg" alt=""></span>
                        </a>
                    </div>

                    <div class="col-3 col-6-xsmall">
                        <a href="https://www.previautos.com/servicioslivianos/" target="_blank">
                            <span class="image fit"><img src="/images/portada/moto_1.jpg" alt=""></span>
                        </a>
                    </div>
                    <div class="col-3 col-6-xsmall">
                        <a href="https://www.previautos.com/otros-servicios/" target="_blank">
                            <span class="image fit"><img src="/images/portada/otros_1.jpg" alt=""></span>
                        </a>
                    </div>
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_footer.php'; ?>
    </div>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.dropotron.min.js"></script>
    <script src="/assets/js/jquery.scrolly.min.js"></script>    
    <script src="/assets/js/jquery.scrollex.min.js"></script>
    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/util.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/jquery-confirm.js"></script>
    <script src="assets/js/main_private.js"></script>
    <script>

    </script>
</body>

</html>