<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de Contratos
    </legend>
    <div id="form_13_empresa_conductor_resultados" class="accordion_form_resultados"></div>
</fieldset>
<form id="form_13_empresa_conductor" name="form_13_empresa_conductor">
    <div class="row gtr-50 gtr-uniform ">
        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="far fa-folder-open"></i> Agregar contrato a Conductor
                </legend>
                <div class="row gtr-25 gtr-uniform ">
                    <div class="col-3 col-12-small">
                        <label class="label-datos label-important">Tipo Contrato</label>
                    </div>
                    <div class="col-9 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-thumbs-up icon-input"></i>
                            <select id="form_13_tipo_contrato" name="form_13_tipo_contrato" required="" value=2>
                                <option value="1">OBRA LABOR</option>
                                <option value="2">TERMINO FIJO</option>
                                <option value="3">TERMINO INDEFINIDO</option>
                                <option value="4">APRENDIZAJE</option>
                                <option value="5">TEMPORAL, OCACIONAL O ACCIDENTAL</option>
                                <option value="6">CIVIL POR PRESTACION DE SERVICIOS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-datos label-important"> Fecha de Asignación </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_13_fecha_asignacion_empresa_conductor"
                                id="form_13_fecha_asignacion_empresa_conductor" class="input_date_listener"
                                autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-datos label-important"> Fecha de vencimiento</label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_13_fecha_vencimiento_empresa_conductor"
                                id="form_13_fecha_vencimiento_empresa_conductor" class="input_date_listener"
                                autocomplete="off" required="">
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
            <button type="reset" class="button primary small fit btn-limpiar-formulario">
                CANCELAR </button>
        </div>
    </div>
</form>