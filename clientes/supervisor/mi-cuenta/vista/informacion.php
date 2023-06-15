<form id="form_0_informacion" name="form_0_informacion">
    <div class="row gtr-25 gtr-uniform">
        <div class="col-12 align-center">
            <i class="fas fa-info-circle fa-3x"></i>
        </div>
        <div class="col-4 col-12-mobilep"></div>
        <div class="col-4 col-12-mobilep align-center">
            <span class="image fit">
                <a href="/images/sin_imagen.png" id="form_0_href_foto" target="_blank">
                    <img src="/images/sin_imagen.png">
                </a>
            </span>
            <label> SU FOTO</label>
        </div>
        <div class="col-4 col-12-mobilep"></div>
        <div class="col-12">
            <hr>
        </div>
        <div class="col-2 col-12-small">
            <label class="label-datos"> Cedula </label>
        </div>
        <div class="col-4 col-12-small">
            <label class="label-resultados" id="form_0_cedula">0</label>
        </div>
        <div class="col-6 col-12-small"></div>
        <div class="col-2 col-12-small">
            <label class="label-important label-datos"> Nombre </label>
        </div>
        <div class="col-4 col-12-small">
            <div class="input-container">
                <i class="fas fa-signature icon-input"></i>
                <input type="text" name="form_0_nombre" id="form_0_nombre" placeholder="Nombre" autocomplete="off"
                    value="" maxlength="20" class="text-uppercase" required="">
            </div>
        </div>
        <div class="col-2 col-12-small">
            <label class="label-important label-datos"> Apellido </label>
        </div>
        <div class="col-4 col-12-small">
            <div class="input-container">
                <i class="fas fa-signature icon-input"></i>
                <input type="text" name="form_0_apellido" id="form_0_apellido" placeholder="Apellido" autocomplete="off"
                    value="" maxlength="20" class="text-uppercase" required="">
            </div>
        </div>
        <div class="col-2 col-12-small">
            <label class="label-important label-datos"> Telefono </label>
        </div>
        <div class="col-4 col-12-small">
            <div class="input-container">
                <i class="fas fa-tty icon-input"></i>
                <input type="text" name="form_0_telefono" id="form_0_telefono" placeholder="Telefono" autocomplete="off"
                    class="text-uppercase" maxlength="10" required="">
            </div>
        </div>
        <div class="col-2 col-12-small">
            <label class="label-important label-datos"> Correo</label>
        </div>
        <div class="col-4 col-12-small">
            <div class="input-container">
                <i class="fas fa-at icon-input"></i>
                <input type="email" name="form_0_correo" id="form_0_correo" placeholder="correo@correo.com"
                    autocomplete="off" class="text-uppercase" maxlength="30" required="">
            </div>
        </div>
        <div class="col-2 col-12-small">
            <label class="label-important label-datos">
                Fecha nacimiento
            </label>
        </div>
        <div class="col-4 col-12-small">
            <div class="input-container">
                <i class="fas fa-calendar icon-input"></i>
                <input type="text" name="form_0_fecha_nacimiento" id="form_0_fecha_nacimiento"
                    class="input_date_listener" autocomplete="off" value="01/01/2021" required="">
            </div>
        </div>
        <div class="col-12"></div>
        <div class="col-2 col-12-small">
            <label class="label-datos"> Empresa </label>
        </div>
        <div class="col-10 col-12-small">
            <label class="label-resultados" id="form_0_empresa">0</label>
        </div>
        <div class="col-2 col-12-small">
            <label class="label-datos"> Rango </label>
        </div>
        <div class="col-10 col-12-small">
            <label class="label-resultados" id="form_0_rango">0</label>
        </div>
        <div class="col-2 col-12-small">
            <label class="label-datos"> Taller </label>
        </div>
        <div class="col-10 col-12-small">
            <label class="label-resultados" id="form_0_taller">0</label>
        </div>
        <div class="col-12">
            <fieldset>
                <legend><i class="fas fa-file-signature"></i> Firma Del Usuario</legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-4 col-12-mobilep"></div>
                    <div class="col-4 col-12-mobilep align-center">
                        <span class="image fit">
                            <a href="/images/sin_firma.png" id="form_0_href_firma" target="_blank">
                                <img src="/images/sin_firma.png">
                            </a>
                        </span>
                        <label>SU FIRMA</label>
                    </div>
                    <div class="col-4 col-12-mobilep"></div>
                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <hr class="hr-text" data-content="Opciones del formulario" />
        </div>
        <div class="col-6 col-12-small">
            <input type="submit" value="Guardar Información" class="primary small fit" />
        </div>
        <div class="col-6 col-12-small">
            <button type="reset" class="button primary small fit btn-limpiar-formulario" disabled>
                CANCELAR
            </button>
        </div>
    </div>
</form>