<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de cursos del conductor
    </legend>
    <div id="form_9_cursos_conductor_resultados" class="accordion_form_resultados"></div>
</fieldset>

<form id="form_9_curso_conductor" name="form_9_curso_conductor">
    <div class="row gtr-50 gtr-uniform ">

        <div class="col-12">

            <fieldset>
                <legend>
                    <i class="far fa-folder-open"></i> Agregar Curso
                </legend>

                <div class="row gtr-50 gtr-uniform ">


                <div class="col-2 col-12-small">
                        <label class="label-datos"> Nombre Curso</label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_9_nombre_curso" name="form_9_nombre_curso" class="text-uppercase" required="" placeholder="NOMBRE DEL CURSO">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Logro Obtenido</label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_9_logro_curso" name="form_9_logro_curso" class="text-uppercase" required="" placeholder="Logro obtenido">
                        </div>
                    </div>


                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Entidad que realiza el curso <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="far fa-hospital icon-input"></i>
                            <input type="text" id="form_9_entidad_curso_input" class="text-uppercase" required="" placeholder="ENTIDAD">
                            <input type="hidden" name="form_9_entidad_curso" id="form_9_entidad_curso_select" value="1" required="">
                        </div>
                    </div>


                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha Realización curso </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_9_fecha_realizacion_curso_conductor" id="form_9_fecha_realizacion_curso_conductor" class="input_date_listener" autocomplete="off" value="01/01/2000" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha Expiración Examen</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_9_fecha_expiracion_curso_conductor" id="form_9_fecha_expiracion_curso_conductor" class="input_date_listener" autocomplete="off" value="01/01/2000" required="">
                        </div>
                    </div>
        <div  class="col-6 col-12-small"></div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Observaciones </label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <textarea id="form_9_observacion_curso_conductor" name="form_9_observacion_curso_conductor" rows="2" required="" placeholder="OBSERVACIONES"></textarea>
                        </div>
                    </div>

                    <div class="col-12 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto Curso</label>
                                <input type="text" id="form_9_foto_curso" name="form_9_foto_curso" value="/images/sin_imagen.png" readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-camera-open" id="btn-form_9_foto_curso" data-folder="curso_conductor" input-id="form_9_foto_curso"></button>
                                <button class="button primary small btn-camera-show" data-id="form_9_foto_curso"></button>
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
            <button type="reset" id="form_9_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>