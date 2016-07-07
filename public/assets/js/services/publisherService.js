/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var PublisherService = function() {

    var table;

    function initTable(urlSearch) {
        table = $('#publishers-datatable').DataTable({
            "order": [[6, "desc"]],
            'info': true,
            "ajax": urlSearch,
            "deferRender": true,
            "processing": true,
            "serverSide": true,
            "columns": [
                { "data": null, "name": "company", "orderable": false },
                { "data": "created_at_datatable", "name": "created_at_datatable"},
                { "data": "company" , "name": "company" },
                { "data": "first_name" , "name": "first_name" },
                { "data": "state" , "name": "state" },
                { "data": "count_spaces" , "name": "count_spaces" },
                { "data": "comments" , "name": "comments" },

                { "data": "state_id", "name": "state_id"},
                { "data": "space_city_names", "name": "space_city_names"},
                { "data": "has_offers", "name": "has_offers"},

                { "data": "activated_at_datatable", "name": "activated_at_datatable"},
                { "data": "signed_agreement", "name": "signed_agreement"},
                { "data": "signed_at_datatable", "name": "signed_at_datatable"},
                { "data": "last_offer_at_datatable", "name": "last_offer_at_datatable"}
            ],
            "columnDefs": [
                {
                    "targets": [0,1,2,3,4,5,6],
                    "searchable": false,
                    "visible": true
                },
                {
                    "targets": [7,8,9,10,11,12,13],
                    "searchable": false,
                    "visible": false
                },
                {
                    className: "text-center",
                    "targets": [0,1,4,5]
                }
            ],
            "language": {
                "lengthMenu": "Ver _MENU_ por página",
                "zeroRecords": "Lo siento, no se enontraron medios",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay medios",
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
                    "<button class='btn btn-xs btn-success publisherModal' data-publisher='" + JSON.stringify(aData) + "' title='Ver Anunciante' data-toggle='modal' data-target='#publisherModal'><i class='fa fa-search-plus'></i></button>"
                );
                if(!aData.company || !aData.company.trim()) {
                    $('td:eq(2)', nRow).html('--');
                }
                $('td:eq(4)', nRow).html(
                    UserService.getHtmlTableStates(aData.states)
                );
                if(aData.count_spaces > 0){
                    $('td:eq(5)', nRow).html(
                        '<span class="badge badge-info">' + aData.count_spaces + '</span>'
                    );
                }
            },
            "drawCallback": function(settings, json) {
                $("#countDatatable").html(settings.fnRecordsDisplay());
                $('[data-toggle="tooltip"]').tooltip();
            },
        });

        UserService.initDatatable(table);
        UserService.initSimpleSearchSelect("#registration_states", 7);
        UserService.initSimpleSearchSelect('#with_spaces', 8);

        $("#publishers-datatable_filter input").unbind();

        $("#publishers-datatable_filter input").bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.search(this.value).draw();   
            }
        }); 
    }

    function initSearchAgreement() {
        var optionState = '';

        $('#signed_agreement').on('ifChecked', function(event){
            console.log('true');
            $('#agreement_at_start').prop('disabled', false);
            $('#agreement_at_end').prop('disabled', false);

            optionState = $('#registration_states').val();
            $('#registration_states option[value=complete-data]').prop('selected', true);
            $('#registration_states').prop('disabled', true);

            table.column(11)
                    .search('1')
                .column(7)
                    .search('complete-data')
                .draw();
        });

        $('#signed_agreement').on('ifUnchecked', function(event) {
            $('#agreement_at_start').prop('disabled', true);
            $('#agreement_at_end').prop('disabled', true);
            /*$("#agreement_at_start").datepicker("setDate", null);
            $("#agreement_at_end").datepicker("setDate", null); */


            if(optionState == '') {
                $('#registration_states :nth-child(1)').prop('selected', true);
            }
            else {
                $('#registration_states option[value=' + optionState + ']').prop('selected', true);    
            }

            $('#registration_states').prop('disabled', false);

            table.column(11)
                    .search('0')
                .column(7)
                    .search(optionState)
                .column(12)
                    .search(' , ')
                .draw();
        });
    }

    function initSearchOffers() {
        var optionState = '';

        $('#offer').on('ifChecked', function(event){
            console.log('ofertó');
            $('#offer_at_start').prop('disabled', false);
            $('#offer_at_end').prop('disabled', false);

            optionState = $('#registration_states').val();
            $('#registration_states option[value=complete-data]').prop('selected', true);
            $('#registration_states').prop('disabled', true);

            table.column(9)
                    .search('true')
                .column(7)
                    .search(optionState)
                .draw();
        });

        $('#offer').on('ifUnchecked', function(event){
            console.log('no ofertó');
            $('#offer_at_start').prop('disabled', true);
            $('#offer_at_end').prop('disabled', true);
            $("#offer_at_start").datepicker("setDate", null);
            $("#offer_at_end").datepicker("setDate", null);


            if(optionState == '') {
                $('#registration_states :nth-child(1)').prop('selected', true);
            }
            else {
                $('#registration_states option[value=' + optionState + ']').prop('selected', true);    
            }

            $('#registration_states').prop('disabled', false);

            table.column(9)
                    .search('')
                .column(7)
                    .search(optionState)
                .draw();
            
        });
    }        

    function initSearchDateRanges()
    {
        //UserService.initDrawDateRange('#created_at_start', '#created_at_end', 10);
        //UserService.initDrawDateRange('#agreement_at_start', '#agreement_at_end', 14);
        //UserService.initDrawDateRange('#offer_at_start', '#offer_at_end', 16);
    }

    function initModalEvent() {
        $(document).on("click", ".publisherModal", function () {
            var publisher = $(this).data('publisher');
            drawModal(publisher);
        });
    }

    function drawModal(publisher) {
        UserService.drawModalUser("publisherModal", publisher, "medios");
        /** Commercial state **/
        $('#publisherModal #by_contact').text(publisher.count_by_contact_intentions);
        $('#publisherModal #sold').text(publisher.count_sold_intentions);
        $('#publisherModal #discarded').text(publisher.count_discarded_intentions);

        /** Agreement **/
        $('#publisherModal #publisher_signed_agreement').text('(' + publisher.signed_agreement_lang + ')');
        $('#publisherModal #commission_rate').text(publisher.commission_rate);
        $('#publisherModal #signed_at').text(publisher.signed_at_datatable);
        $('#publisherModal #discount').text(publisher.discount);
        $('#publisherModal #retention').text(publisher.retention);

        /** Spaces **/
        $('#publisherModal a#link-spaces').attr('href', '/medios/' + publisher.id);
        $('#publisherModal #count-spaces').text('(' + publisher.count_spaces + ')');
        $('#publisherModal #created_at').text(publisher.created_at_humans);
    }

    function drawShowPrices() {
        var publisher = $("#publisher").data("publisher");
        $("#prueba").html(UserService.getHtmlModalStates(publisher.states, ''));

        var minimalPrices = $(".minimal-price");
        $.each(minimalPrices, function( index, div ) {
          $(this).text(numeral($(this).data('price')).format('$0,0[.]00'));
        });

        var markupPrices = $(".markup-price");
        $.each(markupPrices, function( index, div ) {
          $(this).text(numeral($(this).data('price')).format('$0,0[.]00'));
        });

        var publicPrices = $(".public-price");
        $.each(publicPrices, function( index, div ) {
          $(this).text(numeral($(this).data('price')).format('$0,0[.]00'));
        });

        var markupPers = $(".markup-per");
        $.each(markupPers, function( index, div ) {
          $(this).text(numeral($(this).data('per')).format('0%'));
        });
    };

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
            UserService.initInputsDateRange();
            initSearchDateRanges();
            initModalEvent();
            initSearchAgreement();
            initSearchOffers();
        },
        drawShowPrices: function() {
            drawShowPrices();
        }
    };
}();