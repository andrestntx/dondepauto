/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var AdvertiserService = function() {

    var table;
    var urlSearch;

    function initTable(urlSearch) {
        urlSearch = urlSearch;

        table = $('#advertisers-datatable').DataTable({
            "order": [[1, "desc"]],
            "ajax": urlSearch,
            "deferRender": true,
            "columns": [
                { "data": null, "orderable": false },
                { "data": "created_at"},
                { "data": "company" },
                { "data": "city_name" },
                { "data": "name" },
                { "data": "email" },
                { "data": "phone"},
                { "data": "cel"},
                { "data": "state" },
                { "data": "count_by_contact_intentions" },
                { "data": "state_id"},
                { "data": "city_id" },
                { "data": "address"},
                { "data": "economic_activity_id"},
                { "data": "created_at_datatable"},
                { "data": "last_log_login_at_datatable"},
                { "data": "activated_at_datatable"}
            ],
            "columnDefs": [
                {
                    "targets": [6,7,10,11,12,13,14,15,16],
                    "visible": false,
                    "searchable": true
                },
                {
                    className: "text-center",
                    "targets": [0,8,9]
                },
                {
                    className: "text-small",
                    "targets": [1,2,3,4,5]
                }
            ],
            "language": {
                "lengthMenu": "Ver _MENU_ por página",
                "zeroRecords": "Lo siento, no se enontraron anunciantes",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay anunciantes",
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
                    "<button class='btn btn-xs btn-success advertiserModal' data-advertiser='" + JSON.stringify(aData) + "' title='Ver Anunciante' data-toggle='modal' data-target='#advertiserModal'><i class='fa fa-search-plus'></i></button>"
                );

                $('td:eq(1)', nRow).html(aData.created_at.substring(0,10));

                if(!aData.company.trim()) {
                    $('td:eq(2)', nRow).html('--');
                }
                if(!aData.city_name) {
                    $('td:eq(3)', nRow).html('--');
                }
                $('td:eq(6)', nRow).html(
                    UserService.getHtmlTableStates(aData.states, 120)
                );
                if(aData.count_intentions > 0){
                    $('td:eq(7)', nRow).html(
                        getHtmlIntentionStates(aData)
                    );
                }
            },
            "drawCallback": function(settings, json) {
                $("#countDatatable").html(settings.fnRecordsDisplay());
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        UserService.initDatatable(table);
        UserService.initSimpleSearchSelect("#registration_states",10);
        UserService.initExactSearchSelect('#cities', 11);
        UserService.initExactSearchSelect("#economic_activities", 113);
    }
    
    function initModalEvent() {
        $(document).on("click", ".advertiserModal", function () {
            var advertiser = $(this).data('advertiser');
            drawModal(advertiser);
        });
    }

    function getHtmlIntentionStates(aData) {
        var html        = $('<div style="width:70px;"></div>').addClass('text-center');
        var interest    = $('<span style="margin: 0 1px;"></span>')
                            .addClass('badge badge-default')
                            .text(aData.count_interest_intentions)
                            .attr('data-toggle', 'tooltip')
                            .attr('data-placement', 'top')
                            .attr('title', 'Intereses');

        var by_contact  = $('<span style="margin: 0 1px;"></span>')
                            .addClass('badge badge-warning')
                            .text(aData.count_by_contact_intentions)
                            .attr('data-toggle', 'tooltip')
                            .attr('data-placement', 'top')
                            .attr('title', 'Leads por contactar');

        var management  = $('<span style="margin: 0 1px;"></span>')
                            .addClass('badge badge-info')
                            .text(aData.count_management_intentions)
                            .attr('data-toggle', 'tooltip')
                            .attr('data-placement', 'top')
                            .attr('title', 'Leads en gestión');

        html.append(interest)
            .append(by_contact)
            .append(management);        

        return html;
    }

    function drawModal(advertiser) {
        UserService.drawModalUser("advertiserModal", advertiser, "anunciantes");
        /** Commercial state **/
        $('#advertiserModal #count_intentions').text(advertiser.count_intentions);
        $('#advertiserModal #count_leads').text(advertiser.count_leads);
        $('#advertiserModal #interest').text(advertiser.count_interest_intentions);
        $('#advertiserModal #by_contact').text(advertiser.count_by_contact_intentions);
        $('#advertiserModal #management').text(advertiser.count_management_intentions);
        $('#advertiserModal #sold').text(advertiser.count_sold_intentions);
        $('#advertiserModal #discarded').text(advertiser.count_discarded_intentions);

        var intention_at_start = $('#intention_at_start').val();
        var intention_at_end = $('#intention_at_end').val();

        if(intention_at_start || intention_at_end) {
            $('#advertiserModal #lead_dates').text(' | De ' + intention_at_start + ' a ' + intention_at_end);  
        }
        else {
            $('#advertiserModal #lead_dates').text(' ');  
        }

        /** Proposals **/
        $('#advertiserModal a#link-proposals').attr('href', '/anunciantes/' + advertiser.id);
        $('#advertiserModal #count-proposals').text('(' + advertiser.count_proposals + ')');
        $('#advertiserModal #created_at').text(advertiser.created_at_humans);
    }

    function initReloadAjaxDate(inputInit, inputFinish, parameterInit, parameterFinish) {
        $(inputInit + ', ' + inputFinish).on('change', function() {
            console.log('/anunciantes/search?' + parameterInit + '=' + $(inputInit).val() + '&' + parameterFinish + '=' + $(inputFinish).val());
            table.ajax
                .url('/anunciantes/search?' + parameterInit + '=' + $(inputInit).val() + '&' + parameterFinish + '=' + $(inputFinish).val())
                .load();
        } );               
    }

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
            UserService.initInputsDateRange();
            UserService.initSearchDateRanges(13,14,15);
            initModalEvent();
            initReloadAjaxDate('#intention_at_start', '#intention_at_end', 'init', 'finish');
        }
    };
}();