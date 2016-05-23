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
                { "data": "impact_scene_id" },
                { "data": "publisher_email" }
            ],
            "columnDefs": [
                {
                    "targets": [11,12,13,14,15,16,17,18,19,20],
                    "visible": false,
                    "searchable": true
                },
                {
                    className: "text-center text-small",
                    "targets": [0,6,7,8,9,10]
                },
                {
                    className: "text-small",
                    "targets": [1,2,3,4,5]
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
                    "<button class='btn btn-xs btn-success spaceModal' data-space='" + JSON.stringify(aData) + "' title='Ver Espacio' data-toggle='modal' data-target='#spaceModal'><i class='fa fa-search-plus'></i></button>"
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
    };

    function initFilters() {
        UserService.initSimpleSearchSelect("#categories",11);
        UserService.initSimpleSearchSelect("#sub_categories",12);
        UserService.initSimpleSearchSelect("#formats",13);
        UserService.initSimpleSearchSelect("#publishers",14);
        UserService.initSimpleSearchSelect("#cities",15);
        UserService.initSimpleSearchSelect("#scenes",19);
    };

    function initModalEvent() {
        $(document).on("click", ".spaceModal", function () {
            var space = $(this).data('space');
            drawModal("spaceModal", space, "espacios");
        });

        // Add slimscroll to element
        $('.scroll_content').slimscroll({
            height: '100px'
        });
        $('.scroll_content_image').slimscroll({
            height: '160px'
        });
    }

    function drawModal(inputId, space, urlName) {
        //$("#prueba").html(UserService.getHtmlModalStates(space.states, ''));
        $('#' + inputId + ' #modalEdit').attr('href', '/' + urlName + '/' + space.id + '/edit');
        $('#' + inputId + ' #modalPublisher').attr('href', '/medios/' + space.publisher_id)
            .attr('title', 'Ver Medio - ' + space.publisher_name);

        /** Space Data **/
        $('#' + inputId +' #space_name').text(space.name);
        $('#' + inputId + ' a#publisher_company').attr('href', '/medios/' + space.publisher_id).text(space.publisher_company);

        /** Publisher Personal Data **/
        $('#' + inputId + ' #publisher_name').text(space.publisher_name);
        $('#' + inputId + ' #publisher_email a').attr('href', 'mailto:' + space.publisher_email).text(space.publisher_email);
        $('#' + inputId + ' a#publisher_phone').attr('href', 'tel:' + space.publisher_phone).text(space.publisher_phone);
        $('#' + inputId + ' a#publisher_cel').attr('href', 'tel:' + space.publisher_cel).text(space.publisher_cel);

        /** Data Detail **/
        $('#' + inputId + ' #created_at').text(space.created_at_humans);
        $('#' + inputId + ' #publisher_economic_activity').text(space.publisher_economic_activity_name);
        $('#' + inputId + ' #publisher_address').text(space.publisher_address);
        $('#' + inputId + ' #publisher_company_nit').text(space.publisher_company_nit);
        $('#' + inputId + ' #publisher_company_role').text(space.publisher_company_role);
        $('#' + inputId + ' #publisher_company_area').text(space.publisher_company_area);

        /** Agreement **/
        $('#' + inputId + ' #publisher_signed_agreement').text('(' + space.publisher_signed_agreement_lang + ')');
        $('#' + inputId + ' #publisher_commission_rate').text(space.publisher_commission_rate);
        $('#' + inputId + ' #publisher_signed_at').text(space.publisher_signed_at_datatable);
        $('#' + inputId + ' #publisher_discount').text(space.publisher_discount);
        $('#' + inputId + ' #publisher_retention').text(space.publisher_retention);

        /** Space Segment **/
        $('#' + inputId + ' #category_name').text(space.category_name);
        $('#' + inputId + ' #sub_category_name').text(space.sub_category_name);
        $('#' + inputId + ' #format_name').text(space.format_name);
        $('#' + inputId + ' #city_name').text(space.city_name);
        $('#' + inputId + ' #impact_scene_name').text(space.impact_scene_name);
        $('#' + inputId + ' #address').text(space.address);

        /** Prices **/   
        $('#' + inputId + ' #minimal_price').text(numeral(space.minimal_price).format('$ 0,0[.]00'));
        $('#' + inputId + ' #markup').text(numeral(space.percentage_markdown).format('0%'));
        $('#' + inputId + ' #markup_price').text(numeral(space.markup_price).format('$ 0,0[.]00'));
        $('#' + inputId + ' #public_price').text(numeral(space.public_price).format('$ 0,0[.]00'));
        $('#' + inputId + ' #period').text(space.period);

        /** Description **/
        $('#' + inputId + ' #space-description').html(space.description);

        /** Images **/
        var divImages = $('#' + inputId + ' #space-images');
        divImages.html('');
        $.each(space.images, function( index, image ) {
          var img = $("<img style='width:100px; margin:5px;'></img>").attr('src', image.thumb);
          divImages.append(img);
        });

        /** Comments **/
        $('#' + inputId +' #comments').text(space.comments);

        /** State **/
        $('#' + inputId +' #state')
            .removeClass()
            .addClass('btn btn-circle btn-' + space.state_class)
            .attr('data-original-title', space.state);

        $('#' + inputId +' #state i')
            .removeClass()
            .addClass('fa ' + space.state_icon);
    };

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
            initFilters();
            initModalEvent();
        },
        initModalEvent: function () {
            initModalEvent();
        },
        initDatatable: function(urlSearch) {
            initTable(urlSearch); 
        }
    };
}();