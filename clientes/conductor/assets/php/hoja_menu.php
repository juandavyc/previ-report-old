<!--<div class="container-loader">
    <div class="loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <h3><b>CARGANDO</b><br>Por favor espere</h3>
</div> -->
<header id="header">
    <h1 id="logo"><a href="index.php" class="icon solid fa-envelope-open-text"> PREVIREPORT <span></span></a></h1>
    <nav id="nav">
        <ul>
            <li id="menu-inicio">
                <a href="<?= ROOT ?>/clientes/conductor/index.php" class="icon solid fa-home"> Inicio</a> 
            </li>
            <li id="menu-documentacion">
                <a href="<?= ROOT ?>/clientes/conductor/documentacion.php">Documentación</a> 
            </li>
            <li class="submenu" id="menu-modulos">
                <a href="#">Modulos</a>
                <ul>
                    <li><a href="<?= ROOT ?>/clientes/conductor/siniestros/visor/">Siniestros</a></li>
                    <li><a href="<?= ROOT ?>/clientes/conductor/preoperacional-super/visor/">Preoperacional </a></li>
                </ul>
            </li>
            <li>
                <a id="cerrar_sesion_act" name="cerrar_sesion_act" href="<?= ROOT ?>/clientes/conductor/cerrar.php">Cerrar sesion</a>
            </li>

        </ul>
    </nav>
</header>