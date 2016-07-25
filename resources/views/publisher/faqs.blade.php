@extends('layouts.publisher')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/assets/css/publisher/dashboard.css" />
@endsection

@section('content')
    <div class="dashboard">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h1>Preguntas frecuentes de medios publicitarios</h1>
                    </div>
                </div>  
            </div>          
        </div>

        <div class="col-xs-12 sub-title sub-title-lg">
            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq1" class="faq-question">¿En qué consiste el servicio de DóndePauto?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq1" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>DóndePauto es la <strong>primera agencia</strong> que a través de la Nube, el Big data, herramientas de planeación de
                                medios y el acompañamiento personalizado, ayuda a empresas anunciantes encontrar y comprar los
                                espacios de pauta más adecuados para sus estrategias de comunicación.</p>

                                <p>Para facilitar el proceso, DóndePauto pone a disposición de Medios Publicitarios una plataforma
                                especializada para la integración, presentación y promoción de sus ofertas de medios, con el objeto de
                                obtener negocios efectivos (ventas) con los anunciantes que acceden al servicio DóndePauto.</p>

                                <p><strong>DóndePauto captura y asesora clientes propios y No gestiona negocios o compras para otras
                                agencias centrales y/o sus clientes.</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq2" class="faq-question">Beneficios para un Medio Publicitario que integra sus ofertas</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq2" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <ol>
                                    <li>Presentamos tus espacios publicitarios a un mercado no cautivo de empresas que invierten en
                                    medios de manera recurrente, y que no trabajan con agencias tradicionales.</li>

                                    <li>Promocionamos tus espacios publicitarios a través de una plataforma especializada, en formato
                                    de alto impacto visual, con mayor alcance y accesible desde la nube por nuestros anunciantes.</li>

                                    <li>Recomendamos tus espacios publicitarios si se adecuan a necesidades puntuales de nuestros
                                    anunciantes, acompañando las decisiones de compra y la gestión del pago por tus servicios
                                    publicitarios.</li>

                                    <li>La información de tus ofertas, entre más precisa y atractiva, te aportará valor en la generación
                                    de prospectos de anunciantes interesados y motivará las decisiones de compra.</li>

                                    <li>Diversificamos tus fuentes de ingresos. Acordamos un incentivo por negocios efectivos logrados
                                    a través de DóndePauto.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq3" class="faq-question">¿Cómo capturamos clientes anunciantes?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq3" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>
                                    DóndePauto atrae clientes través de estrategias de marketing online, tácticas de nutrimiento de leads, pauta segmentada y fuerza comercial personalizada.
                                </p>
                                <p>
                                    Nuestra plataforma incorpora herramientas de data mining y media planning para ayudar a los anunciantes en la selección y compra de los productos publicitarios más adecuados. Además brindamos asesoría personalizada en las decisiones de compra y apoyo en la compra de medios.
                                </p>           
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq4" class="faq-question">Por qué validamos los Medios Publicitarios que presentamos a los anunciantes?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq4" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>DóndePauto busca generar confianza entre las marcas anunciantes que compran a través de su
                                plataforma de servicio. Para esto verificamos:</p>

                                <ul>
                                    <li>Que los Medios Publicitarios tienen capacidad legal para comercializar sus espacios de
                                        pauta en Colombia.
                                    </li>
                                    <li>Que las personas que se registran a nombre de un Medio Publicitario se encuentran
                                        autorizados por dicho medio publicitario para formular ofertas a través de DóndePauto.
                                    </li>
                                    <li>Que la cuenta bancaria a donde se transferirán los pagos se encuentra activa y suscrita a
                                        nombre del Medio Publicitario.
                                    </li>
                                    <li>Que se aceptan los términos y condiciones referentes a formas de pagos al Medio y el
                                        incentivo de comisión para DóndePauto, entre otros. <strong>Carta de Aceptación del
                                        Representante Legal.</strong>
                                    </li>
                                </ul>

                                <p>DóndePauto inactiva las cuentas y ofertas que no cuenten con las validaciones descritas, o cuando no pueda verificar la información que el Medio Publicitario haya registrado.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq5" class="faq-question">¿Qué documentación se require para validar el Medio Publicitario?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq5" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>Para validar la existencia y representación de Medios Publicitarios que presentamos a nuestros clientes anunciantes, se solicita la siguiente documentación:</p>
                                <ul>
                                    <li><strong>Cámara de Comercio.</strong> Para verificar la existencia y capacidad legal para la venta de espacios publicitarios.</li>

                                    <li><strong>RUT.</strong> Para verificar la actividad económica, forma de facturación y retenciones aplicables por su actividad económica.</li>

                                    <li><strong>Certificación Bancaria.</strong> Para registrar en nuestro sistema la cuenta bancaria a donde se harán las transferencias al medio publicitario.</li>

                                    <li><strong>Carta de Aceptación e Incentivos del Representante Legal.</strong> Para validar que se aceptan los términos y condiciones de la Plataforma, se formaliza el incentivo de comisión para DóndePauto, y confirmar el registro del funcionario que administrará y formulará las ofertas del Medio Publicitario.</li>
                                </ul>

                                <p>Una vez suministrada la información requerida, se valida la relación comercial y DóndePauto activará la promoción y presentación de las ofertas a potenciales clientes Anunciantes!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq6" class="faq-question">¿El servicio DóndePauto tiene algún costo para los Medios Publicitarios?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq6" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>Nuestro objetivo es lograr negocios efectivos para nuestros anunciantes y medios publicitarios.
                                El Medio Publicitario acuerda pagar un <strong>incentivo económico</strong> sobre la inversión en publicidad que
                                reciba por ventas a través de DóndePauto, y que hayan sido efectivamente facturadas y cobradas por el
                                Medio Publicitario.</p>

                                <p><strong>Este valor corresponderá a un porcentaje de comisión (%), más IVA,</strong> y es establecido en <strong>carta de Aceptación</strong> que firma el Representante Legal del Medio Publicitario al inicio de la relación con
                                DóndePauto, y se podrá negociar y ajustar en cualquier momento.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq7" class="faq-question">¿Cúando y cómo aplica la comisión para DóndePauto?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq7" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>El incentivo económico aplica por la inversión en publicidad que reciba el medio publicitario por las <strong>ventas con marcas anunciantes que referencie DóndePauto,</strong> bajo cualquiera de los siguientes escenarios de facturación:</p>
                                <ul>
                                    <li>Si el Medio Publicitario <strong>factura directamente al Anunciante;</strong> o</li>
                                    <li>Si el Medio Publicitario <strong>factura a DóndePauto</strong> cuando DóndePauto intermedie como agente, representante o canal de pago para sus usuarios o clientes marcas anunciantes.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq8" class="faq-question">¿Cómo funciona la facturación? ¿Quién paga a quien?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq8" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>Si DóndePauto actúa como intermediario y facilitador del pago del cliente Anunciante, el Medio
                                Publicitario emitirá la factura a nombre de DóndePauto quien será el responsable directo y único del
                                pago al Medio Publicitario.</p>

                                <p>Cuando el Medio Publicitario acuerde facturar directamente al anunciante referenciado por DóndePauto, estos acordarán el plazo y la forma de pago. El Anunciante será el responsable directo y único del pago al Medio Publicitario. <span style="font-style: italic;">
                                    En el caso que el anunciante incumpla el pago por los servicios aplicables DóndePauto no será responsable del pago, ni codeudor. Tampoco se computará el incentivo de comisión para DóndePauto.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq9" class="faq-question">¿DóndePauto puede garantizar un monto mínimo de inversión a mi Medio Publicitario?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq9" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>DóndePauto no esta obligado a cumplir o asegurar un número o monto mínimo de compras a los Medios Publicitarios listados en la plataforma, toda vez que el servicio DóndePauto no crea ningún contrato de sociedad, de mandato, de franquicia, de relación laboral con el Medio Publicitario, y no implica exclusividad de ninguna de las partes.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq10" class="faq-question">¿DóndePauto da prioridad a ofertas de algunos Medios sobre las de otros Medios?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq10" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>DóndePauto presenta y promociona los servicios y productos de diferentes medios publicitarios del
                                mercado colombiano, y no da prioridad a ningún Medio Publicitario sobre otros, o viceversa.</p>

                                <p>Al asesorar a sus clientes Anunciantes DóndePauto recomienda de conformidad única y exclusivamente con las necesidades del anunciante, y no tiene ningún orden de prelación entre los medios listados en la plataforma.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq11" class="faq-question">¿Quién es responsable de publicar los espacios publicitarios en la Plataforma web?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq11" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>La publicación de Ofertas de Espacios Publicitarios <strong>debe ser realizada y gestionada por el mismo Medio Publicitario</strong> a través de las funcionalidades de la Plataforma, toda vez que el Medio Publicitario es quien conoce y establece las condiciones, características, formatos, precios, alcance y posibles paquetes o combinaciones que puede ofrecer a marcas anunciantes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq13" class="faq-question">¿Cómo se ofertan los Espacios Publicitarios en DóndePauto?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq13" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>Accediendo a la cuenta de usuario del Medio Publicitario en la plataforma DóndePauto, se encuentran las diferentes opciones para crear y publicar ofertas de tus espacios publicitarios. Una vez publicada una Oferta, el MEDIO podrá modificar, adicionar o suprimir la información contenida en ella.</p>

                                <p>El Medio Publicitario podrá publicar cualquier número de ofertas de Espacios Publicitarios. Cada oferta podrá representar <strong>un espacio publicitario específico</strong> o un <strong>paquete de espacios publicitarios</strong> con características similares. La Plataforma también permite crear diferentes <strong>ofertas</strong> de un mismo producto o servicio, con diferentes precios o periodos de venta, diferentes frecuencias o circuitos, o cantidades distintas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="row">
                    <div class="col-md-12">
                        <a data-toggle="collapse" href="#faq14" class="faq-question">¿Qué significa una “Oferta de Espacio Publicitario” en DóndePauto?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="faq14" class="panel-collapse collapse ">
                            <div class="faq-answer">
                                <p>La plataforma permite publicar <strong>Ofertas de Referencia</strong>, es decir las condiciones básicas de espacios
                                publicitarios posibles para la venta. En este sentido, <strong>se podrá ajustar, editar o modificar las condiciones de la Oferta de Referencia</strong> según necesidades específicas de cada cliente y según se
                                acuerde con el Medio.</p>

                                <p>Al capturar el interés de compra de un Anunciante por las ofertas del Medio Publicitario, DóndePauto se pondrá en contacto con el Medio Publicitario con el fin de ultimar detalles, verificar disponibilidades o restricciones y gestionar la compra del espacio publicitario en nombre del Anunciante.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
   
@endsection

@section('extra-js')
    <script>
        
    </script>
@endsection