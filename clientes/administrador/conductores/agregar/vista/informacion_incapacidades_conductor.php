<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de incapacidades del conductor
    </legend>
    <div id="form_11_incapacidades_conductor_resultados" class="accordion_form_resultados"></div>
</fieldset>

<form id="form_11_incapacidad_conductor" name="form_11_incapacidad_conductor">
    <div class="row gtr-50 gtr-uniform ">

        <div class="col-12">

            <fieldset>
                <legend>
                    <i class="far fa-folder-open"></i> Agregar incapacidad
                </legend>

                <div class="row gtr-50 gtr-uniform ">


                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Nro de dias </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <input type="number" id="form_11_dias_incapacidad_conductor" name="form_11_dias_incapacidad_conductor" required="" class="text-uppercase" placeholder="Numero de dias"></textarea>
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Nombre Eps <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_11_eps_incapacidad_input" class="text-uppercase" required="" placeholder="EPS">
                            <input type="hidden" name="form_11_eps_incapacidad" id="form_11_eps_incapacidad_select" value="1" required="">
                        </div>
                    </div>



                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Nombre Arl <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_11_arl_incapacidad_input" class="text-uppercase" required="" placeholder="ARL">
                            <input type="hidden" name="form_11_arl_incapacidad" id="form_11_arl_incapacidad_select" value="1" required="">
                        </div>
                    </div>
                    
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha de Inicio </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_11_fecha_inicio_incapacidad_conductor" id="form_11_fecha_inicio_incapacidad_conductor" class="input_date_listener" autocomplete="off" value="01/01/2000" required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha de fin </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_11_fecha_fin_incapacidad_conductor" id="form_11_fecha_fin_incapacidad_conductor" class="input_date_listener" autocomplete="off" value="01/01/2000" required="">
                        </div>
                    </div>
                    <div class="col-6 col-12-small"></div>


                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Concepto </label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <textarea id="form_11_concepto_incapacidad" name="form_11_concepto_incapacidad" rows="2" required="" placeholder="CONCEPTO DE LA INCAPACIDAD"></textarea>
                        </div>
                    </div>


                    <div class="col-12 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto incapacidad</label>
                                <input type="text" id="form_11_foto_incapacidad" name="form_11_foto_incapacidad" value="/images/sin_imagen.png" readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-camera-open" id="btn-form_11_foto_incapacidad" data-folder="incapacidad_conductor" input-id="form_11_foto_incapacidad"></button>
                                <button class="button primary small btn-camera-show" data-id="form_11_foto_incapacidad"></button>
                            </div>
                        </div>
                    </div>

                </div>
            </fieldset>
        </div>

        <div class="col-6 col-12-small">
            <input type="submit" value="guardar" class="primary small fit">
        </div>
        <div class="col-6 col-12-small">
            <button type="reset" id="form_11_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>