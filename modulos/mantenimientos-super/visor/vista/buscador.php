<form id="form_0_buscador" name="form_0_buscador">
    <div class="row gtr-25 gtr-uniform">
        <div class="col-6 col-12-small"> </div>
        <div class="col-6 col-12-small ">
            <aside class="note-wrap note-yellow">
                El buscador tiene la capacidad para mostrar <br><b>255</b> (<i>Doscientos cincuenta y cinco</i>)
                resultados de manera rápida</b> <br>
                Mas de 255 resultados, <b>consumirá mas recursos de su computadora</b>.
            </aside>
        </div>
        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="fas fa-search"></i> Buscador de Mantenimientos
                </legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-3 col-12-small">
                        <label> Buscar por </label>
                        <div class="input-container">
                            <i class="fas fa-list icon-input"></i>
                            <select id="form_0_filtro" name="form_0_filtro" required>
                                <option value="0" selected>Todo</option>
                                <option value="1">ID</option>
                                <optgroup label="Vehículo">
                                    <option value="2">ID</option>
                                    <option value="3">Placa</option>
                                    <option value="4">Numero de licencia de transito</option>
                                    <option value="5">Modelo</option>
                                    <option value="6">VIN</option>
                                    <option value="7">MOTOR</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-12-small">
                        <label> Contenido </label>
                        <div class="input-container">
                            <i class="fas fa-align-left icon-input"></i>
                            <input type="text" name="form_0_contenido" id="form_0_contenido" placeholder="Contenido a buscar" value="Todo" autocomplete="off" required />
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label> Empresa <b class="list-key"></b></label>
                        <div class="input-container">
                            <i class="fas fa-industry icon-input"></i>
                            <input type="text" id="form_0_empresa_input" value="TODO" placeholder="Empresa" class="text-uppercase autocomplete" required="" />
                            <input type="hidden" name="form_0_empresa" id="form_0_empresa_select" value="0" data-default="0" required="" />
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label> Tipo Mantenimiento </label>
                        <div class="input-container">
                            <i class="fas fa-list icon-input"></i>
                            <select id="form_0_tipo_mantenimiento" name="form_0_tipo_mantenimiento" required>
                                <option value="0" selected>Todo</option>
                                <option value="2">PREVENTIVO</option>
                                <option value="3">CORRECTIVO</option>
                                <option value="4">PREDICTIVO</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-3 col-12-small align-center">
                        <label>¿Filtrar por rango de fechas?</label>
                        <input type="radio" id="form_0_filtrar_si" name="filtrar_fecha" value="1">
                        <label for="form_0_filtrar_si"> Si</label>
                        <input type="radio" id="form_0_filtrar_no" name="filtrar_fecha" value="2" checked="">
                        <label for="form_0_filtrar_no"> No</label>
                    </div>
                    <div class="col-3 col-12-small">
                        <label> Fecha inicial</label>
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="fecha_inicial" id="form_0_fecha_inicial" class="input_date_listener" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label> Fecha final</label>
                        <div class="input-container">
                            <i class="fas fa-calendar icon-input"></i>
                            <input type="text" name="fecha_final" id="form_0_fecha_final" class="input_date_listener" autocomplete="off" required="">
                        </div>
                    </div>
                    <div class="col-3 col-12-small">
                        <label>Resultados</label>
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-down-alt icon-input"></i>
                            <select id="form_0_resultados" name="form_0_resultados" required>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="255">255</option>
                                <option value="0">Todo </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-9 col-12-small">
                        <input type="hidden" name="form_0_page" id="form_0_page" value="1">
                        <input type="hidden" name="form_0_order" id="form_0_order" value="nro">
                        <input type="hidden" name="form_0_by" id="form_0_by" value="desc">
                        <label> Buscar </label>
                        <input type="submit" value="BUSCAR MANTENIMIENTO" class="primary small fit">
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</form>
<br />
<div id="buscador_resultados_title" class="div-resultado-title" hidden> </div>
<div id="buscador_resultados_body" class="div-resultado-body" hidden></div>
<div id="buscador_resultados_pagination" class="div-resultado-pagination"></div>