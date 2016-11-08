<div class="modal fade" id="spaceDiscountModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog list-space">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-8">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            <strong>Aplicar Descuento</strong>
                            <div style="display: inline-block; vertical-align: middle;">
                                <div class="sk-spinner sk-spinner-circle" id="sk-spinner-modal" style="display: none;">
                                    <div class="sk-circle1 sk-circle"></div>
                                    <div class="sk-circle2 sk-circle"></div>
                                    <div class="sk-circle3 sk-circle"></div>
                                    <div class="sk-circle4 sk-circle"></div>
                                    <div class="sk-circle5 sk-circle"></div>
                                    <div class="sk-circle6 sk-circle"></div>
                                    <div class="sk-circle7 sk-circle"></div>
                                    <div class="sk-circle8 sk-circle"></div>
                                    <div class="sk-circle9 sk-circle"></div>
                                    <div class="sk-circle10 sk-circle"></div>
                                    <div class="sk-circle11 sk-circle"></div>
                                    <div class="sk-circle12 sk-circle"></div>
                                </div>  
                            </div>
                        </h2>
                    </div>
                    <div class="col-xs-4 timeline" id="prueba">

                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 space_form_discount">
                        {!! Form::open() !!}
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-xs-4">
                                    <p>.</p>
                                    <p>Precio Cliente</p>
                                    <p>Descuento</p>
                                    <p>Precio Proveedor</p>
                                    <p>Comisión</p>
                                    <p>Markup DP</p>
                                    <p>Markup Medio</p>
                                    <p><strong>Ingreso DóndePauto</strong></p>
                                </div>
                                <div class="col-xs-4 values" id="old-values">
                                    <p> <strong>Inicial</strong> </p>
                                    <p id="discount_public_price"></p>
                                    <p id="discount_val"></p>
                                    <p id="discount_minimal_price"></p>
                                    <p id="discount_commission"></p>
                                    <p id="discount_markup_company"></p>
                                    <p id="discount_markup_publisher"></p>
                                    <p id="discount_income"></p>
                                </div>
                                <div class="col-xs-4 values" id="new-values">
                                    <p> <strong>Actual</strong> </p>
                                    <p id="discount_public_price" class="text-info" style="font-weight: bold;"></p>
                                    <p id="discount_val"></p>
                                    <p id="discount_minimal_price"></p>
                                    <p id="discount_commission"></p>
                                    <p id="discount_markup_company"></p>
                                    <p id="discount_markup_publisher"></p>
                                    <p id="discount_income" style="font-weight: bold;"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    {!! Field::number('discount', 0, ['label' => 'Descuento', 'required']) !!}    
                                    <p id="discount_error" class="help-block text-danger"></p>  
                                </div>  
                                <div class="col-sm-6">
                                    {!! Field::select('markup', ['1' => 'Para DóndePauto', '0' => 'Para el medio'], 1, ['label' => 'Markup', 'required']) !!}  
                                </div>  
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success form-button-data" id="formDiscountSpaceModal" title="Aplicar descuento" data-url="/"> Guardar</button>
            </div>
        </div>
    </div>
</div>
