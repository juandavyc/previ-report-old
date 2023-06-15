<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de arl del conductor
    </legend>
    <div id="form_4_arl_resultados" class="accordion_form_resultados"></div>
</fieldset>
<form id="form_4_arl_conductor" name="form_4_arl_conductor">

    <div class="row gtr-50 gtr-uniform ">

        <div class="col-12">

        </div>

        <div class="col-12">


            <fieldset>
                <legend><i class="far fa-folder-open"></i> Agregar ARL del conductor
                </legend>

                <div class="row gtr-50 gtr-uniform ">

                    <div class="col-2 col-12-small">
                        <label class="label-datos"> ARL <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">



                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_4_arl_conductor_input" class="text-uppercase" required="" placeholder="NOMBRE ARL">
                            <input type="hidden" name="form_4_arl_conductor" id="form_4_arl_conductor_select" value="1" required="">
                        </div>
                    </div>


                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha de Afilicación </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_4_arl_fecha_afiliacion_conductor" id="form_4_arl_fecha_afiliacion_conductor" class="input_date_listener" autocomplete="off" value="01/01/2000" required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos">Estado</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-thumbs-up icon-input"></i>
                            <select id="form_4_arl_estado_conductor" name="form_4_arl_estado_conductor" required="" value=2>
                                <option value="1">ACTIVO</option>
                                <option value="2">INACTIVO</option>
                                <option value="3">SUSPENDIDO</option>
                                <option value="4">NO AFILIADO</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto certificado ARL</label>
                                <input type="text" id="form_4_foto_arl" name="form_4_foto_arl" value="/images/sin_imagen.png" readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-camera-open" id="btn-form_4_foto_arl" data-folder="arl" input-id="form_4_foto_arl"></button>
                                <button class="button primary small btn-camera-show" data-id="form_4_foto_arl"></button>
                            </div>
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
            <button type="reset" id="form_4_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>