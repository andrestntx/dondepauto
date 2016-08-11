$(".pieProgress").asPieProgress({
    namespace: 'pieProgress',
    barsize: 18,
    barcolor: "#01aeef",
    min: 0,
    max: 100,
    goal: 0,
    step: 1,
    speed: 50, // refresh speed
    delay: 300,
    easing: 'ease',
    label: function(n) {
        return n;
    },
    numberCallback: function(n){
        if(n >= 1){
            return parseInt(n);
        }
        
        return 0;
    }
});


$(document).ready(function(){

    var initValue = $("#points").data('totalpoints');
    var progresActive = false;
    var actualValue = 0;
    var sumValue    = 0;

    var myDropzone = null;


    function updatePrices() {
        var period      = $("#period").val();

        if(period.length == 0) {
            period = 'periodo';
        }

        var discount    = $("input#discount").val();
        var price       = parseInt($("input#price").val());
        $("input[name='minimal_price']").val(price);

        if(discount.length > 0 && price > 0) {
            discount = parseInt(discount);
            $("#with_discount").show();
            $("#max_discount span").text(discount);

            $("#minimal_price a").attr('data-content', 'Es el Valor mínimo que el Medio acepta recibir por la venta de este espacio publicitario a través de DóndePauto.   Este valor debe cubrir el pago de comisión a DóndePauto');

            if(discount > 0) {
                $("input[name='public_price']").val(price);
                $("input[name='margin']").val(0);

                if(discount <= 15) {
                    var html =  'Este descuento NO será visible desde la Plataforma y solo se negociará en privado con cada el cliente interesado. <br>Un <strong>buen descuento</strong> permite presentar propuestas con <strong>tarifas finales más competitivas</strong> frente a otros medios y obtener mayores posibilidades de ventas.';
                }
                else {
                    var html =  'Este descuento NO será visible desde la Plataforma y solo se negociará en privado con cada el cliente interesado';
                }
                
                $("#text_discount").html(html).css('color', '#006328').show();  
                $("#max_discount a").attr('data-content', 'Descuento máximo que DóndePauto podrá ofrecer para motivar anunciantes interesados. El descuento No será visible por usuarios anunciantes y solo se negociará en privado con cada el cliente interesado');
                $("#max_discount span").css('text-decoration', 'none');

                $("#label_discount strong").text('Descuento máximo para cliente:');

                var minimal_price = price - (price * discount / 100);

                $("#public_price span").text($.number( price, 0, ',', '.' ));
                $("#public_price a").attr('data-content', 'Precio de Lista o Precio Bruto presentado a marcas anunciantes en la Plataforma DóndePauto');

                $("#minimal_price span").text($.number( minimal_price, 0, ',', '.' ));

                $("#our_discount, #label_our_discount").fadeOut();
            }
            else {
                var html = '<p id="text_discount" style="margin-bottom: 1.5em; color: rgb(29, 49, 148);">Si no estableces un Descuento, la plataforma incrementará un <strong>margen de negociación</strong> al <strong>precio base</strong>, y ajustará el <strong>precio de oferta al público</strong>. Este margen se ofrecerá como Descuento al anunciante, en privado, para persuadir el cierre de la venta y/o el pago anticipado del espacio publicitario</p>';
                $("#text_discount").html(html).css('color', 'rgb(29, 49, 148)').show();  

                var our_discount = 15;
                var discount_price = price * our_discount / 100;
                var public_price = price + discount_price;

                $("input[name='public_price']").val(public_price);
                $("input[name='margin']").val(our_discount / 100);
                
                $("#minimal_price span").text($.number( price, 0, ',', '.' ));
                $("#label_discount strong").text('Descuento de ' + $("#publisher_name").text() + ':');
                
                $("#max_discount a").attr('data-content', 'Si no estableces un Descuento, DóndePauto agregará un margen de negociación al precio base');
                $("#max_discount span").css('text-decoration', 'line-through');

                $("#public_price a").attr('data-content', 'Precio de Lista o Precio Bruto presentado a marcas anunciantes en la Plataforma DóndePauto. Es la suma del valor del Precio Base que establece el Medio, más el Margen de Precio añadido por DóndePauto');
                    
                $("#our_discount span").text('$' + $.number( discount_price, 0, ',', '.' ));
                $("#our_discount a").attr('data-content', 'Si el medio no determina un Descuento máximo para clientes finales, DóndePauto añade un margen de precio al Precio Base, que equivaldrá al Descuento que se podrá otorgar al anunciante para motivar el cierre de la venta y/o persuadir el pago anticipado del espacio publicitario');
                $("#our_discount").show();


                $("#public_price span").text($.number( public_price, 0, ',', '.' ));
                $("#label_our_discount").show();
            } 
        }
        else {
           $("#max_discount span").text(0); 
        }

         $(".period_value").html(' / ' + period);
    }

    $.validator.methods.youtube = function( value, element ) {
      return this.optional( element ) || /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/.test( value );
    }

    $("#form-publish").steps({
        bodyTag: "fieldset",
        enableCancelButton: false,
        labels: {
            cancel: "Cancelar",
            current: "paso actual:",
            pagination: "Paginación",
            finish: "Terminar",
            next: "Siguiente",
            previous: "Anterior",
            loading: "Cargando ..."
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            // Always allow going backward even if the current step contains invalid fields!
            if (currentIndex > newIndex)
            {
                return true;
            }

            var form = $(this);

            // Clean up if user went backward before
            if (currentIndex < newIndex)
            {
                // To remove error styles
                $(".body:eq(" + newIndex + ") label.error", form).remove();
                $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
            }

            // Disable validation on fields that are disabled or hidden.
            form.validate().settings.ignore = ":hidden";

            // Start validation; Prevent going forward if false
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            $('.select-cities').select2();
            $('#impact_scenes').select2();
            $('.select2-audience').select2();
            
            $('.tags').tagsInput({
                autocomplete: {
                    selectFirst:true,
                    width:'100px',
                    autoFill:true
                },
                'height':'auto',
                'width':'200px%',
                'interactive':true,
                'defaultText':'Otras etiquetas',
                'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
                'removeWithBackspace' : true,
                'minChars' : 3,
                'maxChars' : 15, // if not provided there is no limit
                'placeholderColor' : '#666666',
                'onAddTag': function(event) {
                    showMessages('more_audiences');
                    calculate('more_audiences', ($('.tag').length));
                },
                'onChange': function(){
                    showMessages('more_audiences');
                },
                'onRemoveTag': function(){
                    showMessages('more_audiences');
                }
            });

            if( currentIndex == 0 ) {
                showMessages('name');
            }
            else if( currentIndex == 1 ) {
                showMessages('impact_scenes');
            }
            else if( currentIndex == 2 ) {
                showMessages('photos');
            }
            else {
                showMessages('price');
            }

        },
        onFinishing: function (event, currentIndex)
        {
            var form = $(this);

            // Disable validation on fields that are disabled.
            // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
            form.validate().settings.ignore = ":hidden";

            // Start validation; Prevent form submission if false
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            var form = $(this);

            var name        = $("input#name").val();
            var period      = $("select#period").val();
            var category    = $("#category_id option:selected").text();
            var impacts     = $.number($("input#impact").val(), 0, ',', '.' );

            bootbox.dialog({
                title: "Estás a punto de publicar este espacio publicitario", 
                message: '<table>' +
                        '    <tr>' +
                        '        <td style="width: 110px;"><strong>Título</strong></td>' +
                        '        <td>' + name + '</td>' +
                        '    </tr>' +
                        '    <tr>' +
                        '        <td><strong>Categoria</strong></td>' +
                        '        <td>' + category + '</td>' +
                        '    </tr>' +
                        '    <tr>' +
                        '        <td><strong>Precio de Oferta</strong></td>' +
                        '        <td>' + $("#public_price").text() + '</td>' +
                        '    </tr>' +
                        '    <tr>' +
                        '        <td><strong>Impactos</strong></td>' +
                        '        <td>' + impacts + ' / ' + period + '</td>' +
                        '    </tr>' +
                        '</table>',
                buttons: {
                    danger: {
                      label: "Volver",
                      className: "btn-default",
                      callback: function() {
                        
                      }
                    },
                    success: {
                      label: "Aceptar",
                      className: "btn-success",
                      callback: function() {
                        $(".se-pre-con").delay(700).show(0);
                        if (myDropzone.getQueuedFiles().length > 0) {
                            myDropzone.processQueue();
                        }
                        else {
                            var data = {};

                            $.each($(".dz-success-server img"), function(key,value) {
                                $(data).attr("keep_images[" + key + "]", $(value).attr('alt'));
                            });

                            $(data).attr("impact_scenes", $("select[name='impact_scenes']").val().toString());
                            $(data).attr("audiences", $("select[name='audiences']").val().toString());
                            $(data).attr("cities", $("select[name='cities']").val().toString());
                            $(data).attr("description", $(".note-editable").html());

                            $('form').ajaxSubmit({
                                data: data,
                                success: function (data) {
                                    window.location.replace(data.route);
                                }
                            });
                        }
                      }
                    }
                }
            }); 
        }
    }).validate({
        errorPlacement: function (error, element)
        {
            element.after(error);
        },
        rules: {
            name: {
                required: true,
                minlength: 30
            },
            description: {
                required: true,
                minlength: 300
            },
            category_id: {
                required: true
            },
            format_id: {
                required: true
            },
            impact_scenes: {
                required: true
            },
            audiences: {
                required: true
            },
            cities: {
                required: true
            },
            price: {
                required: true
            },
            period: {
                required: true
            },
            discount: {
                required: true,
                min: 0,
                max: 100
            },
            youtube: {
                youtube: true,
            }
        },
        messages: {
            name: {
                required:  'Es importante que asignes un buen nombre con el cual los usuarios identifiquen fácilmente el espacio publicitario que estás ofertando.',
                minlength: 'Ingresa un nombre con al menos 30 letras. Cuanto mejor describas tu espacio, será más fácil que nuestros anunciantes lo encuentren'
            },
            description: {
                required:  'No olvides escribir una buena descripción a tu espacio publicitario. Escribe todo lo que creas necesario y pueda ser util para el cliente',
                minlength: 'Ingresa un descripción con al menos 300 letras. Por ejemplo: beneficios, tiempos, variaciones, horarios, ubicaciones, tamaños, frecuencias de salida, y cualquier información de interés para el anunciante'
            },
            category_id: {
                required: 'Selecciona la categoría'
            },
            format_id: {
                required: 'Selecciona el formato'
            },
            impact_scenes: {
                required: 'Selecciona al menos un escenario de impacto'
            },
            audiences: {
                required: 'Selecciona al menos una audiencia'
            },
            cities: {
                required: 'Selecciona al menos una ciudad'
            },
            price: {
                required: 'Debes establecer un precio base de oferta'
            },
            period: {
                required: 'Debes seleccionar el periodo de venta según el precio base'
            },
            discount: {
                required: 'Debes asignar una variable de descuento. En caso de que no desees establecer un descuento, digita el número 0 (CERO)',
                min: 'El  descuento minimo es 0',
                max: 'El descuento máximo es 100'
            },
            youtube: {
                youtube: 'Debe ingresar una url correcta'
            }
        }
    });

    /*var inputs = [
        {   
            name: 'name', 
            title: 'Título de la oferta',
            content: 'El título de la oferta es clave para captar la atención del anunciante. Ingresa un título preciso, entre 40 y 70 caracteres, que permita identificar rápida y fácilmente las características básicas de la oferta',
            maxPoints: 6,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 30, points: 0.4 },
                { min: 40, points: 0.6 },
                { min: 50, points: 1 }
            ]
        },
        {
            name: 'description', 
            title: 'Descripción',
            content: 'Describe las características de este espacio publicitario. Capta el interés y atención del anunciante, y se específico brindando información completa de beneficios, tiempos, variaciones, horarios, ubicaciones, tamaños, frecuencias de salida, y cualquier información de interés para el anunciante. El anunciante debe entender qué recibe, a cambio de su inversión',            
            maxPoints: 15,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 300, points: 0.25 },
                { min: 400, points: 0.5 },
                { min: 500, points: 0.75 },
                { min: 700, points: 1 }
            ]
        },
        {
            name: 'dimension',
            title: 'Dimensiones',
            content: 'Especifica el tamaño del formato publicitario ofertado, si aplica. Ej: 3 x 4 metros; 1mm Alto x 2mm Ancho'
        },
        {
            name: 'address',
            title: 'Dirección',
            content: 'Ingresa la dirección o ubicación del espacio publicitario, si aplica a tu producto. Ejemplo, para una Valla Exterior, etc. Esto facilita la decisión de compra de potenciales anunciantes que se interesan por ciertas ubicaciones',
        },
        {   
            name: 'impact', 
            title: 'Impactos estimados',
            content: 'Digita el número (#) de impresiones, visualizaciones, personas o audiencia que impacta este espacio publicitario durante el periodo aplicable',
            maxPoints: 10,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 100, points: 1 }
            ]
        },
        {   
            name: 'price', 
            title: 'Precio de oferta',
            content: 'Haz más atractivas tus ofertas con precios llamativos y competitivos. El cliente siempre compara alternativas por precios y alcance de impactos (ROI)',
            maxPoints: 1,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 3, points: 1 }
            ]
        }, 
        {
            name: 'category_id', 
            title: 'Categoría',
            content: 'Selecciona una categoría publicitaria a la que corresponde este espacio de pauta, y luego selecciona el Formato. Esto facilita que te encuentren más rápido',
            maxPoints: 2,
            actual: 0
        },
        {
            name: 'period', 
            title: 'Periocidad del espacio de pauta',
            content: 'Selecciona la variable que corresponda al periodo en que se cobra y ejecuta el servicio publicitario. Ejemplo: $500.000, Quincenal. $2.000.000, Trimestral',
            maxPoints: 1,
            actual: 0
        },
        {
            name: 'impact_scenes',
            title: 'Escenarios de impacto',
            content: 'Selecciona lugares de interés, puntos de referencia o zonas comerciales de la ciudad a donde llega tu espacio publicitario o donde son impactadas audiencias o personas. Aumenta las probabilidades de que te encuentren clientes de nicho',
            maxPoints: 10,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 1, points: 0.25 },
                { min: 2, points: 0.5 },
                { min: 3, points: 0.75 },
                { min: 4, points: 1 }
            ]
        },
        {
            name: 'audiences',
            title: 'Perfil de audiencias',
            content: 'Selecciona diferentes perfiles de audiencia o de personas a las que logra impactar o llegar el anunciante al adquirir este espacio publicitario. Aumenta las probabilidades de que te encuentren clientes de nicho',
            maxPoints: 15,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 3, points: 0.25 },
                { min: 5, points: 0.5 },
                { min: 7, points: 0.75 },
                { min: 10, points: 1 }
            ]
        },
        {
            name: 'more_audiences',
            title: 'Agrega más audiencias',
            content: 'Digita “palabras clave” (separadas por coma) que describan otros perfiles de audiencia o sitios de interés relacionados con este espacio publicitario. Ej: Abuelas, Madres Cabeza de Familia, estudiantes, Zona T Bogotá, El Campin, Avenida Dorado',
            maxPoints: 10,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 3, points: 0.25 },
                { min: 5, points: 0.5 },
                { min: 7, points: 0.75 },
                { min: 10, points: 1 }
            ]
        },
        {
            name: 'discount',
            title: 'Descuento',
            content: 'Puedes establecer un descuento máximo aplicable sobre el Precio Base para motivar la compra de anunciantes interesados. Este descuento No será visible desde la Plataforma y solo se negociará en privado con cada el cliente interesado',
            maxPoints: 10,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 5, points: 0.1 },
                { min: 10, points: 0.2 },
                { min: 20, points: 0.4 },
                { min: 30, points: 0.6 },
                { min: 40, points: 0.8 },
                { min: 50, points: 1 },
            ]
        },
        {
            name: 'impact_agency',
            title: 'Agencia Medición (fuente de la cifra de impactos)',
            content: 'Escribe el nombre de la agencia de medición que valida los datos de impactos para dar mayor confianza al potencial cliente. Ej: IBOPE, EGM, Nielsen, Invamer /Gallup, etc',
            maxPoints: 3,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 3, points: 1 }
            ]
        },
        {
            name: 'production_cost',
            title: 'Costo de producción',
            content: 'En caso que ofrezcas la producción de la pieza publicitaria (valla, cuña, video reel) a que hace referencia este espacio publicitario, digita el valor del Costo de Producción específico de la pieza publicitaria',
        },
        {
            name: 'cities',
            title: 'Ciudades',
            content: 'selecciona las ciudades donde se encuentra o a donde llega este espacio publicitario. Esto facilita que te encuentren por geo-referenciación',
            maxPoints: 5,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 1, points: 1 }
            ]
        },
        {
            name: 'alcohol_restriction',
            title: 'Restricciones de pauta',
            content: 'Si este espacio de pauta tienen restricciones para mensajes publicitarios de las siguientes categorías, por favor selecciona las opciones que apliquen. Así descartamos clientes que no son de tu interés',
        },
        {
            name: 'snuff_restriction',
            title: 'Restricciones de pauta',
            content: 'Si este espacio de pauta tienen restricciones para mensajes publicitarios de las siguientes categorías, por favor selecciona las opciones que apliquen. Así descartamos clientes que no son de tu interés',
        },
        {
            name: 'policy_restriction',
            title: 'Restricciones de pauta',
            content: 'Si este espacio de pauta tienen restricciones para mensajes publicitarios de las siguientes categorías, por favor selecciona las opciones que apliquen. Así descartamos clientes que no son de tu interés',
        },
        {
            name: 'sex_restriction',
            title: 'Restricciones de pauta',
            content: 'Si este espacio de pauta tienen restricciones para mensajes publicitarios de las siguientes categorías, por favor selecciona las opciones que apliquen. Así descartamos clientes que no son de tu interés',
        },
        {
            name: 'photos',
            title: 'Imágenes',
            content: 'Incluye imágenes atractivas que describan o exhiban este espacio Publicitario. Imágenes de impacto aumentan el interés de potenciales compradores, y son un factor de confiabilidad en la decisión de compra. Las imágenes NO pueden tener marcas de agua con el nombre del Medio Publicitario, datos de contacto, direcciones web, etc',
            maxPoints: 12,
            actual: 0,
            rules: [
                { min: 0, points: 0 },
                { min: 1, points: 0.17 },
                { min: 2, points: 0.34 },
                { min: 3, points: 0.48 },
                { min: 4, points: 0.65 },
                { min: 5, points: 0.84 },
                { min: 6, points: 1 }
            ]
        },
        {
            name: 'youtube',
            title: 'Video de Youtube',
            content: 'Incluye un video reel de tu oferta (agrega el Link de YouTube)'
        }
    ];*/

    var spaceRules = $("#spaceRules").data("rules");
    var inputs = spaceRules.inputs;
    var points = spaceRules.points;


    $(".select2-categorys").select2({
        placeholder: "Selecciona el tipo de pauta",
        allowClear: false
    });

    var formats = $(".select2-format").data('formats');

    $('.select2-category').select2();

    $( ".select2-category" ).change(function() {
        $(".select2-format").prop("disabled", false).focus();
        var selectFormats;
        var subCategory = $(this).val();

        $.each( formats, function( key, value ) {
            if(key == subCategory) {
                selectFormats = value;
            }
        });

        $(".select2-format").html('');

        if(selectFormats) { 
            $.each(selectFormats, function(index, option) {
              $option = $("<option></option>")
                .attr("value", option.id)
                .text(option.name);
              $(".select2-format").append($option);
            });
        }
        else {
            $(".select2-format").prop("disabled", true).focus();
        }
    });

    //var switchery = new Switchery($('.js-switch')[0], { color: '#00AEEF' });

    var dataImages = $("#serverImages").data('images');

    Dropzone.autoDiscover = false;

    var existingFileCount = 0; // The number of files already uploaded

    myDropzone = new Dropzone('#myDropzone', {
        url: $("form").attr('action'),
        method: $("form").data("typeform"),
        addRemoveLinks: true,
        dictRemoveFile: 'Quitar foto',
        dictMaxFilesExceeded: 'Sólo puedes agregar 6 fotografías',
        dictResponseError: 'Ha ocurrido un error',
        dictFileTooBig: 'La foto es muy pesada',
        dictInvalidFileType: 'Sólo puedes agregar imagenes',
        dictDefaultMessage: 'Seleccione las fotos',
        acceptedFiles: 'image/*',
        autoProcessQueue: false,
        parallelUploads: 6,
        paramName: 'images',
        clickable: true,
        uploadMultiple: true,
        maxFiles: 6,
        headers: { 
            "X-CSRF-TOKEN": $("input[name='_token']").val()
        },
        //maxFilesize: 1,
        // The setting up of the dropzone
        init: function() {
            var thisDropzone = this;

            this.on("successmultiple", function(files, response) {
                window.location.replace(response.route);
            });

            this.on("errormultiple", function(files, response) {
            });

            this.on("completemultiple", function(files, response) {
                //myDrop.removeFiles(files);
            });

            this.on("sendingmultiple", function(files, xhr, formData) {
                formData.append("name", $("input[name='name']").val());
                formData.append("format_id", $("select[name='format_id']").val());

                formData.append("description", $(".note-editable").html());
                formData.append("dimension", $("input[name='dimension']").val());
                
                formData.append("impact_scenes", $("select[name='impact_scenes']").val());
                formData.append("audiences", $("select[name='audiences']").val());
                formData.append("more_audiences", $("input[name='more_audiences']").val());
                formData.append("impact", $("input[name='impact']").val());
                formData.append("impact_agency", $("input[name='impact_agency']").val());

                if($("input[name='alcohol_restriction']:checked").val()) {
                    formData.append("alcohol_restriction", $("input[name='alcohol_restriction']").val());
                }

                if($("input[name='snuff_restriction']:checked").val()) {
                    formData.append("snuff_restriction", $("input[name='snuff_restriction']").val());
                }

                if($("input[name='policy_restriction']:checked").val()) {
                    formData.append("policy_restriction", $("input[name='policy_restriction']").val());
                }

                if($("input[name='sex_restriction']:checked").val()) {
                    formData.append("sex_restriction", $("input[name='sex_restriction']").val());
                }
                
                formData.append("cities", $("select[name='cities']").val());
                formData.append("address", $("input[name='address']").val());
                
                formData.append("youtube", $("input[name='youtube']").val());

                formData.append("minimal_price", $("input[name='minimal_price']").val());
                formData.append("public_price", $("input[name='public_price']").val());
                formData.append("margin", $("input[name='margin']").val());

                formData.append("period", $("select[name='period']").val());
                formData.append("discount", $("input[name='discount']").val());

                formData.append("points", actualValue);

                $.each($(".dz-success-server img"), function(key,value) {
                    formData.append("keep_images[" + key + "]", $(value).attr('alt'));
                });
            });

            this.on("removedfile", function(file) {

                console.log(this.getAcceptedFiles().length + existingFileCount);

                if (file.size == "100001") { 
                    existingFileCount --;
                    thisDropzone.options.maxFiles = thisDropzone.options.maxFiles + 1;
                }
                
                calculate('photos', this.getAcceptedFiles().length + existingFileCount);
                return this._updateMaxFilesReachedClass();
            });

            
            $.each(dataImages, function(key,value){

                var mockFile = { name: value.name, size: '100001' };
                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);
                thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - 1;

                mockFile.previewElement.classList.add('dz-success');
                mockFile.previewElement.classList.add('dz-complete');
                mockFile.previewElement.classList.add('dz-success-server');

                existingFileCount ++;
            });

        },
        accept: function(file, done) {
            calculate('photos', this.getAcceptedFiles().length + existingFileCount + 1);
            return done();
        },

    });

    function calculate(name, length) {
        var input = findInput(name);

        if(input.rules) {
            var rules   = $.grep(input.rules, function(r){ return length >= r.min });
            var maxRule = Math.max.apply(Math, rules.map(function(rule){return rule.min;}));
            var rule    = $.grep(rules, function(r){ return maxRule == r.min });

            if(rule.length > 0) {
                rule = rule[0];

                if(sumValue != (rule.points * input.maxPoints)) {
                    sumValue        = rule.points * input.maxPoints;
                    updateValue(sumValue, input);
                }
            }
        }
    }

    function calculateSelect(name, value) {
        var input = findInput(name);
        if(input.actual >= 0) {      
            if(value > 0 || value.length > 0) {
                sumValue = input.maxPoints;  
            }
            else {
                sumValue = 0;
            }
            
            updateValue(sumValue, input);
        }
    }

    function updateValue(sumValue, input) {
        if(progresActive) {
            newValue        = actualValue + sumValue - input.actual;
            actualValue     = newValue;
            input.actual    = sumValue;

            $('.pieProgress').asPieProgress('go', newValue);
        }
    }

    function findInput(name) {
        var input = inputs[name];

        if(input) {
            return inputs[name];
        }

        return {};
        
    }

    function getLength(input) {
        if(input.attr("type") == 'number') {
            return input.val();
        }

        return input.val().length;
    }

    $("input, textarea").on('keyup', function() {
        var length  = getLength($(this));
        var name    = $(this).attr('name');

        calculate(name, length);
    }).keyup();

    $("input, textarea").on('change', function() {
        var length  = getLength($(this));
        var name    = $(this).attr('name');
        
        calculate(name, length);
    }).change();

    $("select").change(function() {
        var name    = $(this).attr('name');
        var value   = $(this).val();

        if($(this).attr('multiple')) {
            var length = $("select#" + name + " option:selected").length;
            calculate(name, length);
        }
        else {
            calculateSelect(name, value);
        }
    });

    $("#bounces").fadeOut();
    var inputName = '';

    function showMessage(title, content) {
        $("#bounces").show().delay(2000).fadeOut();
        $("#message-title").text(title);
        $("#message-text").text(content); 
    }

    function showMessageHtml(title, content) {
        $("#bounces").show().delay(2000).fadeOut();
        $("#message-title").text(title);
        $("#message-text").html(content); 
    }

    function showMessages(name) {
        var input = findInput(name);

        if(input.title && inputName != name) {
            showMessage(input.title, input.content);  
        }

        inputName = name;
    }

    $( "form :input" ).focusin(function() {
        showMessages($(this).attr('name'));
    });

    $( "form select" ).change(function(){
        showMessages($(this).attr('name'));
    });

    $('select').on('select2:open', function (evt) {
        showMessages($(this).attr('name'));
    });


    $( "#more_audiences_tag" ).change(function(){
        showMessages('more_audiences');
    });

    $( "#more_audiences_tag" ).focusin(function(){
        showMessages('more_audiences');
    });

    $( "input#discount, input#price" ).change(function() {
        var discount    = $("input#discount").val();
        var price       = $("input#price").val();

        if(discount.length == 0 || price.length == 0) {
            $("#with_discount").fadeOut();
            $("#text_discount").fadeOut();
        }
    });

    $( "select#period" ).change(function() {
        updatePrices();
    });

    $( "input#discount, input#price" ).on('keyup', function() {
        updatePrices();
    }).keyup();

    $( "a.mclose").click(function() {
        $(this).fadeOut();
        $(".messages .loading").fadeOut();
        $(".messages #message-title").fadeOut();
        $(".messages #message-text").fadeOut();
        $(".messages a#activate").css({ display: "block" });
    });

    $( ".messages a#activate").click(function() {
        $(this).fadeOut();
        $(".messages .loading").show();
        $(".messages #message-title").show();
        $(".messages #message-text").show();
        $("a.mclose").show();
    });


    $('[data-toggle="popover"]').popover({
        triger: 'focus',
        content: '....'
    });

    $(window).scroll(function() {
        t = $('form').offset();
        t = t.top;
        
        s = $(window).scrollTop();
        
        d = t-s;
        
        if (d < 0) {
            $('#fixedPoints').addClass('fixed');
        } else {
            $('#fixedPoints').removeClass('fixed');
        }
    });

    progresActive = true;

    if(initValue > 0) {
        actualValue = initValue;
        $('.pieProgress').asPieProgress('go', initValue);
    }

    function toObject(arr) {
      var rv = {};
      for (var i = 0; i < arr.length; ++i)
        rv[i] = arr[i];
      return rv;
    }

    $('.summernote').summernote({
        height: 160,
        'placeholder': 'Brinda información completa de beneficios, tiempos, variaciones, horarios, ubicaciones, tamaños, frecuencias de salida, y cualquier información de interés para el anunciante y su agencia',
        callbacks: {
            onFocus: function() {
              showMessages('description');
            }
        }
    });

});