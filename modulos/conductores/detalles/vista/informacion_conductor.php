<form id="form_1_informacion_basica" name="form_1_informacion_basica">
    <div class="row gtr-50 gtr-uniform">
        <div class="col-12 align-center">
            <i class="fas fas fa-camera fa-3x"></i>
        </div>
        <!-- <span class="image fit">
          <a href="/images/sin_imagen.png" class="licencia-images-link" id="form_12_href_licencia_delantera">
            <img src="/images/sin_imagen.png">
          </a>
        </span> -->
        <div class="col-3 col-12-mobilep"></div>
        <div class="col-6 col-12-mobilep align-center">
            <span class="image fit">
                <a href="/images/sin_imagen.png" class="licencia-images-link" id="form_1_href_foto_conductor" target="_blank">
                    <img src="/images/sin_imagen.png">
                </a>
            </span>
            <label>Foto conductor</label>
        </div>
        <div class="col-3 col-12-mobilep"></div>
        <div class="col-12">
            <fieldset>
                <legend><i class="fas fa-info-circle"></i> Información Básica del conductor</legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-12">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label>Foto conductor</label>
                                <input type="text" id="form_1_foto_conductor" name="form_1_foto_conductor" value="/images/sin_imagen.png" readonly required />
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open" id="btn-form_1_foto_conductor" data-folder="conductores" input-id="form_1_foto_conductor"></button>
                                <button class="button primary small btn-camera-open" id="btn-form_1_foto_conductor" data-folder="conductores" input-id="form_1_foto_conductor"></button>
                                <button class="button primary small btn-camera-show" data-id="form_1_foto_conductor"></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Nombre </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-signature icon-input"></i>
                            <!-- <input onClick="this.select();" class="text-uppercase" type="text" placeholder="NOMBRES" name="form_1_nombre_conductor" id="form_1_nombre_conductor" autocomplete="off" required=""> -->
                            <input class="text-uppercase" type="text" placeholder="NOMBRES" name="form_1_nombre_conductor" id="form_1_nombre_conductor" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos "> Apellidos </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-signature icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="APELLIDOS" name="form_1_apellido_conductor" id="form_1_apellido_conductor" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos ">Documento </label>
                    </div>

                    <div class="col-4 col-12-small align-center">

                        <label id="form_1_documento_conductor" class="label-resultados"></label>
                        <!-- <select id="form_1_tipo_identificacion" name="form_1_tipo_identificacion" required="">
                        <option value="1">C.C</option>
                        <option value="2">NIT</option>
                    </select> -->
                    </div>


                    <div class="col-2 col-12-small">
                        <label class="label-datos">Tipo de identificación </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-id-badge icon-input"></i>
                            <select id="form_1_tipo_identificacion" name="form_1_tipo_identificacion" required="">
                                <option value="1">C.C</option>
                                <option value="2">NIT</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-datos">Tipo de sangre (RH) </label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-heartbeat icon-input"></i>
                            <select id="form_1_tipo_sangre_conductor" name="form_1_tipo_sangre_conductor" required="">
                                <option value="1">SIN_TIPO_DE_SANGRE</option>
                                <option value="2">O-</option>
                                <option value="3">O+</option>
                                <option value="4">A-</option>
                                <option value="5">A+</option>
                                <option value="6">B-</option>
                                <option value="7">B+</option>
                                <option value="8">AB-</option>
                                <option value="9">AB+</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos">Direccion</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">

                            <i class="fas fa-directions icon-input"></i>
                            <input type="text" name="form_1_direccion_conductor" id="form_1_direccion_conductor" autocomplete="off" required="" class="text-uppercase" placeholder="### ######">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos">Telefono</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-phone-alt icon-input"></i>
                            <input type="text" name="form_1_telefono_conductor" id="form_1_telefono_conductor" autocomplete="off" required="" class="text-uppercase" placeholder="000 0000">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos">Celular</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-mobile icon-input"></i>
                            <input type="text" name="form_1_celular_conductor" id="form_1_celular_conductor" autocomplete="off" required="" class="text-uppercase" placeholder="000 000 0000">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos">WhatsApp</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fab fa-whatsapp icon-input"></i>
                            <input type="text" name="form_1_whatsapp_conductor" id="form_1_whatsapp_conductor" autocomplete="off" required="" class="text-uppercase" placeholder="000 000 0000">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos">Correo Electronico</label>
                    </div>
                    <div class="col-4 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-at icon-input"></i>
                            <input type="text" name="form_1_correo_electronico_conductor" id="form_1_correo_electronico_conductor" autocomplete="off" required="" class="text-uppercase" placeholder="CORREO@CORREO.COM">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Departamento <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="fas fa-flag icon-input"></i>
                            <input type="text" id="form_1_departamento_conductor_input" value="SIN_DEPARTAMENTO" placeholder="Nombre de la clase" class="text-uppercase" required="">
                            <input type="hidden" name="form_1_departamento_conductor" id="form_1_departamento_conductor_select" value="0" required="">
                        </div>
                    </div>

                    <div class="col-2 col-12-small">
                        <label class="label-datos"> Ciudad <b class="list-key"></b></label>
                    </div>
                    <div class="col-4 col-12-small ">
                        <div class="input-container">
                            <i class="fas fa-city icon-input"></i>
                            <input type="text" id="form_1_ciudad_conductor_input" value="SIN_CIUDAD" class="text-uppercase" required="">
                            <input type="hidden" name="form_1_ciudad_conductor" id="form_1_ciudad_conductor_select" value="0" required="">
                        </div>
                    </div>
                    <div class="col-2 col-12-small">
                        <label class="label-important label-datos">
                            Empresa <b class="list-key"></b>
                        </label>
                    </div>
                    <div class="col-10 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-industry icon-input"></i>
                            <input type="text" a="" id="form_1_empresa_input" value="SIN EMPRESA" placeholder="Empresa" class="text-uppercase autocomplete ui-autocomplete-input" required="">
                            <input type="hidden" name="form_1_empresa" id="form_1_empresa_select" value="1" data-default="1" required="">
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-12">
            <fieldset>
                <legend><i class="fas fa-file-signature"></i> Firma Del Conductor</legend>
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-3 col-12-small"></div>
                    <div class="col-6 col-12-small">
                        <div class="canvas-container" id="canvas_firma_1"></div>
                    </div>
                    <div class="col-3 col-12-small"></div>
                </div>
            </fieldset>
        </div>


        <!-- <div class="col-12 canvas_graficos_container" style="padding: 2px !important;margin-left: 11px !important;">
                <label class="align-center" id="label_firma_canvas">FIRMA USUARIO</label>
                <center>
                    <canvas id="canvas_2_graficos" style="background: #FFF;border-radius: 4px;" width="823.167" height="287.7223333333333"></canvas>
                    <br>
                    <button class="button primary icon solid fa-trash" id="canvas_2_borrar" style="background:#963333;">Borrar</button>
                </center>
                <input type="hidden" id="is_used_canvas_firma" value="1" readonly="">
            </div>-->

        <div class="col-6 col-12-small">
            <input type="submit" value="guardar" class="primary small fit">
        </div>
        <div class="col-6 col-12-small">
            <button type="reset" class="button primary small fit btn-limpiar-formulario" disabled>
                CANCELAR</button>
        </div>


        <!-- <div class="col-12 col-12-small">
                <button id="form_1_limpiar_formulario" class="button primary small fit"> SIGUIENTE </button>
            </div> -->

    </div>
</form>