<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de Repuestos del mantenimiento
    </legend>
    <div id="form_4_repuestos_resultados" class="accordion_form_resultados"></div>
</fieldset>


<form id="form_4_repuesto_mantenimiento" name="form_4_repuesto_mantenimiento">


    <div class="row gtr-50 gtr-uniform ">

        <div class="col-12">
            <fieldset>
                <legend> <i class="fas fa-money-check-alt"></i> Precio y unidades de los repuestos</legend>

                <div class="row gtr-50 gtr-uniform ">


                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Nombre del repuesto </label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-tools icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="nombre del repuesto"
                                name="form_4_nombre_repuesto" id="form_4_nombre_repuesto" autocomplete="off"
                                required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> cantidad</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-boxes icon-input"></i>
                            <input class="text-uppercase" type="number" placeholder="cantidad del repuesto"
                                name="form_4_cantidad_repuesto" id="form_4_cantidad_repuesto" autocomplete="off"
                                required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> valor</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-dollar-sign  icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="valor del repeusto"
                                name="form_4_valor_repuesto" id="form_4_valor_repuesto" autocomplete="off" required="">
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-12" hidden>
            <fieldset>
                <legend> <i class="far fa-clipboard"></i> Notas</legend>

                <div class="row gtr-50 gtr-uniform ">

                    <div class="col-12 col-12-small align-center">
                    </div>
                    <div class="col-12">
                        <textarea id="form_4_notas_repuesto_mantenimiento" name="form_4_notas_repuesto_mantenimiento"
                            rows="2" required="">...</textarea>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-12">
            <hr class="hr-text" data-content="OPCIONES DEL FORMULARIO">
        </div>
        <div class="col-6 col-12-small">
            <input type="submit" value="guardar" class="primary small fit">
        </div>
        <div class="col-6 col-12-small">
            <button type="reset" id="form_4_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>

    </div>

</form>