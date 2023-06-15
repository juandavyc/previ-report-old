<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de Licencias de conducción del conductor
    </legend>
    <div id="form_6_licencia_conductor_resultados" class="accordion_form_resultados"></div>
</fieldset>

<form id="form_6_licencia_conductor" name="form_6_licencia_conductor">
    <div class="row gtr-50 gtr-uniform ">

        <div class="col-12">

            <fieldset>
                <legend>
                    <i class="far fa-folder-open"></i> Agregar Licencia De conducción
                </legend>
                <div class="row gtr-25 gtr-uniform ">
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Numero de licencia<b class="list-key"></b></label>
                    </div>
                    <div class="col-10 col-12-small ">
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-up-alt icon-input"></i>
                            <input type="text" name="form_6_numero_licencia_conductor"
                                id="form_6_numero_licencia_conductor" required="" autocomplete="off" placeholder="Numero de licencia">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha de expedición </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_6_fecha_expedicion_licencia_conductor"
                                id="form_6_fecha_expedicion_licencia_conductor" class="input_date_listener"
                                autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Fecha de Vencimiento </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_6_fecha_vencimiento_licencia_conductor"
                                id="form_6_fecha_vencimiento_licencia_conductor" class="input_date_listener"
                                autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos">Estado</label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-toggle-on icon-input"></i>
                            <select id="form_6_licencia_conductor_estado_conductor"
                                name="form_6_licencia_conductor_estado_conductor" required="" value=2>
                                <option value="1">ACTIVO</option>
                                <option value="2">INACTIVO</option>
                                <option value="3">SUSPENDIDO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos"> categoria </label>
                    </div>
                    <div class="col-9 col-12-small align-center">
                        <input type="checkbox" id="form_6_categoria_a1" name="form_6_categoria" value="9"
                            class="form_categoria" />
                        <label for="form_6_categoria_a1">A1</label>
                        <input type="checkbox" id="form_6_categoria_a2" name="form_6_categoria" value="2"
                            class="form_categoria" />
                        <label for="form_6_categoria_a2">A2</label>
                        <input type="checkbox" id="form_6_categoria_b1" name="form_6_categoria" value="3"
                            class="form_categoria" />
                        <label for="form_6_categoria_b1">B1</label>
                        <input type="checkbox" id="form_6_categoria_b2" name="form_6_categoria" value="4"
                            class="form_categoria" />
                        <label for="form_6_categoria_b2">B2</label>
                        <input type="checkbox" id="form_6_categoria_b3" name="form_6_categoria" value="5"
                            class="form_categoria" />
                        <label for="form_6_categoria_b3">B3</label>
                        <input type="checkbox" id="form_6_categoria_c1" name="form_6_categoria" value="6"
                            class="form_categoria" />
                        <label for="form_6_categoria_c1">C1</label>
                        <input type="checkbox" id="form_6_categoria_c2" name="form_6_categoria" value="7"
                            class="form_categoria" />
                        <label for="form_6_categoria_c2">C2</label>
                        <input type="checkbox" id="form_6_categoria_c3" name="form_6_categoria" value="8"
                            class="form_categoria" />
                        <label for="form_6_categoria_c3">C3</label>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos">Restriccion</label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <textarea id="form_6_restriccion_conductor" name="form_6_restriccion_conductor" rows="2"
                                required="" placeholder="RESTRICCIONES DEL CONDUCTOR"></textarea>
                        </div>
                    </div>

                    <div class="col-12 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto de licencia de conducción delantera</label>
                                <input type="text" id="form_6_foto_licencia_conductor_delantera"
                                    name="form_6_foto_licencia_conductor_delantera" value="/images/sin_imagen.png"
                                    readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open"
                                    id="btn-form_6_foto_licencia_conductor_delantera" data-folder="licencia_conductor"
                                    input-id="form_6_foto_licencia_conductor_delantera"></button>
                                <button class="button primary small btn-camera-open"
                                    id="btn-form_6_foto_licencia_conductor_delantera" data-folder="licencia_conductor"
                                    input-id="form_6_foto_licencia_conductor_delantera"></button>
                                <button class="button primary small btn-camera-show"
                                    data-id="form_6_foto_licencia_conductor_delantera"></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto de licencia de conducción trasera</label>
                                <input type="text" id="form_6_foto_licencia_conductor_trasera"
                                    name="form_6_foto_licencia_conductor_trasera" value="/images/sin_imagen.png"
                                    readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open"
                                    id="btn-form_6_foto_licencia_conductor_trasera" data-folder="licencia_conductor"
                                    input-id="form_6_foto_licencia_conductor_trasera"></button>
                                <button class="button primary small btn-camera-open"
                                    id="btn-form_6_foto_licencia_conductor_trasera" data-folder="licencia_conductor"
                                    input-id="form_6_foto_licencia_conductor_trasera"></button>
                                <button class="button primary small btn-camera-show"
                                    data-id="form_6_foto_licencia_conductor_trasera"></button>
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
            <button type="reset" id="form_6_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>