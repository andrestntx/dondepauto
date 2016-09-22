/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var QuoteService = function() {

    var table;
    var urlSearch;

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
            ],
            "columnDefs": [
                {
                    "targets": [1,2,3,4,5,6],
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
                    "<button class='btn btn-xs btn-success quoteModal' data-quote='" + JSON.stringify(aData) + "' title='Ver Propuesta' data-toggle='modal' data-target='#quoteModal'><i class='fa fa-search-plus'></i></button>"
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

    function getFilterSearch()
    {
        return $(".dataTables_filter input").val();
    };

    function reload()
    {
        table.search(getFilterSearch()).draw();
    };

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
        },
        reload: function(){
            reload();
        }
    };
}();