<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de capacitaciones del conductor
    </legend>
    <div id="form_10_capacitaciones_conductor_resultados" class="accordion_form_resultados"></div>
</fieldset>

<form id="form_10_capacitacion_conductor" name="form_10_capacitacion_conductor">
    <div class="row gtr-50 gtr-uniform ">
        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="far fa-folder-open"></i> Agregar capacitacion
                </legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Nombre </label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_10_nombre_capacitacion" name="form_10_nombre_capacitacion" class="text-uppercase" required="" autocomplete="off" placeholder="Nombre Capacitación">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Entidad <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_10_entidad_capacitacion_input" class="text-uppercase" required="" placeholder="ENTIDAD">
                            <input type="hidden" name="form_10_entidad_capacitacion" id="form_10_entidad_capacitacion_select" value="1" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Tipo <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_10_tipo_capacitacion_input" class="text-uppercase" required="" placeholder="Tipo capacitación">
                            <input type="hidden" name="form_10_tipo_capacitacion" id="form_10_tipo_capacitacion_select" value="1" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha Realización </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_10_fecha_realizacion_capacitacion_conductor" id="form_10_fecha_realizacion_capacitacion_conductor" class="input_date_listener" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Duración </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="number" id="form_10_duracion_capacitacion_conductor" name="form_10_duracion_capacitacion_conductor" required="" class="text-uppercase" placeholder="Duración en horas"></textarea>
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Refuerzo </label>
                    </div>
                    <div class="col-4 col-12-small align-center">
                        <input type="radio" id="form_10_refuerzo_si" name="form_10_refuerzo" value="1" />
                        <label for="form_10_refuerzo_si">Si</label>
                        <input type="radio" id="form_10_refuerzo_no" name="form_10_refuerzo" value="2" checked />
                        <label for="form_10_refuerzo_no">No</label>
                    </div>
                    <div id="div_datos_refuerzo" class="col-12" hidden>
                        <div class="row gtr-25 gtr-uniform">
                            <div class="col-6 col-12-small"></div>
                            <div class="col-2 col-12-small">
                                <label class="label-datos "> Fecha de refuerzo </label>
                            </div>
                            <div class="col-4 col-12-small">
                                <div class="input-container">
                                    <i class="fas fa-calendar icon-input"></i>
                                    <input type="text" name="form_10_fecha_refuerzo_capacitacion" id="form_10_fecha_refuerzo_capacitacion" class="input_date_listener" value="01/01/2000" autocomplete="off" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto capacitacion</label>
                                <input type="text" id="form_10_foto_capacitacion" name="form_10_foto_capacitacion" value="/images/sin_imagen.png" readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open" id="btn-form_10_foto_capacitacion" data-folder="capacitacion_conductor" input-id="form_10_foto_capacitacion"></button>
                                <button class="button primary small btn-camera-open" id="btn-form_10_foto_capacitacion" data-folder="capacitacion_conductor" input-id="form_10_foto_capacitacion"></button>
                                <button class="button primary small btn-camera-show" data-id="form_10_foto_capacitacion"></button>
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
            <button type="reset" id="form_10_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>