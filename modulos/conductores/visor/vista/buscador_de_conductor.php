<form id="form_0_buscador" name="form_0_buscador">
    <div class="row gtr-25 gtr-uniform">
        <div class="col-6 col-12-small"> </div>
        <div class="col-6 col-12-small">
            <aside class="note-wrap note-yellow">
                El buscador tiene la capacidad para mostrar <br><b>255</b> (<i>Doscientos cincuenta y cinco</i>)
                resultados de manera <b>rápida</b> <br>
                Mas de 255 resultados, <b>consumirá mas recursos de su computadora</b>.
            </aside>
        </div>
        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="fas fa-search"></i> Buscador de Conductores
                </legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-3 col-12-small">
                        <label> Buscar por </label>
                        <div class="input-container">
                            <i class="fas fa-list icon-input"></i>
                            <select id="form_0_filtro" name="form_0_filtro" required>
                                <option value="0" selected>Todo</option>
                                <option value="1">ID</option>
                                <optgroup label="Conductor">                                    
                                    <option value="2">Numero de documento</option>
                                    <option value="3">Nombre</option>
                                    <option value="4">Apellido</option>
                                    <option value="5">Correo</option>
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
                            <input type="text" id="form_0_empresa_input" value="TODO" placeholder="Empresa" class="text-uppercase autocomplete ui-autocomplete-input" required="" autocomplete="off">
                            <input type="hidden" name="form_0_empresa" id="form_0_empresa_select" value="0" data-default="0" required="">
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
                                <option value="0">Todo (No recomendado)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-9 col-12-small">
                        <label>Buscar</label>
                        <input type="hidden" name="form_0_page" id="form_0_page" value="1">
                        <input type="hidden" name="form_0_order" id="form_0_order" value="nro">
                        <input type="hidden" name="form_0_by" id="form_0_by" value="desc">
                        <input type="submit" value="BUSCAR CONDUCTORES" class="primary small fit">
                    </div>
                </div>
            </fieldset>
        </div>

    </div>
</form>
<br><br>
<div id="buscador_resultados_title" class="div-resultado-title"></div>
<div id="buscador_resultados_body" class="div-resultado-body"></div>
<div id="buscador_resultados_pagination" class="div-resultado-pagination"></div>
<div id="div_container_info_basica" class="div-container-info-basica"></div>