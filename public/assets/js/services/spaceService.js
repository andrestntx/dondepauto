/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var SpaceService = function() {

    var table;
    var urlSearch;

    function initTable(urlSearch) {
        urlSearch = urlSearch;

        table = $('#spaces-datatable').DataTable({
            "order": [[1, "desc"]],
            "ajax": urlSearch,
            "deferRender": true,
            "columns": [
                { "data": null, "orderable": false },
                { "data": "publisher_company" },
                { "data": "name" },
                { "data": "category_name" },
                { "data": "sub_category_name" },
                { "data": "format_name" },
                { "data": "commission" },
                { "data": "minimal_price" },
                { "data": "percentage_markdown" },
                { "data": "markup_price" },
                { "data": "public_price" },
                { "data": "category_id" }, // 12
                { "data": "sub_category_id" },
                { "data": "format_id" },
                { "data": "publisher_id" },
                { "data": "city_id" },
                { "data": "tags" },
                { "data": "description" },
                { "data": "address" },
                { "data": "impact_scene_id" }
            ],
            "columnDefs": [
                {
                    "targets": [11,12,13,14,15,16,17,18,19],
                    "visible": false,
                    "searchable": true
                },
                {
                    className: "text-center",
                    "targets": [0,6,7,8,9,10]
                }
            ],
            "language": {
                "lengthMenu": "Ver _MENU_ por página",
                "zeroRecords": "Lo siento, no se enontraron espacios",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay espacios",
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
                    "<button class='btn btn-xs btn-success spaceModal' data-space='" + JSON.stringify(aData) + "' title='Ver Anunciante' data-toggle='modal' data-target='#spaceModal'><i class='fa fa-plus'></i></button>"
                );

                $('td:eq(6)', nRow).html(
                    numeral(aData.commission).format('0%')
                );

                $('td:eq(7)', nRow).html(
                    numeral(aData.minimal_price).format('$ 0,0[.]00')
                );

                $('td:eq(8)', nRow).html(
                    numeral(aData.percentage_markdown).format('0%')
                );

                $('td:eq(9)', nRow).html(
                    numeral(aData.markup_price).format('$ 0,0[.]00')
                );

                $('td:eq(10)', nRow).html(
                    numeral(aData.public_price).format('$ 0,0[.]00')
                );
            },
            "drawCallback": function(settings, json) {
                $("#countDatatable").html(settings.fnRecordsDisplay());
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        UserService.initDatatable(table);
        UserService.initSimpleSearchSelect("#categories",11);
        UserService.initSimpleSearchSelect("#sub_categories",12);
        UserService.initSimpleSearchSelect("#formats",13);
        UserService.initSimpleSearchSelect("#publishers",14);
        UserService.initSimpleSearchSelect("#cities",15);
        UserService.initSimpleSearchSelect("#scenes",19);
        /*UserService.initExactSearchSelect('#cities', 10);
        UserService.initExactSearchSelect("#economic_activities", 12);*/
    }

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
        }
    };
}();