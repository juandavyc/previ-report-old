<fieldset>
    <legend>
        <i class="far fa-folder-open"></i> Historial Fotos del mantenimiento  </legend>
    <div id="form_3_fotos_resultados" class="accordion_form_resultados"></div>
</fieldset>

<form id="form_3_fotos_mantenimiento" name="form_3_fotos_mantenimiento">


    <div class="row gtr-50 gtr-uniform ">

        <div class="col-12 align-center">
            <!-- <i class="fas fa-chalkboard-teacher fa-3x"></i> -->
        </div>

        <div class="col-12">
            <fieldset>
                <legend> <i class="far fa-clipboard"></i> Informacion del procedimiento</legend>

                <div class="row gtr-50 gtr-uniform ">

                    <div class="col-12">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Fotografia</label>
                                <input type="text" id="form_3_foto" name="form_3_foto" value="/images/sin_imagen.png" readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-camera-open" id="btn-form_3_foto" data-folder="fotos_mantenimiento" input-id="form_3_foto"></button>
                                <button class="button primary small btn-camera-show" data-id="form_3_foto"></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Tipo de mantenimiento </label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-heartbeat icon-input"></i>
                            <select id="form_3_categoria_foto" name="form_3_categoria_foto" required="">
                                <option value="7">PREREPARACION</option>
                                <option value="2">REPUESTO DAÑADO</option>
                                <option value="3">REPUESTO NUEVO</option>
                                <option value="4">POST REPARACION</option>
                                <option value="5">FACTURA O RECIBO</option>
                                <option value="6">FACTURA MANO DE OBRA</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos ">Descripcion De la fotografía</label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <textarea id="form_3_descripcion_foto" name="form_3_descripcion_foto" rows="2" required="" placeholder="DESCRIPCION DE LA FOTO TOMADA"></textarea>
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
            <button type="reset" id="form_3_limpiar_formulario" class="button primary small fit btn-limpiar-formulario">
                LIMPIAR FORMULARIO</button>
        </div>


    </div>

</form>