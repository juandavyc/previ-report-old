<form id="form_1_nuevo_mantenimiento" name="form_1_nuevo_mantenimiento">
    <div class="row gtr-25 gtr-uniform">
        <div class="col-7 col-12-small"> </div>
        <div class="col-5 col-12-small">
            <aside class="note-wrap note-yellow ">
                1) Escriba la <b>PLACA</b> <br>
                2) <b>Verifique</b> la información del vehículo <br>
                3) <b>Su Firma</b> <br>
                <b> P.D. </b>Solo soporte técnico puede <b>ELIMINAR PREOPERACIONALES</b>
            </aside>
        </div>
        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="fas fa-search"></i> Datos Básicos
                </legend>
                <div class="row gtr-25 gtr-uniform">

                    <div class="col-5 col-12-small">
                        <label class="label-important"> EMPRESA </label>
                        <div class="input-container">
                            <i class="fas fa-industry icon-input"></i>
                            <input type="text" id="form_1_empresa_input" value="" placeholder="Empresa"
                                class="text-uppercase" required="" autocomplete="off" />
                            <input type="hidden" name="form_1_empresa" id="form_1_empresa_select" value="1"
                                data-default="1" required="" />
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-important"> PLACA </label>
                        <div class="input-container">
                            <i class="fas fa-align-left icon-input"></i>
                            <input type="text" id="form_1_vehiculo_input" value="" placeholder="Placa"
                                class="text-uppercase autocomplete" required="" />
                            <input type="hidden" name="form_1_vehiculo" id="form_1_vehiculo_select" value=""
                                data-default="1" required="" />
                            <!-- input empresa -->
                            <input type="hidden" name="form_1_empresa" id="form_1_empresa" value="" data-default="0"
                                required="" />
                        </div>
                    </div>

                    <div class="col-4 col-12-small">
                        <label> Verificar </label>
                        <button class="button primary small fit" id="form_1_info_vehiculo">
                            Verificar vehículo
                        </button>
                    </div>
                    <div class="col-12">
                        <label> Observaciones ( opcional ) </label>
                        <textarea id="form_1_observaciones" name="form_1_observaciones" rows="2"
                            maxlength="200"></textarea>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <fieldset>
                <legend><i class="fas fa-file-signature"></i> Su Firma </legend>
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-3 col-12-small"></div>
                    <div class="col-6 col-12-small">
                        <div class="canvas-container" id="canvas_firma_autoriza"></div>
                    </div>
                    <div class="col-3 col-12-small"></div>
                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <hr class="hr-text" data-content="Opciones del formulario" />
        </div>
        <div class="col-6 col-12-small">
            <input type="submit" value="Asignar para preoperacional" id="form_1_submit" class="primary small fit"
                disabled>
        </div>
        <div class="col-6 col-12-small">
            <button type="reset" id="form_1_reset" class="button primary small fit btn-limpiar-formulario">
                CANCELAR
            </button>
        </div>
    </div>
</form>
<br>
<div class="row gtr-50 gtr-uniform" id="agregar_resultados_body"></div>