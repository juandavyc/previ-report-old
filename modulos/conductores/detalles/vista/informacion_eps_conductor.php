<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de Eps del conductor
    </legend>
    <div id="form_3_eps_resultados" class="accordion_form_resultados"></div>
</fieldset>

<form id="form_3_eps_conductor" name="form_3_eps_conductor">
    <div class="row gtr-50 gtr-uniform ">

        <div class="col-12">

            <fieldset>
                <legend>
                    <i class="far fa-folder-open"></i> Agregar EPS del conductor
                </legend>
                <div class="row gtr-25 gtr-uniform ">

                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Eps <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_3_eps_conductor_input" class="text-uppercase" required=""
                                placeholder="NOMBRE EPS">
                            <input type="hidden" name="form_3_eps_conductor" id="form_3_eps_conductor_select" value="1"
                                required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha de Afilicación </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_3_eps_fecha_afiliacion_conductor"
                                id="form_3_eps_fecha_afiliacion_conductor" class="input_date_listener"
                                autocomplete="off"  required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos">Estado</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-thumbs-up icon-input"></i>
                            <select id="form_3_eps_estado_conductor" name="form_3_eps_estado_conductor" required=""
                                value=2>
                                <option value="1">ACTIVO</option>
                                <option value="2">INACTIVO</option>
                                <option value="3">SUSPENDIDO</option>
                                <option value="4">NO AFILIADO</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto certificado EPS</label>
                                <input type="text" id="form_3_foto_eps" name="form_3_foto_eps"
                                    value="/images/sin_imagen.png" readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open" id="btn-form_3_foto_eps"
                                    data-folder="eps" input-id="form_3_foto_eps"></button>
                                <button class="button primary small btn-camera-open" id="btn-form_3_foto_eps"
                                    data-folder="eps" input-id="form_3_foto_eps"></button>
                                <button class="button primary small btn-camera-show" data-id="form_3_foto_eps"></button>
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
            <button type="reset" id="form_3_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>