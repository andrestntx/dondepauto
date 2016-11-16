/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var QuoteService = function() {

    var table;
    var urlSearch;
    var space;
    var proposal;

    function initTable(urlSearch) {
        urlSearch = urlSearch;

        table = $('#quotes-datatable').DataTable({
            "order": [[1, "desc"]],
            "ajax": urlSearch,
            "pageLength": 50,
            "processing": true,
            "serverSide": true,
            "deferRender": true,
            "columns": [
                { "data": null, "name": "id", "orderable": false, "searchable": false},
                { "data": "send_at_datatable", "name": "send_at_datatable" },
                { "data": "days", "name": "days" },
                { "data": "expires_at_datatable", "name": "expires_at_datatable" },
                { "data": "expires_at_days", "name": "expires_at_days" },
                { "data": "advertiser_company", "name": "advertiser_company" },
                { "data": "title", "name": "title" },
                { "data": "pivot_total", "name": "pivot_total" },
                { "data": "pivot_total_income_price", "name": "pivot_total_income_price" }
            ],
            "columnDefs": [
                {
                    "targets": [1,2,3,4,5,6,7,8],
                    "visible": true,
                    "searchable": true,
                    className: "text-small text-center",
                },
                {
                    "targets": [0],
                    "visible": true,
                    "searchable": false,
                    className: "text-small text-center"
                }
            ],
            "language": {
                "lengthMenu": "Ver _MENU_ por página",
                "zeroRecords": "Lo siento, no se enontraron propuestas",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay propuestas",
                "infoFiltered": "(Filtrado de _MAX_ asignados)",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $('td:eq(0)', nRow).html(
                    "<a href='/propuestas/" + aData.id + "' class='btn btn-xs btn-success'><i class='fa fa-pencil'></i></a>"
                    //"<button class='btn btn-xs btn-success quoteModal' data-quote='" + JSON.stringify(aData) + "' title='Ver Propuesta' data-toggle='modal' data-target='#quoteModal'><i class='fa fa-search-plus'></i></button>"
                );

                if(aData.expires_at_days) {
                    var expires = $("<strong></strong>").text(aData.expires_at_days + " días");
                    if(aData.expires_at_days < 0) {
                        expires.addClass("text-danger");
                    }

                    $('td:eq(4)', nRow).html(expires);    
                }

                $('td:eq(5)', nRow).html($("<strong></strong>").text(aData.advertiser_company));

                var spaces = aData.view_spaces.length + ' ESPACIOS // ';
                $.each(aData.view_spaces, function( index, space ) {                    
                    if(space.pivot_title) {
                        spaces = spaces + ' - ' + space.pivot_title;    
                    }
                });

                
                $('td:eq(6)', nRow).html(
                    $("<span></span>")
                        .text(aData.title)
                        .attr('data-toggle', 'tooltip')
                        .attr('data-placement', 'left')
                        .attr('title', spaces)
                );
                
                $('td:eq(7)', nRow).html(numeral(aData.pivot_total).format('$ 0,0'));
                $('td:eq(8)', nRow).html(numeral(aData.pivot_total_income_price).format('$ 0,0'));
            },
            "drawCallback": function(settings, json) {
                $("#countDatatable").html(settings.fnRecordsDisplay());
                $('[data-toggle="tooltip"]').tooltip();
                /*var searchQuote = $("#search-quote").data("search");
                if(searchQuote){
                    $(".quoteModal").click();
                    $("#search-quote").data("search", null);
                }*/
            }
        });

        $("#quotes-datatable_filter input").unbind();

        $("#quotes-datatable_filter input").bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.search(this.value).draw();   
            }
        }); 
    };

    function initContacts() 
    {
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD hh:mm A'
        });

        proposal    = $("#proposal").data('proposal');
        advertiser  = $("#proposal").data('advertiser');
        contacts    = $("#proposal").data('contacts');

        $.each(contacts, function( index, contact ) {
            var socialContact = UserService.getSocialContact(contact);
            $("#tabContacts #proposal-contacts").prepend(socialContact);
        });

        $("#newContact").click(function(){
                $("#advertiserContactModal").modal();
                $("#advertiserContactModal input").val("");
                $("#advertiserContactModal textarea").val("");
            });

        $("#form-create-contact-advertiser").click(function() {
            var url = '/anunciantes/' + advertiser.id + '/contacts';

            var parameters = {
                'action[id]':           $("#modal_contact_action_id").val(),
                'action[action_at]':    $("#modal_contact_action_date").val(),
                'comments':             $("#modal_contact_comments").val(),
                'proposal_id'      :    proposal.id,
                'type':                 $("#modal_contact_type").val(),
            };

            $.post(url, parameters, function( data ) {

                $("#advertiserContactModal input").val("");
                $("#advertiserContactModal textarea").val("");

                if(data.success) {
                    console.log(data);
                    console.log(data.contact.action.state);
                    var socialContact = AdvertiserService.getSocialContact(data.contact);
                    $('#proposal-contacts').prepend(socialContact);
                    $(".proposal-state-text").text(data.contact.action.state);
                }
                else {
                    console.log('error');
                }
            });
        });
    };

    function initDrawAdvertiser()
    {
        $("#proposalAdvertiser").click(function(){
            AdvertiserService.drawModal($("#proposal").data("advertiser"));
            $("#userModal").modal();
        });
    }

    function getFilterSearch()
    {
        return $(".dataTables_filter input").val();
    };

    function reload()
    {
        table.search(getFilterSearch()).draw();
    };

    function calculatePrices(space, discount, withMarkup)
    {
        var prices = {
            "minimal_price":    space.prices_minimal_price,
            "public_price":     space.prices_public_price,
            "commission":       space.prices_commission_per,
            "commission_price": space.prices_commission_price,
            "markup_publisher": {
                "per": 0,
                "price": 0
            },
            "markup_company": {
                "per": 0,
                "price": 0
            },
            "discount":         discount / 100, 
            "discount_price":   space.prices_public_price * (discount / 100),
            "discount_income":  0,
            "discount_income_price":  0
        };

        prices.public_price             = prices.public_price       - prices.discount_price;
        var markupWithDiscount          = space.prices_markup_per   - prices.discount;
        var markupPriceWithDiscount     = space.prices_markup_price - prices.discount_price;
    
        if(withMarkup == '0') {
            prices.markup_publisher.per     = markupWithDiscount;
            prices.markup_publisher.price   = markupPriceWithDiscount;
            prices.minimal_price            = prices.minimal_price + markupPriceWithDiscount;
            prices.commission_price         = prices.minimal_price * prices.commission;
            prices.discount_income_price    = prices.commission_price;
        }
        else {
            prices.markup_company.per       = markupWithDiscount;
            prices.markup_company.price     = markupPriceWithDiscount;
            prices.discount_income_price    = markupPriceWithDiscount + prices.commission_price;
        }   

        prices.discount_income = prices.discount_income_price / prices.public_price;

        console.log(prices);

        return prices;
    };

    function getNumberPrice(number)
    {
        return "$ " + $.number(number, 0, ',', '.' );
    }

    function getNumberPercentage(per)
    {
        number = $.number(per * 100, 1);
        return "(" + number + "%)";
    }

    function initSendProposal() {
        $("#sendProposal").click(function(e) {   
            swal({
                text: '¿Está seguro de enviar esta propuesta?',
                title: 'Enviar propuesta',
                type: "warning",
                confirmButtonText: "Confirmar",
                confirmButtonColor: "#f8ac59",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {     
                    $.post("/propuestas/" + proposal.id + "/send", {}, function( data ) {
                        if(data.success) {
                            swal({
                                "title": "Propuesta enviada", 
                                "type": "success",
                                closeOnConfirm: true,
                            });
                        }
                        else {
                            swal({
                                "title": "Hubo un error", 
                                "type": "warning",
                                closeOnConfirm: true,
                            });
                        }
                    }).fail(function(data) {
                        swal({
                            title: 'Hubo un error',
                            text: 'Código ' + data.status,
                            type: "warning",
                        });
                    });
                }
                else {

                } 
            });
        });
    }

    function getHtmlValue(price, per)
    {
        return  $("<span></span").append(
                    getNumberPrice(price)
                ).append(
                    $("<span style='font-size: 12px;'></span>")
                    .addClass("text-success")
                    .text(" (" + $.number(per * 100, 1) + "%)")
                );
    }

    function drawModalDiscount(pre, space, discount, withMarkup)
    {
        var prices              = calculatePrices(space, discount, withMarkup);
        var markup_company      = getHtmlValue(prices.markup_company.price, prices.markup_company.per);
        var markup_publisher    = getHtmlValue(prices.markup_publisher.price, prices.markup_publisher.per);
        var discount_val        = getHtmlValue(prices.discount_price, discount / 100);
        var commission          = getHtmlValue(prices.commission_price, prices.commission);
        var income              = getHtmlValue(prices.discount_income_price, prices.discount_income);
    
        $( pre + " #discount_public_price").text(getNumberPrice(prices.public_price));
        $( pre + " #discount_minimal_price").text(getNumberPrice(prices.minimal_price));
        $( pre + " #discount_markup_company").html(markup_company);
        $( pre + " #discount_markup_publisher").html(markup_publisher);
        $( pre + " #discount_val").html(discount_val);
        $( pre + " #discount_commission").html(commission);
        $( pre + " #discount_income").html(income);

        $("#field_discount label").attr("style", "font-size: 15px; font-weight: 400;")
            .html("")
            .append("Descuento: ")
            .append(getHtmlValue(prices.discount_price, discount / 100));
    }

    function validAndDrawModalDiscount()
    {
        var discount = $(".space_form_discount #discount").val();
        var withMarkup = $(".space_form_discount #markup").val();

        if(discount >= 0 && discount <= (space.prices_markup_per * 100)) {
            
            drawModalDiscount("#new-values", space, discount, withMarkup);    
            $("#discount_error").text(""); 
        }
        else {
            drawModalDiscount("#new-values", space, 0, withMarkup);   
            $("#discount_error").text("El descuento debe ser menor al markup"); 
        }

        if(discount > 0 && discount <= (space.prices_markup_per * 100)) {
            $("#old-values").attr("style", "color: rgba(128, 128, 128, 0.5);");
        }
        else {
            $("#old-values").attr("style", "color: #6C7A7A;");
        }
    }

    function drawModalSpace(newSpace)
    {
        space = newSpace;
        SpaceService.drawModal("spaceModal", space, "espacios");
        $("#proposal_space_title").text(space.pivot_title);
        $("#proposal_space_description").text(space.pivot_description);
    }

    function reloadTable()
    {
        SpaceService.reload();
    }

    function drawTotalsProposal(input, proposal)
    {
        $(input + " #pivot_total").text(getNumberPrice(proposal.pivot_total));
        $(input + " #pivot_total_cost").text(getNumberPrice(proposal.pivot_total_cost));
        $(input + " #total_discount_price").text(" -" + getNumberPrice(proposal.total_discount_price));
        $(input + " #total_discount").text(getNumberPercentage(proposal.total_discount));
        $(input + " #pivot_total_income_price").text(getNumberPrice(proposal.pivot_total_income_price));
        $(input + " #pivot_total_income").text(getNumberPercentage(proposal.pivot_total_income));
        $(input + " #pivot_total_markup_price").text(getNumberPrice(proposal.pivot_total_markup_price));
        $(input + " #pivot_total_markup").text(getNumberPercentage(proposal.pivot_total_markup));
        $(input + " #pivot_total_commission_price").text(getNumberPrice(proposal.pivot_total_commission_price));
        $(input + " #pivot_total_commission").text(getNumberPercentage(proposal.pivot_total_commission));
    }

    function initModalDiscount()
    {
        proposal = $("#proposal").data('proposal');

        $(document).on("click", ".spaceModal", function () {
            space = $(this).data('space');

            $("#proposal_space_title").text(space.pivot_title);
            $("#proposal_space_description").text(space.pivot_description);
        });

        $(document).on("click", "#newDiscount", function () {
            $(".space_form_discount #discount").val(space.proposal_prices_discount * 100);
            $(".space_form_discount #markup").val(space.proposal_prices_with_markup);

            drawModalDiscount("#old-values", space, 0, 1);
            validAndDrawModalDiscount();
            
            $("#spaceDiscountModal").modal();
        });

        $(document).on("click", "#editProposalTitle", function () {
            $(".form_proposal_edit #title").val(space.pivot_title);
            $(".form_proposal_edit #description").val(space.pivot_description);
            
            $("#editProposalModal").modal();
        });

        editProposalModal

        $(".space_form_discount #discount").keyup(function() {
            validAndDrawModalDiscount();    
        });

        $(".space_form_discount #markup").change(function() {
            validAndDrawModalDiscount();    
        });

        $("#formDiscountSpaceModal").click(function(){
            modal = $("#spaceDiscountModal");
            modal.find("#sk-spinner-modal").show();
            modal.find(".form-button-data").prop("disabled", true);

            var parameters = {
                discount: $(".space_form_discount #discount").val() / 100,
                with_markup: $(".space_form_discount #markup").val()
            };

            console.log(parameters);

            $.post("/propuestas/" + proposal.id + "/discount/" + space.id, parameters, function( data ) {
                if(data.success) {
                    space = data.space;
                    drawModalSpace(space);
                    drawTotalsProposal("#tab-initial-prices", data.proposal);
                    drawTotalsProposal("#tab-final-prices", data.finalProposal);
                    modal.find("#sk-spinner-modal").hide();
                    reloadTable();

                    modal.modal('toggle');
                    modal.find(".form-button-data").prop("disabled", false);
                }
                else {
                    modal.find("#sk-spinner-modal").hide(); 
                    modal.modal('toggle');
                    modal.find(".form-button-data").prop("disabled", false);
                    
                    swal({
                        title: 'Hubo un error',
                        text: 'Error controlado',
                        type: "warning",
                    });
                }
            }).fail(function(data) {
                modal.find("#sk-spinner-modal").hide();
                modal.modal('toggle');
                modal.find(".form-button-data").prop("disabled", false);
                swal({
                    title: 'Hubo un error',
                    text: 'Código ' + data.status,
                    type: "warning",
                });
            });
        });

        $("#formProposalModal").click(function(){
            modal = $("#editProposalModal");
            modal.find("#sk-spinner-modal").show();
            modal.find(".form-button-data").prop("disabled", true);

            var parameters = {
                title: $(".form_proposal_edit #title").val(),
                description: $(".form_proposal_edit #description").val()
            };

            $.post("/propuestas/" + proposal.id + "/discount/" + space.id, parameters, function( data ) {
                if(data.success) {
                    space = data.space;
                    drawModalSpace(space);
                    modal.find("#sk-spinner-modal").hide();
                    reloadTable();

                    modal.modal('toggle');
                    modal.find(".form-button-data").prop("disabled", false);
                }
                else {
                    modal.find("#sk-spinner-modal").hide(); 
                    modal.modal('toggle');
                    modal.find(".form-button-data").prop("disabled", false);
                    
                    swal({
                        title: 'Hubo un error',
                        text: 'Error controlado',
                        type: "warning",
                    });
                }
            }).fail(function(data) {
                modal.find("#sk-spinner-modal").hide();
                modal.modal('toggle');
                modal.find(".form-button-data").prop("disabled", false);
                swal({
                    title: 'Hubo un error',
                    text: 'Código ' + data.status,
                    type: "warning",
                });
            });
        });
    }

    function changeToSelectButton(button)
    {
        button.html("")
            .removeClass("btn-default")
            .addClass("btn-info")
            .append($("<i></i>").addClass("fa fa-check-circle"))
            .append(" seleccionado");
    }

    function changeToDeselectButton(button)
    {
        button.html("")
            .removeClass("btn-info")
            .addClass("btn-default")
            .append($("<i></i>").addClass("fa fa-check-circle"))
            .append(" seleccionar");
    }

    function changeSelectButton(button, selected)
    {
        if(selected == 1) {
            changeToSelectButton(button);
        } 
        else {
            changeToDeselectButton(button)
        }
    }

    function changeSpaceSelectButton(button, space)
    {
        if(space.pivot) {
            changeSelectButton(button, space.pivot.selected);
        } 
    }

    function drawModalProposalSpace(inputId, space) 
    {
        $('#' + inputId + ' #modalProposalEdit').attr('href', '/propuestas/' + proposal.id + '/spaces/' + space.id + '/edit');    
    }
    

    function initSpaceSelect(){
        $("#space_selected").click(function(e){
            button = $(this);
            var url = '/propuestas/' + proposal.id + '/spaces/' + $(this).attr('data-space-id') + '/select';

            var parameters = { select: 1 };
            if(button.hasClass("btn-info")) {
                parameters.select = 0;
            }

            $.post(url, parameters, function( data ) {
                if(data.success) {
                    changeSelectButton(button, parameters.select);
                    swal(data.message, "", "success");
                    SpaceService.reload();
                }
                else{
                    swal("Hubo un error", "", "warning");
                }
            }).fail(function(){
                swal("Algo ocurrió. Hubo un error", "", "warning");
            });
        });
    }

    function getDatafinishSave()
    {
        var data = {};

        $.each($(".dz-success-server img"), function(key,value) {
            $(data).attr("keep_images[" + key + "]", $(value).attr('alt'));
        });

        $(data).attr("impact_scenes", $("select[name='impact_scenes']").val().toString());
        $(data).attr("audiences", $("select[name='audiences']").val().toString());
        $(data).attr("cities", $("select[name='cities']").val().toString());
        $(data).attr("description", $(".note-editable").html());

        return data;
    }

    function redirectToProposal(proposal_id)
    {
        window.location.replace('/propuestas/' + proposal_id);
    }

    function swalEditOrExit(proposal_id)
    {
        $(".se-pre-con").delay(700).hide();
        swal({
            title: 'Espacio publicitario actualizado',
            text: '¿Deseas seguir editando?',
            type: "info",
            confirmButtonText: "Seguir editando",
            confirmButtonColor: "#1C84C6",
            cancelButtonText: "Salir",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
        },
        function(isConfirm) {
            if (! isConfirm) {     
                redirectToProposal(proposal_id);
            }
        });
    }

    function finishSave(form, myPublishDropzone, proposal_id, space_id) {
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
                    console.log('cancela');  
                  }
                },
                info: {
                  label: "Actualizar original",
                  className: "btn-success",
                  callback: function() {
                        myPublishDropzone.on("successmultiple", function(files, response) {
                            swalEditOrExit(proposal_id);
                        });

                        $(".se-pre-con").delay(700).show(0);

                        if (myPublishDropzone.getQueuedFiles().length > 0) {
                            myPublishDropzone.processQueue();
                        }
                        else {
                            $('form').ajaxSubmit({
                                data: getDatafinishSave(),
                                success: function (data) {
                                    swalEditOrExit(proposal_id);
                                }
                            });
                        }
                  }
                },
                success: {
                  label: "Duplicar y finalizar",
                  className: "btn-info",
                  callback: function() {

                    myPublishDropzone.options.url = '/propuestas/' + proposal_id + '/spaces/' + space_id + '/duplicate';

                    myPublishDropzone.on("successmultiple", function(files, response) {
                        redirectToProposal(proposal_id);
                    });

                    $(".se-pre-con").delay(700).show(0);
                    
                    if (myPublishDropzone.getQueuedFiles().length > 0) {
                        myPublishDropzone.processQueue();
                    }
                    else {
                        
                        $('form').ajaxSubmit({
                            data: getDatafinishSave(),
                            url: myPublishDropzone.options.url,
                            success: function (data) {
                                redirectToProposal(proposal_id);
                            },
                            fail: function(){
                                alert('error');
                            }
                        });
                    }
                  }
                }
            }
        }); 
    }

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
        },
        initProposal: function(){
            initSendProposal();
            initContacts();
            initDrawAdvertiser();
            initModalDiscount();
            initSpaceSelect();
        },
        initContacts: function(){
            initContacts();
        },
        reload: function(){
            reload();
        },
        changeSpaceSelectButton: function(button, space) {
            changeSpaceSelectButton(button, space);
        },
        drawModalProposalSpace: function(inputId, space) {
            drawModalProposalSpace(inputId, space);
        },
        finishSave: function(form, myPublishDropzone, proposal_id, space_id) {
            finishSave(form, myPublishDropzone, proposal_id, space_id);
        }
    };
}();