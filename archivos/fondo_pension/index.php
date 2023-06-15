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
    <link rel="shortcut icon" type="image/jpg" href="../images/favicon.png" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="../assets/css/noscript.css" />
    </noscript>
</head>

<body data-id="inicio">
    <div id="page-wrapper">
        <article id="main">
            <header class="special container">
                <span class="icon solid fa-laugh-beam"></span>
            </header>
            <section class="wrapper style4 container max">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-6 col-12-small">
                        <label></label>
                    </div>
                </div>
            </section>
        </article>
       
        <?php require DOCUMENT_ROOT . '/clientes/assets/php/hoja_footer.php'; ?>
    </div>

    <!-- Scripts -->

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