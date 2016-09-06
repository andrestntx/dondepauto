{!! Form::open(['route' => ['medios.agreement.complete.upload', $publisher], 'files' => 'true', 'id' => 'form-files']) !!}
    <div class="row">
        <div class="col-md-12 file-content">
            <div class="col-sm-6">
                <p><strong>Cámara de Comercio:</strong> Para verificar la existencia y capacidad legal para la venta de espacios publicitarios.</p>
            </div>
            <div class="col-sm-6 js">
                {!! Form::file('commerce', ['class' => 'inputfile', 'id' => 'commerce', 'accept' => "application/pdf"]) !!}
                <label for="commerce">
                    <figure><img src="/assets/img/agreement/iconopdf.png"></figure>
                    <div class="label-text">
                        <span class="upload-label">Cárama de comercio</span> 
                        <span class="upload-pdf">Subir PDF</span>
                        <span class="upload-text">(Expedición no mayor a 60 días)</span>  
                    </div>
                    <div class="label-check">
                        <i class="fa fa-check"></i>
                    </div>
                </label>
                @if($publisher->hasDocument('commerce.pdf'))
                    <div class="col-xs-12">
                        <a href="/{{ $publisher->getDocument('commerce') }}" target="_blank" style="width: auto; margin-left: 12%; font-size: 1.15em;">camara_de_comercio.pdf</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 file-content">
            <div class="col-sm-6">
                <p><strong>RUT:</strong> Para verificar la actividad económica, forma de facturación y retenciones aplicablespor su actividad económica.</p>
            </div>
            <div class="col-sm-6 js">
                {!! Form::file('rut', ['class' => 'inputfile', 'id' => 'rut', 'accept' => "application/pdf"]) !!}
                <label for="rut">
                    <figure><img src="/assets/img/agreement/iconopdf.png"></figure>
                    <div class="label-text">
                        <span class="upload-label">RUT</span> 
                        <span class="upload-pdf">Subir PDF</span>
                    </div>
                    <div class="label-check">
                        <i class="fa fa-check"></i>
                    </div>
                </label>
                @if($publisher->hasDocument('rut.pdf'))
                    <div class="col-xs-12">
                        <a href="/{{ $publisher->getDocument('rut') }}" target="_blank" style="width: auto; margin-left: 12%; font-size: 1.15em;">rut.pdf</a>
                    </div>
                @endif
            </div>
            
        </div>
        <div class="col-md-12 file-content">
            <div class="col-sm-6">
                <p><strong>Certificación Bancaria:</strong> Para registrar en nuestro sistema la cuenta bancaria a donde se harán las transferencias al medio publicitario.</p>
            </div>
            <div class="col-sm-6 js">
                {!! Form::file('bank', ['class' => 'inputfile', 'id' => 'bank', 'accept' => "application/pdf"]) !!}
                <label for="bank">
                    <figure><img src="/assets/img/agreement/iconopdf.png"></figure>
                    <div class="label-text">
                        <span class="upload-label">Certificación Bancaria</span> 
                        <span class="upload-pdf">Subir PDF</span>
                    </div>
                    <div class="label-check">
                        <i class="fa fa-check"></i>
                    </div>
                </label>
                @if($publisher->hasDocument('bank.pdf'))
                    <div class="col-xs-12">
                        <a href="/{{ $publisher->getDocument('bank') }}" target="_blank" style="width: auto; margin-left: 12%; font-size: 1.15em;">certificacion_bancaria.pdf</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-12 file-content">
            <div class="col-sm-6">
                <p><strong>Carta de Aceptación e Incentivos del Representante Legal:</strong> Para validar que se aceptan los términos y condiciones de la Plataforma y se formaliza el incentivo de comisión para DóndePauto,</p>
            </div>
            <div class="col-sm-6 js">
                {!! Form::file('letter', ['class' => 'inputfile', 'id' => 'letter', 'accept' => "application/pdf"]) !!}
                <label for="letter">
                    <figure><img src="/assets/img/agreement/iconopdf.png"></figure>
                    <div class="label-text">
                        <span class="upload-label">Carta de Representante Legal</span> 
                        <span class="upload-pdf">Subir PDF</span>
                    </div>
                    <div class="label-check">
                        <i class="fa fa-check"></i>
                    </div>
                </label>
                @if($publisher->hasDocument('letter.pdf'))
                    <div class="col-xs-12">
                        <a href="/{{ $publisher->getDocument('letter') }}" target="_blank" style="width: auto; margin-left: 12%; font-size: 1.15em;">carta_representante_legal.pdf</a>
                    </div>
                @endif
            </div>
        </div>

        @if(auth()->user()->isPublisher())
            <div class="col-md-12" style="padding-left: 35px; padding-top: 10px;">
                <div class="checkbox m-r-xs">
                    {!! Form::checkbox('signed_agreement', 1, 0, ['id' => 'signed_agreement']) !!}
                    <label for="signed_agreement">
                        Acepto 
                    </label>
                    <span style="font-size: 1.15em; font-weight: 600;">los <a href="#" style="color: #2cbaf8;">términos y condiciones</a> del acuerdo servicio</span>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <p class="intro-form last-intro">¡Una vez suministrada la información requerida, se validarán las ofertas del Medio Publicitario y DóndePauto activará la promoción y presentación de las ofertas a potenciales clientes Anunciantes!</p>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-warning btn-effect-ripple btn-lg">REGISTRAR DOCUMENTOS</button>
            </div>
        </div>
    </div>
{!! Form::close() !!}