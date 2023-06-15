<form id="form_1_nuevo_mantenimiento" name="form_1_nuevo_mantenimiento">
    <div class="row gtr-25 gtr-uniform">
        <div class="col-7 col-12-small"> </div>
        <div class="col-5 col-12-small">
            <aside class="note-wrap note-yellow ">
                <ol>
                    <li>Escriba la <b>EMPRESA</b></li>
                    <li>Escriba la <b>PLACA</b> </li>
                    <li><b>Verifique</b> la información del vehículo</li>
                    <li><b>¿Tiene Orden de servicio?</b></li>
                    <li><b>Su Firma</b></li>
                    <li>P.D. </b>Solo soporte técnico puede <b>ELIMINAR MANTENIMIENTOS</b></li>
                </ol>
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
                            <input type="text" id="form_1_empresa_input" value="" placeholder="Empresa" class="text-uppercase" required="" autocomplete="off">
                            <input type="hidden" id="form_1_empresa_select" value="1" data-default="1" required="">
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-important"> Placa </label>
                        <div class="input-container">
                            <i class="fas fa-align-left icon-input"></i>
                            <input type="text" id="form_1_vehiculo_input" value="" placeholder="Placa del vehiculo" class="text-uppercase autocomplete" required="" />
                            <input type="hidden" name="form_1_vehiculo" id="form_1_vehiculo_select" value="" data-default="0" required="" />
                        </div>
                    </div>
                    <div class="col-4 col-12-small">
                        <label>Verificar</label>
                        <button class="button primary small fit" id="form_1_info_vehiculo">Verificar</button>
                    </div>
                    <div class="col-12"></div>
                    <div class="col-6 col-12-small align-center">
                        <label> Orden de servicio</label>
                        <input type="radio" id="form_1_orden_servicio_si" name="form_1_orden_servicio" value="1">
                        <label for="form_1_orden_servicio_si">Si</label>
                        <input type="radio" id="form_1_orden_servicio_no" name="form_1_orden_servicio" value="2" checked="">
                        <label for="form_1_orden_servicio_no">No</label>
                    </div>
                    <div class="col-6 col-12-small">
                        <label> Nº Orden de servicio</label>
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-up-alt icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder=" Nº Orden de servicio" name="form_1_numero_orden_servicio" id="form_1_numero_orden_servicio" autocomplete="off">
                        </div>
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
            <input type="submit" value="Asignar para mantenimiento" id="form_1_submit" class="primary small fit" disabled>
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