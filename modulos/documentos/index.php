<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/modulos/assets/php/hoja_private_config.php';
required_session();
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Documentos - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="/images/favicon.png" />
    <link rel="stylesheet" href="/assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="/assets/css/noscript.css" />
    </noscript>
    <style>

    </style>
</head>

<body data-id="documentos" class="is-preload landing">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_menu.php'; ?>
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-folder-open"></span>
                <h2>Documentos </h2>
                <p><?= htmlspecialchars($_SESSION["session_user"][3]); ?></p>
            </header>
            <section class="wrapper style4 container medium" style="padding: 2em;">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-4 col-12-small">
                        <hr class="hr-text-alt" data-content="Conductores">
                        <ol>
                            <li>
                                <a href="/modulos/conductores/visor/">(ARL) Riesgos Laborales.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Capacitaciones.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Multas y/o sanciones.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Contactos de emergencia.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Contratos.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Cursos.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">(EPS) Promotoras de Salud.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Examenes Ocupacionales.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Fondo de pensión.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Incapacidades.</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Licencia de conduccion.</a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-4 col-12-small">
                        <hr class="hr-text-alt" data-content="Vehículos">
                        <ol>
                            <li>
                                <a href="/modulos/conductores/visor/">Certificados</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Fotografías</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Improntas</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Pólizas</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Revisiones Preventivas</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">(RTM) Técnico mecánica</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">(SOAT) Seguro Obligatorio</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Solicitudes</a>
                            </li>
                            <li>
                                <a href="/modulos/conductores/visor/">Tarjeta de Operación</a>
                            </li>
                        </ol>
                    </div>
                    <div class="col-4 col-12-small">
                    <hr class="hr-text-alt" data-content="Empresas">
                        <ol>
                            <li>
                                <a href="/modulos/conductores/visor/">Certificaciones</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </section>
        </article>
        <?php require DOCUMENT_ROOT . '/modulos/assets/php/hoja_footer.php'; ?>
    </div>

    <!-- Scripts -->

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.dropotron.min.js"></script>
    <script src="/assets/js/jquery.scrolly.min.js"></script>
    <script src="/assets/js/jquery.scrollex.min.js"></script>
    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/util.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/jquery-confirm.js"></script>
    <script src="/modulos/assets/js/main_private.js"></script>
</body>

</html>