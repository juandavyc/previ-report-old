<form id="form_1_buscar_placa" name="form_1_buscar_placa">
    <div class="row gtr-50 gtr-uniform">
        <div class="col-6 col-12-small"> </div>
        <div class="col-6 col-12-small">
            <aside class="note-wrap note-yellow">
                Escriba la <b>PLACA y EMPRESA</b>, en caso de que no exista se crea, <br>
                de lo contrario solo se puede editar los datos.
                <br><b> P.D. </b>Solo soporte técnico puede <b>ELIMINAR VEHÍCULOS</b>
            </aside>
        </div>

        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="fas fa-search"></i> Verificar placa
                </legend>
                <div class="row gtr-25 gtr-uniform">

                    <div class="col-6 col-12-small">
                        <label class="label-important"> Placa </label>
                        <div class="input-container">
                            <i class="fas fa-align-left icon-input"></i>
                            <input type="text" id="form_1_placa" placeholder="ABC123" name="form_1_placa" maxlength="6" class="text-uppercase" value="" required="" autocomplete="off">
                        </div>
                    </div>

                    <!-- <div class="col-5 col-12-small">
                        <label class="label-important"> Empresa <b class="list-key"></b></label>
                        <div class="input-container">
                            <i class="fas fa-industry icon-input"></i>
                            <input type="text" id="form_1_empresa_input" value="" placeholder="Empresa" class="text-uppercase autocomplete ui-autocomplete-input" required="" autocomplete="off">
                            <input type="hidden" name="form_1_empresa" id="form_1_empresa_select" value="1" data-default="1" required="">
                        </div>
                    </div> -->
                    <div class="col-4 col-12-small">
                        <label> Verificar </label>
                        <input type="submit" value="Verificar" class="primary small fit">

                    </div>
                    <div class="col-2 col-12-small">
                        <label> Cancelar </label>
                        <button type="reset" class="button primary small fit btn-limpiar-formulario">
                            Cancelar
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</form>
<br>
<div class="row gtr-50 gtr-uniform" id="agregar_resultados_body"></div>