<fieldset>
    <legend><i class="far fa-folder-open"></i> Agente(s) de Transito</legend>
    <div id="form_1_agentes_resultados" class="accordion_form_resultados"></div>
</fieldset>
<form id="form_1_agente" name="form_1_agente">
    <div class="row gtr-25 gtr-uniform">
        <div class="col-12">
            <fieldset>
                <legend><i class="fas fa-plus"></i> Datos del Agente</legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-2 col-12-small">
                        <label class="label-important label-datos">
                            Nombre Del Agente
                        </label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-filter icon-input"></i>
                            <input type="text" id="form_1_nombre" name="form_1_nombre" placeholder="Nombre del Agente"
                                class="text-uppercase" required="" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos">
                            Telefono
                        </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-down-alt icon-input"></i>
                            <input type="text" name="form_1_telefono" id="form_1_telefono"
                                placeholder="Telefono del agente" autocomplete="off" class="text-uppercase" />
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos">
                            Correo
                        </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-down-alt icon-input"></i>
                            <input type="text" name="form_1_correo" id="form_1_correo" placeholder="Correo del agente"
                                autocomplete="off" class="text-uppercase" />
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-12">
            <hr class="hr-text" data-content="Opciones del formulario" />
        </div>
        <div class="col-6 col-12-mobilep">
            <input type="submit" value="guardar" class="primary small fit" />
        </div>
        <div class="col-6 col-12-mobilep">
            <button type="reset" id="form_1_limpiar_formulario" class="button primary small fit btn-limpiar-formulario"
                disabled>
                CANCELAR
            </button>
        </div>
    </div>
</form>