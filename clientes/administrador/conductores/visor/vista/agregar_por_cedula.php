<form id="form_buscar_cedula" name="form_buscar_cedula">
    <div class="row gtr-50 gtr-uniform">
        <div class="col-7 col-12-small"> </div>
        <div class="col-5 col-12-small">
            <aside class="note-wrap note-yellow ">
                Escriba la <b>CEDULA y EMPRESA</b> DEL CONDUCTOR, en caso de que no exista se crea, de lo contrario solo
                se puede
                editar
                los datos. <br><b> P.D. </b>Solo soporte técnico puede <b>ELIMINAR CONDUCTORES</b>
            </aside>
        </div>
        <div class="col-12">
            <fieldset>
                <legend>
                    <i class="fas fa-search"></i> Verificar placa
                </legend>
                <div class="row gtr-25 gtr-uniform">
                    <div class="col-6 col-12-small">
                        <label class="label-important"> CEDULA </label>
                        <div class="input-container">
                            <i class="fas fa-align-left icon-input"></i>
                            <input type="text" id="form_1_cedula" placeholder="Cedula" name="form_1_cedula"
                                class="text-uppercase" value="" maxlength="20" required="" autocomplete="off">
                        </div>
                    </div>
                    <!-- <div class="col-5 col-12-small">
                        <label class="label-important"> Empresa <b class="list-key"></b></label>
                        <div class="input-container">
                            <i class="fas fa-industry icon-input"></i>
                            <input type="text" id="form_1_empresa_input" value="" placeholder="Empresa"
                                class="text-uppercase" required="" autocomplete="off">
                            <input type="hidden" name="form_1_empresa" id="form_1_empresa_select" value="1"
                                data-default="1" required="">
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