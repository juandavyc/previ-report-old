<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/assets/php/hoja_public_config.php'; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title> Hoja de vida vehicular - Previreport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="Gestione su flota, desde cualquier lugar en tiempo real. hoja de vida: vehículos, conductores, preoperacionales, mantenimientos y siniestros - un producto de Previautos S.A.S" />
    <meta name="keywords" content="improntas, regrabaciones, logistica, administrar, fontibon, livianos, automoviles, pesados, motos, automoviles, tractocamiones, gestionar, flota, vehículos, conductores, hoja de vida vehicular, preoperacionales, mantenimientos, siniestros, preventivas, previautos, previautos sas, bogotá, colombia">
    <meta name="author" content="Previautos S.A.S">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="../images/favicon.png" />
    <link rel="stylesheet" href="../assets/css/main.css" /> <noscript>
        <link rel="stylesheet" href="../assets/css/noscript.css" />
    </noscript>
    <style>
        body {
            /*background: #535353;*/
        }
    </style>
</head>

<body data-id="inicio" class="is-preload landing">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/hoja_menu.php'; ?>
        <section id="banner">
            <br /> <br />
            <div class="inner">
                <header>
                    <h2>Gestione su flota</h2>
                </header>
                <p>
                    Desde <b>cualquier lugar</b> en <b>tiempo real</b>
                    <br><br>
                    <a class="button small" href="https://www.previautos.com/">Más información</a>
                </p>
            </div>
        </section>
        <!-- Main -->
        <article id="main" style="background-color: #1a1a1aa3;">
            <header class="special container"> <span class="icon solid fa-chart-line"></span>
                <h2>HOJA DE VIDA VEHICULAR</h2>
                <p>Administre de manera eficiente Información acerca de: <b>vehículos, conductores, preoperacionales,
                        mantenimientos y siniestros</b>. <br> De manera <b>amigable</b> con estadísticas e informes en
                    <b>tiempo real</b>.
                    <br>
                    <a href="https://previautos.com/">Más información</a>
                </p>
            </header>
            <!-- One -->
            <section class="wrapper style1 container special-alt">
                <div class="row gtr-50">
                    <div class="col-8 col-12-narrower">
                        <header>
                            <h2> <b> ¡Tú historial aquí!</b> </h2>
                        </header>
                        <p>
                        ¡Obtén toda la información de tu vehículo sin tener que salir de casa o del trabajo! En nuestro servicio de consulta digital, te proporcionamos acceso a toda la información importante sobre tu automóvil con solo unos pocos clics.
                        </p>
                        <footer>
                            <ul class="buttons">
                                <li>
                                    <a href="https://www.previautos.com/" class="button small icon solid fa-arrow-right"> Más información</a>
                                </li>
                            </ul>
                        </footer>
                    </div>
                    <div class="col-4 col-12-narrower imp-narrower">
                        <ul class="featured-icons">
                            <li><span class="icon fa-clock"><span class="label">Feature 1</span></span></li>
                            <li><span class="icon solid fa-car"><span class="label">Feature 3</span></span></li>
                            <li><span class="icon solid fa-motorcycle"><span class="label">Feature 4</span></span></li>
                            <li><span class="icon solid fa-truck"><span class="label">Feature 5</span></span></li>
                        </ul>
                    </div>
                </div>
            </section>
            <section class="wrapper style2 container special">
                <div class="row">
                    <div class="col-4 col-12-narrower">
                        <section>
                            <span class="icon solid featured fa-car" style="opacity:inherit;"></span>
                            <header>
                                <h3> <b> Que nos mueve </b></h3>
                            </header>
                            <p>
                                Nuestro objetivo es convertirnos en la empresa líder en Colombia en la promoción de servicios que fomenten la prevención de accidentes, conductas seguras, buenos hábitos y comportamientos en las vías.
                            </p>
                        </section>
                    </div>
                    <div class="col-4 col-12-narrower">
                        <section>
                            <span class="icon solid featured fa-heart" style="opacity:inherit;"></span>
                            <header>
                                <h3> <b> Nuestro Proposito </b></h3>
                            </header>
                            <p>Contribuir a la seguridad vial del país ofreciendo servicios para todo tipo de vehículos...</p>
                        </section>
                    </div>
                    <div class="col-4 col-12-narrower">
                        <section>
                            <span class="icon solid featured fa-road" style="opacity:inherit;"></span>
                            <header>
                                <h3> <b>ASESORÍA PLAN ESTRATEGICO </b></h3>
                            </header>
                            <p>
                            Asesoría y formulación del PESV para su empresa, con una adecuada estructuración, implementación y seguimiento.
                            </p>
                        </section>
                    </div>
                </div>
            </section>            
        </article>
        <section id="cta">
            <header>
                <h2><b>PREGUNTAS FRECUENTES</b></h2>
                <p>
                    Tienes alguna inquietud o pregunta, no dudes en hacérnoslo saber.
                    <br /> Estamos aquí para escucharte y brindarte toda la ayuda que necesites.
                </p>
                <a href="https://previautos.com/" class="button small icon solid fa-phone-alt">
                    HAZ TU PREGUNTA</a>
            </header>
        </section>
        <br><br>
        <?php require DOCUMENT_ROOT . '/hoja_footer.php'; ?>
    </div> <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.dropotron.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
    <script>

    </script>
</body>

</html>