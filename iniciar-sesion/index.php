<?php session_start();
require $_SERVER["DOCUMENT_ROOT"] . '/assets/php/hoja_public_config.php'; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Iniciar sesión - Hojas de vida</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="shortcut icon" type="image/jpg" href="../images/favicon.png" />
    <link rel="stylesheet" href="../assets/css/main.css" /> <noscript>
        <link rel="stylesheet" href="../assets/css/noscript.css" />
    </noscript>
    <style>
        .card {
            position: relative;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }


        .card-title {
            margin: 0;
            font-weight: bold;
        }

        .card-text {
            margin: 1em 0;
        }


    </style>
</head>

<body data-id="iniciar-sesion" class="is-preload landing">
    <div id="page-wrapper">
        <?php require DOCUMENT_ROOT . '/hoja_menu.php'; ?>
        <article id="main">
            <header class="special container"> <span class="icon solid fa-sign-in-alt"></span>
                <h2>Iniciar sesión</h2>
                <p>Ingrese sus credenciales para poder <b>iniciar sesión </b> </p>
            </header>
            <section class="wrapper style3 container small">
                <div class="content">
                    <div class="row gtr-25 gtr-uniform" id="container-empresas">
                        <div class="col-12 align-center">
                        <span class="icon solid fa-briefcase fa-3x"></span>
                            <h3>
                                <b>                                  
                                    Seleccione su empresa
                                </b>
                            </h3>
                        </div>
                        <div class="col-12" id="container-empresas-items">                           
                        </div>
                    </div>
                    <div class="row gtr-25 gtr-uniform" id="container-iniciar-sesion" style="display: none;">
                        <form id="form_iniciar_sesion">
                            <div class="row gtr-25 gtr-uniform">
                                <div class="col-12">
                                <a href="#" id="iniciar-empresa-volver" class="icon solid fa-arrow-left"> Seleccionar empresa </a>
                                </div>
                                <div class="col-12 align-center">                                    
                                    <h3>Empresa: <b id="iniciar-empresa-nombre"></b></h3>
                                    <input type="hidden" id="iniciar-empresa" name="empresa" readonly autocomplete="off">
                                </div>
                                <div class="col-12">
                                    <label class="label-important"> Cedula</label>
                                    <div class="input-container">
                                        <i class="fa fa-user icon-input"></i>
                                        <input type="text" name="usuario" maxlength="25" required="" placeholder="Cedula" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="label-important"> Contraseña</label>
                                    <div class="input-container">
                                        <i class="fa fa-lock icon-input"></i>
                                        <input type="password" name="contrasenia" maxlength="25" required="" placeholder="Contraseña" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <br>
                                    <input type="submit" value="INICIAR SESIÓN" class="primary small fit">
                                </div>
                                <div class="col-12 align-center">
                                    <a href="#">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </article> <?php require DOCUMENT_ROOT . '/hoja_footer.php'; ?>
    </div> <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.dropotron.min.js"></script>
    <script src="../assets/js/jquery.scrolly.min.js"></script>
    <script src="../assets/js/jquery.scrollex.min.js"></script>
    <script src="../assets/js/browser.min.js"></script>
    <script src="../assets/js/breakpoints.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/jquery-confirm.js"></script>
    <script src="controlador/main.js"></script>
    <script>
        // $.alert(navigator.userAgent); 
    </script>
</body>

</html>