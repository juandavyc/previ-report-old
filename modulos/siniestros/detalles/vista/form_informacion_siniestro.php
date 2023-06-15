<form id="form_0_informacion" name="form_0_informacion">
    <div class="row gtr-25 gtr-uniform ">
        <div class="col-12 align-center">
            <i class="fas fa-info-circle fa-3x"></i>
        </div>
        <div class="col-12">
            <fieldset>
                <legend> <i class="fas fa-car-crash"></i> Descripción del siniestro</legend>
                <div class="row gtr-25 gtr-uniform ">
                    <div class="col-3 col-12-small">
                        <label class="label-datos"> Placa </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-resultados" id="form_0_placa"></label>
                    </div>
                    <div class="col-6 col-12-small"> </div>
                    <div class="col-3 col-12-small">
                        <label class="label-datos"> Conductor </label>
                    </div>
                    <div class="col-9 col-12-small">
                        <label class="label-resultados" id="form_0_conductor"></label>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos"> Tipo siniestro </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fa fa-hospital icon-input"></i>
                            <select id="form_0_tipo" name="form_0_tipo" required="">
                                <option value="1">ACCIDENTE</option>
                                <option value="2">INCIDENTE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos"> Fecha</label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="form_0_fecha" id="form_0_fecha" class="input_date_listener"
                                autocomplete="off" value="01/01/2000" required="">
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos "> Hora Aprox. <b>( 24 Militar)</b> </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-clock icon-input"></i>
                            <input type="time" name="form_0_hora" id="form_0_hora" required>
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos"> Departamento </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-flag icon-input"></i>
                            <input type="text" id="form_0_departamento_input" placeholder="Departamento"
                                class="text-uppercase" required="" autocomplete="off">
                            <input type="hidden" id="form_0_departamento_select" value="1" data-default="1" required="">
                        </div>
                    </div>

                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos"> Ciudad </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-city icon-input"></i>
                            <input type="text" id="form_0_ciudad_input" placeholder="Ciudad" class="text-uppercase"
                                required="" autocomplete="off">
                            <input type="hidden" id="form_0_ciudad_select" name="form_0_ciudad" value="1"
                                data-default="1" required="">
                        </div>
                    </div>

                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos"> Lugar o Dirección </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-map-marked-alt icon-input"></i>
                            <input class="text-uppercase" type="text" placeholder="Lugar o Dirección"
                                name="form_0_lugar" id="form_0_lugar" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos"> Heridos </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-user-injured icon-input"></i>
                            <select id="form_0_heridos" name="form_0_heridos" required="">
                                <option value="1">SI</option>
                                <option value="2">NO</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos"> Muertos </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-skull-crossbones icon-input"></i>
                            <select id="form_0_muertos" name="form_0_muertos" required="">
                                <option value="1">SI</option>
                                <option value="2">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-important label-datos"> Vehiculos Implicados </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <div class="input-container">
                            <i class="fas fa-car-side icon-input"></i>
                            <select id="form_0_vehiculos_implicados" name="form_0_vehiculos_implicados" required="">
                                <option value="1">SI</option>
                                <option value="2">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12"></div>
                    <div class="col-3 col-12-small">
                        <label class="label-datos"> Empresa</label>
                    </div>
                    <div class="col-9 col-12-small">
                        <label class="label-resultados" id="form_0_empresa_div"> </label>
                    </div>
                    <div class="col-3 col-12-small">
                        <label class="label-datos"> Descripción <b>(250) Caracteres</b></label>
                    </div>
                    <div class="col-9 col-12-small align-right">
                        <textarea id="form_0_descripcion" name="form_0_descripcion" rows="2" maxlength="220"></textarea>
                    </div>

                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <fieldset>
                <legend><i class="fas fa-plus"></i> Fotografía(s) siniestro</legend>
                <div class="row gtr-25 gtr-uniform">

                    <div class="col-3 col-12-mobilep align-center">
                        <span class="image fit">
                            <a href="/images/sin_imagen.png" id="form_0_foto_1_href" class="siniestro-images-link">
                                <img src="/images/sin_imagen.png">
                            </a>
                        </span>
                        <label>Foto # 1</label>
                    </div>
                    <div class="col-3 col-12-mobilep align-center">
                        <span class="image fit">
                            <a href="/images/sin_imagen.png" id="form_0_foto_2_href" class="siniestro-images-link">
                                <img src="/images/sin_imagen.png">
                            </a>
                        </span>
                        <label>Foto # 2</label>
                    </div>

                    <div class="col-3 col-12-mobilep align-center">
                        <span class="image fit">
                            <a href="/images/sin_imagen.png" id="form_0_foto_3_href" class="siniestro-images-link">
                                <img src="/images/sin_imagen.png">
                            </a>
                        </span>
                        <label>Foto # 3</label>
                    </div>

                    <div class="col-3 col-12-mobilep align-center">
                        <span class="image fit">
                            <a href="/images/sin_imagen.png" id="form_0_foto_4_href" class="siniestro-images-link">
                                <img src="/images/sin_imagen.png">
                            </a>
                        </span>
                        <label>Foto # 4</label>
                    </div>



                    <!-- foto 1 -->
                    <div class="col-6 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label> Foto # 1 </label>
                                <input type="text" id="form_0_foto_1" name="form_0_foto_1"
                                    value="/images/sin_imagen.png" readonly="" required="">
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open" id="btn-form_0_foto_1"
                                    data-folder="siniestro/foto" input-id="form_0_foto_1"></button>
                                <button class="button primary small btn-camera-open" id="btn-form_0_foto_1"
                                    data-folder="siniestro/foto" input-id="form_0_foto_1"></button>
                                <button class="button primary small btn-camera-show" data-id="form_0_foto_1"></button>
                            </div>
                        </div>
                    </div>
                    <!-- foto 2 -->
                    <div class="col-6 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label> Foto # 2 </label>
                                <input type="text" id="form_0_foto_2" name="form_0_foto_2"
                                    value="/images/sin_imagen.png" readonly="" required="">
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open" id="btn-form_0_foto_2"
                                    data-folder="siniestro/foto" input-id="form_0_foto_2"></button>
                                <button class="button primary small btn-camera-open" id="btn-form_0_foto_2"
                                    data-folder="siniestro/foto" input-id="form_0_foto_2"></button>
                                <button class="button primary small btn-camera-show" data-id="form_0_foto_2"></button>
                            </div>
                        </div>
                    </div>
                    <!-- foto 3 -->
                    <div class="col-6 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label> Foto # 3 </label>
                                <input type="text" id="form_0_foto_3" name="form_0_foto_3"
                                    value="/images/sin_imagen.png" readonly="" required="">
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open" id="btn-form_0_foto_3"
                                    data-folder="siniestro/foto" input-id="form_0_foto_3"></button>
                                <button class="button primary small btn-camera-open" id="btn-form_0_foto_3"
                                    data-folder="siniestro/foto" input-id="form_0_foto_3"></button>
                                <button class="button primary small btn-camera-show" data-id="form_0_foto_3"></button>
                            </div>
                        </div>
                    </div>
                    <!-- foto 4 -->
                    <div class="col-6 col-12-small">
                        <div class="photo-control">
                            <div class="photo-info">
                                <label> Foto # 4 </label>
                                <input type="text" id="form_0_foto_4" name="form_0_foto_4"
                                    value="/images/sin_imagen.png" readonly="" required="">
                            </div>
                            <div class="photo-buttons">
                                <button class="button primary small btn-file-open" id="btn-form_0_foto_4"
                                    data-folder="siniestro/foto" input-id="form_0_foto_4"></button>
                                <button class="button primary small btn-camera-open" id="btn-form_0_foto_4"
                                    data-folder="siniestro/foto" input-id="form_0_foto_4"></button>
                                <button class="button primary small btn-camera-show" data-id="form_0_foto_4"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <fieldset>
                <legend><i class="fas fa-file-signature"></i> Firma Del Usuario</legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-3 col-12-small"></div>
                    <div class="col-6 col-12-small">
                        <div class="canvas-container" id="canvas_firma_usuario"></div>
                    </div>
                    <div class="col-3 col-12-small"></div>
                </div>
            </fieldset>
        </div>
        <div class="col-12">
            <hr class="hr-text" data-content="OPCIONES DEL FORMULARIO">
        </div>
        <div class="col-6 col-12-mobilep">
            <input type="submit" value="guardar" class="primary small fit">
        </div>
        <div class="col-6 col-12-mobilep">
            <button type="reset" id="form_0_limpiar_formulario" class="button primary small fit btn-limpiar-formulario"
                disabled>
                CANCELAR</button>
        </div>
    </div>
</form>