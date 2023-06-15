<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de examenes ocupacionales del conductor
    </legend>
    <div id="form_8_examen_ocupacional_resultados" class="accordion_form_resultados"></div>
</fieldset>

<form id="form_8_examen_ocupacional_conductor" name="form_8_examen_ocupacional_conductor">
    <div class="row gtr-50 gtr-uniform ">
        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="far fa-folder-open"></i> Agregar Examen Ocupacional
                </legend>
                <div class="row gtr-25 gtr-uniform ">
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Entidad que realiza el examen <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_8_entidad_examen_ocupacional_input" class="text-uppercase" required="" placeholder="ENTIDAD">
                            <input type="hidden" name="form_8_entidad_examen_ocupacional" id="form_8_entidad_examen_ocupacional_select" value="1" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos">Tipo Examen</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-thumbs-up icon-input"></i>
                            <select id="form_8_tipo_examen_ocupacional_conductor" name="form_8_tipo_examen_ocupacional_conductor" required="">
                                <option value="1">INGRESO</option>
                                <option value="2">EGRESO</option>
                                <option value="3">PERIODICOS</option>
                                <option value="4">PSICOTECNICOS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha expedición Examen </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_8_fecha_expedicion_examen_ocupacional_conductor" id="form_8_fecha_expedicion_examen_ocupacional_conductor" class="input_date_listener" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha vencimiento Examen</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_8_fecha_vencimiento_examen_ocupacional_conductor" id="form_8_fecha_vencimiento_examen_ocupacional_conductor" class="input_date_listener" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Recomendaciones </label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <textarea id="form_8_recomendacion_conductor" name="form_8_recomendacion_conductor" rows="2" required="" placeholder="RECOMENDACIONES"></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto Examen Ocupacional</label>
                                <input type="text" id="form_8_foto_examen_ocupacional" name="form_8_foto_examen_ocupacional" value="/images/sin_imagen.png" readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open" id="btn-form_8_foto_examen_ocupacional" data-folder="examen_ocupacional" input-id="form_8_foto_examen_ocupacional"></button>
                                <button class="button primary small btn-camera-open" id="btn-form_8_foto_examen_ocupacional" data-folder="examen_ocupacional" input-id="form_8_foto_examen_ocupacional"></button>
                                <button class="button primary small btn-camera-show" data-id="form_8_foto_examen_ocupacional"></button>
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
            <button type="reset" id="form_8_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>