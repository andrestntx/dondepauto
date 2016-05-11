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
            "columns": [
                { "data": null, "orderable": false },
                { "data": "company" },
                { "data": "name" },
                { "data": "email" },
                { "data": "phone"},
                { "data": "cel"},
                { "data": "state" },
                { "data": "count_spaces" },
                { "data": "state_id"},
                { "data": "address"},
                { "data": "created_at_datatable"},
                { "data": "last_log_login_at_datatable"},
                { "data": "space_city_names"},
                { "data": "activated_at_datatable"},
                { "data": "signed_agreement"},
                { "data": "signed_at_datatable"},
                { "data": "has_offers"},
                { "data": "last_offer_at_datatable"}
            ],
            "columnDefs": [
                {
                    "targets": [4,5,8,9,10,11,12,13,14,15,16,17],
                    "visible": false,
                    "searchable": true
                },
                {
                    className: "text-center",
                    "targets": [0,6,7]
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
                    "<button class='btn btn-xs btn-success publisherModal' data-publisher='" + JSON.stringify(aData) + "' title='Ver Anunciante' data-toggle='modal' data-target='#publisherModal'><i class='fa fa-plus'></i></button>"
                );
                if(!aData.company || !aData.company.trim()) {
                    $('td:eq(1)', nRow).html('--');
                }
                $('td:eq(4)', nRow).html(
                    UserService.getHtmlTableStates(aData.states)
                );
                if(aData.count_spaces > 0){
                    $('td:eq(5)', nRow).html(
                        '<span class="badge badge-warning">' + aData.count_spaces + '</span>'
                    );
                }
            },
            "drawCallback": function(settings, json) {
                $("#countDatatable").html(settings.fnRecordsDisplay());
                $('[data-toggle="tooltip"]').tooltip();
            },
        });

        UserService.initDatatable(table);
        UserService.initSimpleSearchSelect("#registration_states",8);
        UserService.initSimpleSearchSelect('#with_spaces', 12);
    }

    function initSearchAgreement() {
        var optionState = '';

        $('#signed_agreement').on('ifChecked', function(event){
            $('#agreement_at_start').prop('disabled', false);
            $('#agreement_at_end').prop('disabled', false);

            table.column(14)
                .search('true')
                .draw();

            optionState = $('#registration_states').val();
            $('#registration_states option[value=complete-data]').prop('selected', true);
            $('#registration_states').prop('disabled', true);
        });

        $('#signed_agreement').on('ifUnchecked', function(event){
            $('#agreement_at_start').prop('disabled', true);
            $('#agreement_at_end').prop('disabled', true);
            $("#agreement_at_start").datepicker("setDate", null);
            $("#agreement_at_end").datepicker("setDate", null);

            table.column(14)
                .search('')
                .draw();

            if(optionState == '') {
                $('#registration_states :nth-child(1)').prop('selected', true);
            }
            else {
                $('#registration_states option[value=' + optionState + ']').prop('selected', true);    
            }

            $('#registration_states').prop('disabled', false);
            
        });
    }

    function initSearchOffers() {
        var optionState = '';

        $('#offer').on('ifChecked', function(event){
            $('#offer_at_start').prop('disabled', false);
            $('#offer_at_end').prop('disabled', false);

            table.column(16)
                .search('true')
                .draw();

            optionState = $('#registration_states').val();
            $('#registration_states option[value=complete-data]').prop('selected', true);
            $('#registration_states').prop('disabled', true);
        });

        $('#offer').on('ifUnchecked', function(event){
            $('#offer_at_start').prop('disabled', true);
            $('#offer_at_end').prop('disabled', true);
            $("#offer_at_start").datepicker("setDate", null);
            $("#offer_at_end").datepicker("setDate", null);

            table.column(16)
                .search('')
                .draw();

            if(optionState == '') {
                $('#registration_states :nth-child(1)').prop('selected', true);
            }
            else {
                $('#registration_states option[value=' + optionState + ']').prop('selected', true);    
            }

            $('#registration_states').prop('disabled', false);
            
        });
    }        

    function initSearchDateRanges()
    {
        UserService.initDrawDateRange('#created_at_start', '#created_at_end');
        UserService.initDrawDateRange('#agreement_at_start', '#agreemet_at_end');
        UserService.initDrawDateRange('#offer_at_start', '#offer_at_end');

        $.fn.dataTableExt.afnFiltering.push(
            function( oSettings, aData, iDataIndex) {
                return UserService.searchDateRange(aData, '#created_at_start', '#created_at_end', 10) &&
                        UserService.searchDateRange(aData, '#agreement_at_start', '#agreement_at_end', 15) &&
                        UserService.searchDateRange(aData, '#offer_at_start', '#offer_at_end', 17);
            }
        );
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
        $('#publisherModal #signed_agreement').text(publisher.signed_agreement_lang);
        $('#publisherModal #commission_rate').text(publisher.commission_rate);
        $('#publisherModal #signed_at').text(publisher.signed_at);
        $('#publisherModal #discount').text(publisher.discount);
        $('#publisherModal #retention').text(publisher.retention);
    }

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
            UserService.initInputsDateRange();
            initSearchDateRanges();
            initModalEvent();
            initSearchAgreement();
            initSearchOffers();
        }
    };
}();