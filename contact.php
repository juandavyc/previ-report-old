<?php require $_SERVER["DOCUMENT_ROOT"] . '/hoja_public_config.php';?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Contact - Twenty by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="shortcut icon" type="image/jpg" href="images/favicon.png" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>
</head>

<body class="contact is-preload" data-id="submenu">
    <div id="page-wrapper">

        <!-- Header -->
        <?php require DOCUMENT_ROOT . '/hoja_menu.php';?>

        <!-- Main -->
        <article id="main">

            <header class="special container">
                <span class="icon solid fa-envelope"></span>
                <h2>Get In Touch</h2>
                <p>Use the form below to give /dev/null a piece of your mind.</p>
            </header>

            <!-- One -->
            <section class="wrapper style4 special container medium">

                <!-- Content -->
                <div class="content">
                    <form>
                        <div class="row gtr-50">
                            <div class="col-6 col-12-mobile">
                                <input type="text" name="name" placeholder="Name" />
                            </div>
                            <div class="col-6 col-12-mobile">
                                <input type="text" name="email" placeholder="Email" />
                            </div>
                            <div class="col-12">
                                <input type="text" name="subject" placeholder="Subject" />
                            </div>
                            <div class="col-12">
                                <textarea name="message" placeholder="Message" rows="7"></textarea>
                            </div>
                            <div class="col-12">
                                <ul class="buttons">
                                    <li><input type="submit" class="special" value="Send Message" /></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

        </article>

        <?php require DOCUMENT_ROOT . '/hoja_footer.php';?>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.dropotron.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.scrollgress.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>