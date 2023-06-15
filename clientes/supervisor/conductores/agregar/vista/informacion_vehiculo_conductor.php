<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de vehiculos asignados al conductor
    </legend>
    <div id="form_12_vehiculo_conductor_resultados" class="accordion_form_resultados"></div>
</fieldset>
<form id="form_12_vehiculo_conductor" name="form_12_vehiculo_conductor">

    <div class="row gtr-50 gtr-uniform ">

        <div class="col-12">

        </div>

        <div class="col-12">


            <fieldset>
                <legend><i class="far fa-folder-open"></i> Agregar vehiculos a conductor
                </legend>

                <div class="row gtr-50 gtr-uniform ">

                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Placa Vehículo <b class="list-key"></b></label>
                    </div>
                    <div class="col-5 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_12_placa_vehiculo_conductor_input" class="text-uppercase" required="" placeholder="PLACA">
                            <input type="hidden" name="form_12_placa_vehiculo_conductor" id="form_12_placa_vehiculo_conductor_select" value="1" required="">
                        </div>
                    </div>
                    <div class="col-5 col-12-small">
                        <button class="button primary small fit btn-crear-vehiculo">
                            Agregar vehículo
                        </button>
                    </div>
                    <!-- <div class="col-2 col-12-small">
                        <label class="label-datos"> Número Vehículo <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_12_numero_vehiculo_conductor" name="form_12_numero_vehiculo_conductor" class="text-uppercase" required="" placeholder="NUMERO">
                        </div>
                    </div> -->


                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha de Asignación </label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_12_fecha_asignacion_vehiculo_conductor" id="form_12_fecha_asignacion_vehiculo_conductor" class="input_date_listener" autocomplete="off" value="01/01/2000" required="">
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
            <button type="reset" id="form_12_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>