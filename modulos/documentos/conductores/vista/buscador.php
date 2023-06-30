<form id="buscador">
    <div class="row gtr-50 gtr-uniform">
        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="fas fa-search"></i> Buscador de Documentos
                </legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-3 col-12-small">
                        <label> Empresa <b class="list-key"></b></label>
                        <div class="input-container">
                            <i class="fas fa-industry icon-input"></i>
                            <input type="text" id="empresa_input" value="TODO" placeholder="Empresa" class="text-uppercase autocomplete" required="" />
                            <input type="hidden" name="empresa" id="empresa_select" value="0" data-default="0" required="" />
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label> Buscar por </label>
                        <div class="input-container">
                            <i class="fas fa-list icon-input"></i>
                            <select id="filtro" name="filtro" required>
                                <option value="0" selected>Todo</option>
                                <option value="1">ID</option>
                                 <optgroup label="Empresa">
                                    <option value="2">ID</option>
                                    <option value="3">NIT</option>
                                </optgroup>
                                <optgroup label="Vehiculo">
                                    <option value="4">ID</option>
                                    <option value="5">Placa</option>
                                    <option value="6">Numero de licencia de transito</option>
                                    <option value="7">Modelo</option>
                                    <option value="8">VIN</option>
                                    <option value="9">MOTOR</option>
                                </optgroup>
                                <optgroup label="Conductor">
                                    <option value="10">ID</option>
                                    <option value="11">Numero de documento</option>
                                    <option value="12">Nombre</option>
                                    <option value="13">Apellido</option>
                                    <option value="14">Correo</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-12-small">
                        <label> Contenido </label>
                        <div class="input-container">
                            <i class="fas fa-align-left icon-input"></i>
                            <input type="text" name="contenido" id="contenido" placeholder="Contenido a buscar" value="Todo" autocomplete="off" required />
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="align-center">¿Obtener resultados para?</label>
                        <div class="row gtr-25 gtr-uniform">
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-arl" name="documento[]" value="arl" checked>
                                <label for="documento-arl">ARL</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-capacitaciones" name="documento[]" value="capacitaciones">
                                <label for="documento-capacitaciones">Capacitaciones</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-comparendos_multas_anciones" name="documento[]" value="comparendos_multas_anciones">
                                <label for="documento-comparendos_multas_anciones">Multas ó sanciones</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-contacto_emergencia" name="documento[]" value="contacto_emergencia">
                                <label for="documento-contacto_emergencia">Contacto de emergencia</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-contratos" name="documento[]" value="contratos">
                                <label for="documento-contratos">contratos</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-cursos" name="documento[]" value="cursos">
                                <label for="documento-cursos">cursos</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-eps" name="documento[]" value="eps">
                                <label for="documento-eps">EPS</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-examenes_ocupacionales" name="documento[]" value="examenes_ocupacionales">
                                <label for="documento-examenes_ocupacionales">examenes ocupacionales</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-fondo_pension" name="documento[]" value="fondo_pension">
                                <label for="documento-fondo_pension">Fondo de pension</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-incapacidades" name="documento[]" value="incapacidades">
                                <label for="documento-incapacidades">Incapacidades</label>
                            </div>
                            <div class="col-4 col-12-small">
                                <input type="checkbox" id="documento-licencia_conduccion" name="documento[]" value="licencia_conduccion">
                                <label for="documento-licencia_conduccion">Licencia de conduccion</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 col-12-small align-center">
                        <label>¿Filtrar por rango de fechas?</label>
                        <input type="radio" id="filtrar_si" name="filtrar_fecha" value="1">
                        <label for="filtrar_si"> Si</label>
                        <input type="radio" id="filtrar_no" name="filtrar_fecha" value="2" checked>
                        <label for="filtrar_no"> No</label>
                    </div>
                    <div class="col-3 col-12-small">
                        <label> Fecha inicial</label>
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="fecha_inicial" id="fecha_inicial" class="input_date_listener" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label> Fecha final</label>
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="fecha_final" id="fecha_final" class="input_date_listener" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label>Buscar</label>
                        <input type="submit" value="BUSCAR" class="primary small fit">
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</form>