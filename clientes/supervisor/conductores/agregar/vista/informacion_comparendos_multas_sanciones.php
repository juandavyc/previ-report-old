<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial de comparendos, multas ó sanciones del conductor
    </legend>
    <div id="form_7_comparendo_multa_sancion_resultados" class="accordion_form_resultados"></div>
</fieldset>

<form id="form_7_comparendo_multa_sancion_conductor" name="form_7_comparendo_multa_sancion_conductor">
    <div class="row gtr-50 gtr-uniform ">

    <div class = "col-12">

        <fieldset>
            <legend>
                <i class="far fa-folder-open"></i> Agregar comparendo / multa ó sanción
            </legend>

            <div class="row gtr-50 gtr-uniform ">

            <div class="col-2 col-12-small">
                    <label class="label-datos">Tipo</label>
                </div>
                <div class="col-4 col-12-small">
                    <div class="input-container">
                        <i class="fas fa-thumbs-up icon-input"></i>
                        <select id="form_7_tipo_comparendo_multa_sancion_conductor" name="form_7_tipo_comparendo_multa_sancion_conductor" required="">
                            <option value="1">COMPARENDO</option>
                            <option value="2">MULTA</option>
                            <option value="3">SANCION</option>
                        </select>
                    </div>
                </div>
                <div class="col-2 col-12-small">
                    <label class="label-datos "> Fecha </label>
                </div>
                <div class="col-4 col-12-small">
                    <div class="input-container">
                        <i class="fas fa-calendar icon-input"></i>
                        <input type="text" name="form_7_fecha_comparendo_multa_sancion_conductor" id="cform_7_fecha_comparendo_multa_sancion_conductor" class="input_date_listener" autocomplete="off" value="01/01/2000" required="">
                    </div>
                </div>

                <div class="col-2 col-12-small">
                    <label class="label-datos">Motivo</label>
                </div>
                <div class="col-10 col-12-small">
                    <div class="input-container">
                        <textarea id="form_7_motivo_comparendo_multa_sancion_conductor" name="form_7_motivo_comparendo_multa_sancion_conductor" rows="2" required="" placeholder="MOTIVO DEL COMPARENDO, MULTA O SANCION"></textarea>
                    </div>
                </div>

                <div class="col-12 col-12-small">
                    <div class="photo-control">
                        <div class="photo-info">
                            <label>Foto de comparendo / multa ó sanción</label>
                            <input type="text" id="form_7_foto_comparendo_multa_sancion" name="form_7_foto_comparendo_multa_sancion" value="/images/sin_imagen.png" readonly required />
                        </div>
                        <div class="photo-buttons">
                            <button class="button primary small btn-camera-open" id="btn-form_7_foto_comparendo_multa_sancion" data-folder="comparendo_multa_sancion" input-id="form_7_foto_comparendo_multa_sancion"></button>
                            <button class="button primary small btn-camera-show" data-id="form_7_foto_comparendo_multa_sancion"></button>
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
            <button type="reset" id="form_7_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>
    </div>
</form>