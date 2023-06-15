<form id="form_1_informacion_mantenimientos" name="form_1_informacion_mantenimientos">
    <div class="row gtr-25 gtr-uniform ">
        <div class="col-12 align-center">
            <i class="fas fa-user-cog fa-3x"></i>
        </div>
        <div class="col-12">
            <fieldset>
                <legend> <i class="fas fa-info-circle"></i> Informacion del mantenimiento</legend>
                <div class="row gtr-50 gtr-uniform ">
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Tipo de mantenimiento </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-heartbeat icon-input"></i>
                            <select id="form_1_tipo_mantenimiento" name="form_1_tipo_mantenimiento" required="">
                                <option value="1">SIN_TIPO</option>
                                <option value="2">PREVENTIVO</option>
                                <option value="3">CORRECTIVO</option>
                                <option value="4">PREDICTIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Periodo del mantenimiento </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-heartbeat icon-input"></i>
                            <select id="form_1_periodo_mantenimiento" name="form_1_periodo_mantenimiento" required="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos">
                            Fecha inicial del mantenimiento
                        </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_1_fecha_mantenimiento" id="form_1_fecha_mantenimiento"
                                class="input_date_listener" autocomplete="off" value="01/01/2021" required="" />
                        </div>
                    </div>


                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Direccion </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-map-marked-alt icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Direccion del mantenimiento"
                                name="form_1_direccion_mantenimiento" id="form_1_direccion_mantenimiento"
                                autocomplete="off" required="">
                        </div>
                    </div>


                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Precio de la mano de obra (total) </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-hand-holding-usd icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="precio de la mano de obra (total)"
                                name="form_1_precio_mano_obra_mantenimiento" id="form_1_precio_mano_obra_mantenimiento"
                                autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Precio de los Repuestos (total) </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-dollar-sign icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="precio de los repuestos (total)"
                                name="form_1_precio_repuestos_obra_mantenimiento"
                                id="form_1_precio_repuestos_obra_mantenimiento" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Cantidad de Repuestos (total) </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-box-open icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="catidad de repuestos (total)"
                                name="form_1_cantidad_repuestos_obra_mantenimiento"
                                id="form_1_cantidad_repuestos_obra_mantenimiento" autocomplete="off" required="">
                        </div>
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
            <button type="reset" id="form_1_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>

    </div>

</form>