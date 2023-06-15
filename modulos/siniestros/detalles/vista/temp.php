<div id="container-datos-siniestro">
    <form id="form_0_informacion_siniestro" name="form_0_informacion_siniestro">
        <div class="row gtr-50 gtr-uniform ">
            <div class="col-12 align-center">
                <i class="fas fa-info-circle fa-3x"></i>
            </div>
            <div class="col-12">
                <fieldset>
                    <legend> <i class="fas fa-car-crash"></i> Detalles del Siniestro</legend>
                    <div class="row gtr-25 gtr-uniform ">
                        <div class="col-2 col-12-small">
                            <label class="label-datos"> Placa </label>
                        </div>
                        <div class="col-4 col-12-small">
                            <label class="label-resultados" id="form_0_placa">aaa777</label>
                        </div>
                        <div class="col-2 col-12-small">
                            <label class="label-datos"> Conductor </label>
                        </div>
                        <div class="col-4 col-12-small">
                            <label class="label-resultados" id="form_0_conductor">PEPIT33SSO PEREZ PEREZ PEREZ </label>
                        </div>
                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos"> Tipo siniestro </label>
                        </div>
                        <div class="col-4 col-12-small">
                            <div class="input-container">
                                <i class="fa fa-hospital icon-input"></i>
                                <select id="form_0_tipo_siniestro" name="form_0_tipo_siniestro" required="">
                                    <option value="1">ACCIDENTE</option>
                                    <option value="2">INCIDENTE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos"> Fecha</label>
                        </div>
                        <div class="col-4 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-calendar icon-input"></i>
                                <input type="text" name="form_0_fecha_siniestro" id="form_0_fecha_siniestro"
                                    class="input_date_listener hasDatepicker" autocomplete="off" value="01/01/2000"
                                    required=""><button type="button" class="ui-datepicker-trigger"></button>
                            </div>
                        </div>
                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos "> Hora Aprox. </label>
                        </div>
                        <div class="col-4 col-12-small">
                            <div class="input-container">

                                <i class="fas fa-clock icon-input"></i>
                                <input type="time" name="form_0_hora_siniestro" id="form_0_hora_siniestro">

                            </div>
                        </div>
                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos"> Departamento </label>
                        </div>
                        <div class="col-4 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-flag icon-input"></i>
                                <input class="text-uppercase" type="text" placeholder="Departamento del Siniestro"
                                    name="form_0_departamento_siniestro" id="form_0_departamento_siniestro"
                                    autocomplete="off" required="">
                            </div>
                        </div>

                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos"> Ciudad </label>
                        </div>
                        <div class="col-4 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-city icon-input"></i>
                                <input class="text-uppercase" type="text" placeholder="Ciudad del Siniestro"
                                    name="form_0_ciudad_siniestro" id="form_0_ciudad_siniestro" autocomplete="off"
                                    required="">
                            </div>
                        </div>

                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos"> Lugar o Dirección </label>
                        </div>
                        <div class="col-4 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-map-marked-alt icon-input"></i>
                                <input class="text-uppercase" type="text" placeholder="Lugar del Siniestro"
                                    name="form_0_lugar_siniestro" id="form_0_lugar_siniestro" autocomplete="off"
                                    required="">
                            </div>
                        </div>

                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos"> Heridos </label>
                        </div>
                        <div class="col-2 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-user-injured icon-input"></i>
                                <select id="form_0_heridos_siniestro" name="form_0_heridos_siniestro" required="">
                                    <option value="1">NO</option>
                                    <option value="2">SI</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos"> Muertos </label>
                        </div>
                        <div class="col-2 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-skull-crossbones icon-input"></i>
                                <select id="form_0_muertos_siniestro" name="form_0_muertos_siniestro" required="">
                                    <option value="1">NO</option>
                                    <option value="2">SI</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-2 col-12-small">
                            <label class="label-important label-datos"> Vehiculos Implicados </label>
                        </div>
                        <div class="col-2 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-car-side icon-input"></i>
                                <select id="form_0_vehiculos_implicados_siniestro"
                                    name="form_0_vehiculos_implicados_siniestro" required="">
                                    <option value="1">NO</option>
                                    <option value="2">SI</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-12">
                <fieldset>
                    <legend> <i class="fas fa-male"></i> DATOS AGENTE DE TRANSITO</legend>

                    <div class="row gtr-50 gtr-uniform ">

                        <div class="col-4 col-12-small">
                            <label class="label-datos "> Nombre Del agente de transito </label>
                        </div>
                        <div class="col-8 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-user-edit icon-input"></i>
                                <input class="text-uppercase" type="text" placeholder="Nombre del agente de transito"
                                    name="form_0_nombre_agente_transito_siniestro"
                                    id="form_0_nombre_agente_transito_siniestro" autocomplete="off" required="">
                            </div>
                        </div>

                        <div class="col-4 col-12-small">
                            <label class="label-datos "> Telefono Del agente de transito </label>
                        </div>
                        <div class="col-8 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-tty icon-input"></i>
                                <input class="text-uppercase" type="text" placeholder="Telefono Del agente de transito"
                                    name="form_0_telefono_agente_transito_siniestro"
                                    id="form_0_telefono_agente_transito_siniestro" autocomplete="off" required="">
                            </div>
                        </div>

                        <div class="col-4 col-12-small">
                            <label class="label-datos "> Correo Del agente de transito </label>
                        </div>
                        <div class="col-8 col-12-small">
                            <div class="input-container">
                                <i class="fas fa-at icon-input"></i>
                                <input class="text-uppercase" type="text" placeholder="Correo Del agente de transito"
                                    name="form_0_correo_agente_transito_siniestro"
                                    id="form_0_correo_agente_transito_siniestro" autocomplete="off" required="">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-12">
                <fieldset>
                    <legend> <i class="far fa-clipboard"></i> DETALLES DEL SINIESTRO</legend>

                    <div class="row gtr-50 gtr-uniform ">

                        <div class="col-12">
                            <hr class="hr-text" data-content="DESCRIPCION DEL SINIESTRO">
                        </div>
                        <div class="col-12">
                            <textarea id="form_0_descripcion_siniestro" name="form_0_descripcion_siniestro" rows="2"
                                required="">...</textarea>
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
                <button type="reset" id="form_0_limpiar_formulario"
                    class="button primary small fit btn-limpiar-formulario">
                    LIMPIAR FORMULARIO</button>
            </div>

        </div>

    </form>

</div>
