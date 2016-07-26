/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var InventaryService = function() {

    var table;

    function initTable(urlSearch) {
        table = $('#inventary-datatable').DataTable({
            "pagingType": "simple_numbers",
            "order": [[1, "desc"]],
            'info': true,
            //"ajax": urlSearch,
            "deferRender": true,
            "processing": false,
            "serverSide": false,
            /*"columns": [
                
            ],
            "columnDefs": [
                
            ],*/
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
                
            },
            "drawCallback": function(settings, json) {
               // $("#countDatatable").html(settings.fnRecordsDisplay());
                $('[data-toggle="tooltip"]').tooltip();
            },
        });

        $('#myInputTextField').keyup(function() {
              table.search($(this).val()).draw() ;
        })
    }

 
    return {
        init: function(urlSearch) {
            initTable(urlSearch);
        },
        drawShowPrices: function() {
            drawShowPrices();
        }
    };
}();