<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de Contacto de emergencia del conductor
    </legend>
    <div id="form_2_contacto_emergencia_resultados" class="accordion_form_resultados"></div>
</fieldset>

    <form id="form_2_informacion_emergencia_conductor" name="form_2_informacion_emergencia_conductor">
        <div class="row gtr-50 gtr-uniform ">
            <div class="col-12">
                <fieldset>
                    <legend><i class="fas fa-info-circle"></i>  Informacion contacto de emergencia</legend>
                    <div class="row gtr-50 gtr-uniform">
                        <div class="col-4 col-12-small">
                            <label class="label-datos">En caso de emergencia llamar a : (Nombre) </label>
                        </div>
                        <div class="col-8 col-12-small">
                            <div class="input-container">
                            <i class="fas fa-signature icon-input"></i> 
                                <input type="text" name="form_1_nombre_contacto_de_emergencia_conductor" id="form_1_nombre_contacto_de_emergencia_conductor" autocomplete="off" required="" class="text-uppercase" placeholder="Nombre Completo">
                            </div>
                        </div>

                        <div class="col-2 col-12-small">
                            <label class="label-datos">Telefono</label>
                        </div>
                        <div class="col-4 col-12-small">
                            <div class="input-container">
                            <i class="fas fa-phone-alt icon-input"></i>
                                <input type="text" name="form_1_telefono_contacto_de_emergencia_conductor" id="form_1_telefono_contacto_de_emergencia_conductor" autocomplete="off" required="" class="text-uppercase" placeholder="310 000 00 00">
                            </div>
                        </div>

                        <div class="col-2 col-12-small">
                            <label class="label-datos">Parentesco</label>
                        </div>
                        <div class="col-4 col-12-small">
                            <div class="input-container">
                            <i class="fas fa-male icon-input"></i>
                                <input type="text" name="form_1_parentesco_contacto_de_emergencia_conductor" id="form_1_parentesco_contacto_de_emergencia_conductor" autocomplete="off" required="" class="text-uppercase" placeholder="Parentesco">
                            </div>
                        </div>

                    </div>
                </fieldset>
            </div>

            <div class="col-12 col-12-small">
                <hr class="hr-text" data-content="Opciones del formulario ">
            </div>

            <div class="col-6 col-12-small">
                <input type="submit" value="guardar" class="primary small fit">
            </div>
            <div class="col-6 col-12-small">
                <button type="reset" id="form_1_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                    LIMPIAR FORMULARIO</button>
            </div>

        </div>
    </form>
