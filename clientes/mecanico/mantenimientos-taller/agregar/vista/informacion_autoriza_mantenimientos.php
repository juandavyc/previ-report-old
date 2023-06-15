<div id="container-informacion-autoriza-mantenimientos">
    <form id="form_1_informacion_autoriza_mantenimientos" name="form_1_informacion_autoriza_mantenimientos">


        <div class="row gtr-50 gtr-uniform ">
         <div class="col-12 align-center">
            <i class="fas fa-wrench fa-3x"></i>
        </div>

        <div class="col-12">
            <fieldset>  
                <legend > <i class="fas fa-user-check"></i> Quien Autoriza Mantenimiento</legend>

                <div class="row gtr-50 gtr-uniform ">
                    
                    <div class="col-4 col-12-small">
                        <label class="label-datos "> Periodo del Mantenimiento </label>
                    </div>
                    <div class="col-8 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-business-time icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Periodo Del Mantenimiento" name="form_1_periodo_mantenimiento" id="form_1_periodo_mantenimiento" autocomplete="off" required="">
                        </div>
                    </div>


                    <div class="col-4 col-12-small">
                        <label class="label-datos "> Nombre de quien autoriza el mantenimiento</label>
                    </div>
                    <div class="col-8 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-user-check icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Nombre de quien autoriza el mantenimiento" name="form_1_nombre_autoriza_mantenimiento" id="form_1_nombre_autoriza_mantenimiento" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="col-4 col-12-small">
                        <label class="label-datos "> Documento de quien autoriza el mantenimiento</label>
                    </div>
                    <div class="col-8 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-address-card icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Documento de quien autoriza el mantenimiento" name="form_1_documento_autoriza_mantenimiento" id="form_1_documento_autoriza_mantenimiento" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="col-4 col-12-small">
                        <label class="label-datos "> Telefono de quien autoriza el mantenimiento</label>
                    </div>
                    <div class="col-8 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-tty icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Telefono de quien autoriza el mantenimiento" name="form_1_telefono_autoriza_mantenimiento" id="form_1_telefono_autoriza_mantenimiento" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="col-4 col-12-small">
                        <label class="label-datos "> Cargo de quien autoriza el mantenimiento</label>
                    </div>
                    <div class="col-8 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-sitemap icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="cargo de quien autoriza el mantenimiento" name="form_1_cargo_autoriza_mantenimiento" id="form_1_cargo_autoriza_mantenimiento" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Orden de servicio</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-sort-amount-down-alt icon-input"></i>
                            <select id="form_1_orden_servicio_mantenimiento" name="form_1_orden_servicio_mantenimiento" required="">
                                <option value="1">SI</option>
                                <option value="2">NO</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Nº Orden de servicio</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-up-alt icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder=" Nº Orden de servicio" name="form_1_numero_orden_servicio_mantenimiento" id="form_1_numero_orden_servicio_mantenimiento" autocomplete="off" required="">
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>



        <div class="col-12">
            <fieldset>
                <legend> <i class="fas fa-file-signature"></i> Firma Quien Autoriza El Mantenimiento</legend>
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-4 col-12-small"></div>
                    <div class="col-4 col-12-small">
                        <div class="canvas-container" id="canvas_firma_1_quien_autoriza_mantenimiento"></div>
                    </div>
                    <div class="col-4 col-12-small"></div>
                </div>
            </fieldset>
        </div>

            <!-- <div class="col-12 canvas_graficos_container" style="padding: 2px !important;margin-left: 11px !important;">
                <label class="align-center" id="label_firma_canvas">FIRMA</label>
                <center>
                    <canvas id="canvas_2_graficos" style="background: #FFF;border-radius: 4px;" width="823.167" height="287.7223333333333"></canvas>
                    <br>
                    <button class="button primary icon solid fa-trash" id="canvas_2_borrar" style="background:#963333;">Borrar</button>
                </center>
                <input type="hidden" id="is_used_canvas_firma" value="1" readonly="">
            </div> -->

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

</div>