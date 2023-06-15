<form id="form_2_informacion_procedimiento_mantenimientos" name="form_2_informacion_procedimiento_mantenimientos">


    <div class="row gtr-50 gtr-uniform ">
        <div class="col-12 align-center">
            <!-- <i class="fas fa-chalkboard-teacher fa-3x"></i> -->
        </div>

        <div class="col-12">
            <fieldset>
                <legend> <i class="far fa-clipboard"></i> Informacion del procedimiento</legend>

                <div class="row gtr-25 gtr-uniform ">

                    <div class="col-3 col-12-small">
                        <label class="label-datos ">repuestos a utilizar y/o consumibles</label>
                    </div>
                    <div class="col-9  col-12-small">
                        <div class="input-container">
                            <i class="fas fa-map-marked-alt icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="repuestos a utilizar y/o consumibles" name="form_2_repuesto_mantenimiento" id="form_2_repuesto_mantenimiento" autocomplete="off" required="">
                        </div>
                    </div>


                    <div class="col-3 col-12-small">
                        <label class="label-datos">
                            Fecha inicial del mantenimiento
                        </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_2_fecha_inicial_mantenimiento" id="form_2_fecha_inicial_mantenimiento" class="input_date_listener" autocomplete="off" value="01/01/2021" required="" />
                        </div>
                    </div>


                    <div class="col-3 col-12-small">
                        <label class="label-datos "> hora inicio mantenimiento</label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">

                            <i class="fas fa-clock icon-input"></i>
                            <input type="time" name="form_2_hora_inicio_mantenimiento" id="form_2_hora_inicio_mantenimiento">

                        </div>
                    </div>
                    <!-- <div class="col-3 col-12-small">
              <label class="label-datos "> Tipo de mantenimiento </label>
            </div>
            <div class="col-9 col-12-small">
              <div class="input-container">
                <i class="fas fa-heartbeat icon-input"></i>
                <select id="form_2_tipo_mantenimiento" name="form_2_tipo_mantenimiento" required="">
                  <option value="2">PREREPARACION</option>
                  <option value="3">REPUESTO DAÑADO</option>
                  <option value="4">RESPUESTO NUEVO</option>
                  <option value="5">POST REPARACION</option>
                </select>
              </div>
            </div> -->

                    <div class="col-3 col-12-small">
                        <label class="label-datos">Descripcion de los daños y trabajos a realizar</label>
                    </div>
                    <div class="col-9 col-12-small">
                        <div class="input-container">
                            <textarea id="form_2_descripcion_trabajo_a_realizar" name="form_2_descripcion_trabajo_a_realizar" rows="2" required="" placeholder="DESCRIPCION DEL PROCEDIMIENTO A REALIZAR"></textarea>
                        </div>
                    </div>

                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <fieldset>
                <legend> <i class="far fa-clipboard"></i> Procedimiento realizado </legend>

                <div class="row gtr-50 gtr-uniform ">

                    <div class="col-3 col-12-small">
                        <label class="label-datos">Descripcion del procedimiento realizado</label>
                    </div>
                    <div class="col-9 col-12-small">
                        <div class="input-container">
                            <textarea id="form_2_descripcion_procedimiento_realizado" name="form_2_descripcion_procedimiento_realizado" rows="2" required="" placeholder="DESCRIPCION DEL PROCEDIMIENTO REALIZADO"></textarea>
                        </div>
                    </div>

                    <div class="col-3 col-12-small">
                        <label class="label-datos">
                            Fecha Final del mantenimiento
                        </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_2_fecha_final_mantenimiento" id="form_2_fecha_final_mantenimiento" class="input_date_listener" autocomplete="off" value="01/01/2021" required="" />
                        </div>
                    </div>




                    <div class="col-3 col-12-small">
                        <label class="label-datos "> hora final mantenimiento</label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">

                            <i class="fas fa-clock icon-input"></i>
                            <input type="time" name="form_2_hora_final_mantenimiento" id="form_2_hora_final_mantenimiento">

                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <fieldset>
                <legend><i class="fas fa-file-signature"></i> Firma Del Mecanico</legend>
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-4 col-12-small"></div>
                    <div class="col-4 col-12-small">
                        <div class="canvas-container" id="canvas_firma_1"></div>
                    </div>
                    <div class="col-4 col-12-small"></div>
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
            <button type="reset" id="form_2_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                CANCELAR</button>
        </div>


    </div>

</form>