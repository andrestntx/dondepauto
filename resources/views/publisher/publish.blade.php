@extends('layouts.publisher')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('extra-css')
    <link href="/assets/css/plugins/steps/jquery.steps.css" rel="stylesheet">
@endsection

@section('content')
    <div class="ibox float-e-margins" style="margin-bottom: 0;">
        <div class="ibox-content" style="padding: 30px 0;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <h2 style="margin-bottom:5px; text-transform:none;">Publica tu primera oferta</h2>
                </div>
            </div>  
        </div>          
    </div>

    <div class="col-md-6 col-md-offset-3" style="margin-top:30px;">
        <div class="ibox">       
            <div class="ibox-content">
                {!! Form::open(['url' => '/', 'id' => 'form-publish', 'class' => 'wizard-big form-steps']) !!}
                    <h1>Datos básicos</h1>
                    <fieldset>
                        <h2>Datos básicos</h2>
                        <div class="row">
                            <div class="col-lg-12">
                                {!! Field::text('name', ['label' => 'Título de la oferta', 'ph' => 'Ejemplo: Valla Publicitaria en Chapinerito Bogotá', 'required']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('category_id', $categories, ['label' => 'Categoría (Tipo de pauta)', 'class' => 'select2-category', 'required']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('format_id', ['' => ''], ['class' => 'select2-format', 'required', 'disabled', 'data-formats' => $formats, 'id' => 'format_id', 'empty' => 'Primero seleccione la categoría']) !!}
                            </div>
                            <div class="col-md-12">
                                {!! Field::textarea('description', ['label' => 'Descripción de la oferta', 'ph' => 'Valla bonita en Bogotá de tanto por tanto', 'required', 'rows' => '5']) !!}
                            </div>
                        </div>
                    </fieldset>
                    <h1>Segmentación</h1>
                    <fieldset>
                        <h2>Segmentación</h2>
                        <div class="row">
                            
                            <div class="col-md-12">
                                {!! Field::select('impact_scene_id', $scenes) !!}
                            </div>

                            <legend class="h4" style="padding-top: 10px;">Restricciones</legend>
                            <div class="col-md-4" style="padding-left: 35px; padding-top: 10px;">
                                <div class="checkbox m-r-xs">
                                    {!! Form::checkbox('alcohol_restriction', 1, null, ['id' => 'alcohol_restriction']) !!}
                                    <label for="alcohol_restriction">
                                        Alcohol
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-left: 35px; padding-top: 10px;">
                                <div class="checkbox m-r-xs">
                                    {!! Form::checkbox('snuff_restriction', 1, null, ['id' => 'snuff_restriction']) !!}
                                    <label for="snuff_restriction">
                                        Tabaco
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-left: 35px; padding-top: 10px;">
                                <div class="checkbox m-r-xs">
                                    {!! Form::checkbox('policy_restriction', 1, null, ['id' => 'policy_restriction']) !!}
                                    <label for="policy_restriction">
                                        Política
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                {!! Field::text('address') !!}
                            </div>
                            <div class="col-md-12">
                                {!! Field::select('city_id', $cities) !!}
                            </div>
                        </div>
                    </fieldset>

                    <h1>Precio</h1>
                    <fieldset>
                        <h2>Precio</h2>
                        <div class="row">
                            <div class="col-md-12">
                                {!! Field::text('impact') !!}
                            </div>
                            <div class="col-md-12">
                                {!! Field::text('minimal_price') !!}
                            </div>
                            <div class="col-md-12">
                                {!! Field::select('period', $periods, ['empty' => 'seleccione un período']) !!}
                            </div>
                        </div>
                    </fieldset>

                    <h1>Fotografías</h1>
                    <fieldset>
                        <h2>Fotografías</h2>
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                    </fieldset>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <!-- Steps -->
    <script src="/assets/js/plugins/staps/jquery.steps.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#form-publish").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
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
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = "";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                errorPlacement: function (error, element)
                {
                    element.after(error);
                },
                rules: {
                    name: {
                        required: true,
                        minlength: 15
                    },
                    description: {
                        required: true,
                        minlength: 15
                    },
                    category_id: {
                        required: true
                    },
                    format_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required:  'Es importante que asignes un buen nombre a tu Espacio. Es importante que asignes una buena descripción a tu Espacio',
                        minlength: 'Escribe un nombre con almenos 15 letras'
                    },
                    description: {
                        required:  'Es importante que asignes una buena descripción a tu Espacio. Es importante que asignes una buena descripción a tu Espacio',
                        minlength: 'Escribe una descripción con almenos 15 letras'
                    },
                    category_id: {
                        required: 'Selecciona la categoría'
                    },
                    format_id: {
                        required: 'Selecciona el formato'
                    }
                }
            });

            $(".select2-categorys").select2({
                placeholder: "Selecciona el tipo de pauta",
                allowClear: false
            });

            var formats = $(".select2-format").data('formats');

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

                $.each(selectFormats, function(index, option) {
                  $option = $("<option></option>")
                    .attr("value", option.id)
                    .text(option.name);
                  $(".select2-format").append($option);
                });
            });
       });
    </script>
@endsection