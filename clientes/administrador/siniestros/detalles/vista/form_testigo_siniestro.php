<fieldset>
    <legend><i class="far fa-folder-open"></i> Testigo(s) del Siniestro</legend>
    <div id="form_2_testigos_resultados" class="accordion_form_resultados"></div>
</fieldset>
<form id="form_2_testigo" name="form_2_testigo">
    <div class="row gtr-25 gtr-uniform ">
        <div class="col-12">
            <fieldset>
                <legend> <i class="fas fa-users"></i> Datos del Testigo</legend>
                <div class="row gtr-25 gtr-uniform ">
                    <div class="col-2 col-12-small">
                        <label class="label-important label-datos "> Nombre Del Testigo</label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-user-edit icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Nombre Del Testigo"
                                name="form_2_nombre" id="form_2_nombre" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-important label-datos "> Telefono </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-tty icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Telefono Del Testigo"
                                name="form_2_telefono" id="form_2_telefono" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Correo </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-at icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Correo Del Testigo"
                                name="form_2_correo" id="form_2_correo" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Direccion </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-street-view icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Direccion Del Testigo"
                                name="form_2_direccion" id="form_2_direccion" autocomplete="off">
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <hr class="hr-text" data-content="OPCIONES DEL FORMULARIO">
        </div>
        <div class="col-6 col-12-mobilep">
            <input type="submit" value="guardar" class="primary small fit">
        </div>
        <div class="col-6 col-12-mobilep">
            <button type="reset" id="form_2_limpiar_formulario" class="button primary small fit btn-limpiar-formulario"
                disabled>
                CANCELAR</button>
        </div>
    </div>
</form>