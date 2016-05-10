/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var AdvertiserService = function() {

    var table;
    var urlSearch;

    function initTable(urlSearch) {
        urlSearch = urlSearch;

        table = $('#spaces-datatable').DataTable({
            "order": [[6, "desc"]],
            "ajax": urlSearch,
            "deferRender": true,
            "columns": [
                { "data": null, "orderable": false },
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
                    "targets": [5,6,9,10,11,12,13,14,15],
                    "visible": false,
                    "searchable": true
                },
                {
                    className: "text-center",
                    "targets": [0,7,8]
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
                    "<button class='btn btn-xs btn-success advertiserModal' data-advertiser='" + JSON.stringify(aData) + "' title='Ver Anunciante' data-toggle='modal' data-target='#advertiserModal'><i class='fa fa-plus'></i></button>"
                );
                if(!aData.company.trim()) {
                    $('td:eq(1)', nRow).html('--');
                }
                if(!aData.city_name) {
                    $('td:eq(2)', nRow).html('--');
                }
                $('td:eq(5)', nRow).html(
                    UserService.getHtmlTableStates(aData.states)
                );
                if(aData.count_intentions > 0){
                    $('td:eq(6)', nRow).html(
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
        /*UserService.initSimpleSearchSelect("#registration_states",9);
        UserService.initExactSearchSelect('#cities', 10);
        UserService.initExactSearchSelect("#economic_activities", 12);*/
    }

    return {
        init: function(urlSearch) {
            initTable(urlSearch);;
        }
    };
}();