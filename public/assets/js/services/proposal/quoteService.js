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
                { "data": "created_at_datatable", "name": "created_at_datatable" },
                { "data": "expires_at_datatable", "name": "expires_at_datatable" },
                { "data": "expires_at_days", "name": "expires_at_days" },
                { "data": "days", "name": "days" },
                { "data": "title", "name": "title" },
                { "data": "advertiser_name", "name": "advertiser_name" },
                { "data": "count_spaces", "name": "count_spaces" }
            ],
            "columnDefs": [
                {
                    "targets": [1,2,3,4,5,6,7],
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

                $('td:eq(3)', nRow).html(aData.expires_at_days + " días");
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
            $("#modalContacts #proposal-contacts").prepend(socialContact);
        });

        $("#newContact").click(function(){
                $("#advertiserContactModal").modal();
                $("#advertiserContactModal input").val("");
                $("#advertiserContactModal textarea").val("");
            });

        $("#form-create-contact-advertiser").click(function() {
            var url = '/anunciantes/' + advertiser.id + '/contacts';

            console.log(url);

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
                    var socialContact = AdvertiserService.getSocialContact(data.contact);
                    $('#modalContacts #proposal-contacts').prepend(socialContact);
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
            "minimal_price":    space.minimal_price,
            "public_price":     space.public_price,
            "commission":       space.commission,
            "commission_price": space.commission_price,
            "markup_publisher": {
                "per": 0,
                "price": 0
            },
            "markup_company": {
                "per": 0,
                "price": 0
            },
            "discount":         discount / 100, 
            "discount_price":   space.public_price * (discount / 100),
            "discount_income":  0,
            "discount_income_price":  0
        };

        prices.public_price     = prices.public_price - prices.discount_price;
    
        if(withMarkup == '0') {
            prices.commission_price         = prices.public_price * prices.commission;
            prices.discount_income_price    = prices.commission_price;
            prices.markup_publisher.per     = space.percentage_markdown - (discount / 100);
            prices.markup_publisher.price   = space.markup_price - prices.discount_price;
            prices.minimal_price            = prices.minimal_price + prices.markup_publisher.price;
        }
        else {
            prices.markup_company.per       = space.percentage_markdown - (discount / 100);
            prices.markup_company.price     = space.markup_price - prices.discount_price;
            prices.discount_income_price    = prices.markup_company.price + prices.commission_price;
        }   

        prices.discount_income = prices.discount_income_price / prices.public_price;

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
        var markup_publisher    = getHtmlValue(prices.markup_publisher.price, prices.markup_publisher.per);
        var markup_company      = getHtmlValue(prices.markup_company.price, prices.markup_company.per);
        var commission          = getHtmlValue(prices.commission_price, prices.commission);
        var income              = getHtmlValue(prices.discount_income_price, prices.discount_income);

        $( pre + " #discount_public_price").text(getNumberPrice(prices.public_price));
        $( pre + " #discount_markup_publisher").html(markup_publisher);
        $( pre + " #discount_markup_company").html(markup_company);
        $( pre + " #discount_minimal_price").text(getNumberPrice(prices.minimal_price));
        $( pre + " #discount_commission").html(commission);
        $( pre + " #discount_income").html(income);
        
        $("#field_discount label").attr("style", "font-size: 15px; font-weight: 400;")
            .text("Descuento: " + getNumberPrice(prices.discount_price));
    }

    function validAndDrawModalDiscount()
    {
        var discount = $(".space_form_discount #discount").val();
        var withMarkup = $(".space_form_discount #markup").val();

        if(discount >= 0 && discount <= (space.percentage_markdown * 100)) {
            drawModalDiscount("#new-values", space, discount, withMarkup);    
            $("#discount_error").text(""); 
        }
        else {
            drawModalDiscount("#new-values", space, 0, withMarkup);   
            $("#discount_error").text("El descuento debe ser menor al markup"); 
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

    function drawTotalsProposal(proposal)
    {
        $("#pivot_total").text(getNumberPrice(proposal.pivot_total));
        $("#pivot_total_cost").text(getNumberPrice(proposal.pivot_total_cost));
        $("#total_discount_price").text(" -" + getNumberPrice(proposal.total_discount_price));
        $("#total_discount").text(getNumberPercentage(proposal.total_discount));
        $("#pivot_total_income_price").text(getNumberPrice(proposal.pivot_total_income_price));
        $("#pivot_total_income").text(getNumberPercentage(proposal.pivot_total_income));
        $("#pivot_total_markup_price").text(getNumberPrice(proposal.pivot_total_markup_price));
        $("#pivot_total_markup").text(getNumberPercentage(proposal.pivot_total_markup));
        $("#pivot_total_commission_price").text(getNumberPrice(proposal.pivot_total_commission_price));
        $("#pivot_total_commission").text(getNumberPercentage(proposal.pivot_total_commission));
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
            $(".space_form_discount #discount").val(space.pivot_discount * 100);
            $(".space_form_discount #markup").val(space.pivot_with_markup);

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

            $.post("/propuestas/" + proposal.id + "/discount/" + space.id, parameters, function( data ) {
                if(data.success) {
                    space = data.space;
                    drawModalSpace(space);
                    drawTotalsProposal(data.proposal);
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

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
        },
        initProposal: function(){
            initContacts();
            initDrawAdvertiser();
            initModalDiscount();
        },
        initContacts: function(){
            initContacts();
        },
        reload: function(){
            reload();
        }
    };
}();