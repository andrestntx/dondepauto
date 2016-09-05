/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var PublisherService = function() {

    var table;
    var switchery;
    var switcheryClass = ".js-switch";

    function initTable(urlSearch) {
        table = $('#publishers-datatable').DataTable({
            "order": [[1, "desc"]],
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
                { "data": "count_logs" , "name": "count_logs" },
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
                    "targets": [0,1,2,3,4,5,6,7],
                    "searchable": false,
                    "visible": true
                },
                {
                    "targets": [8,9,10,11,12,13,14],
                    "searchable": false,
                    "visible": false
                },
                {
                    className: "text-center",
                    "targets": [0,1,4,5,6]
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
                    UserService.getHtmlTableStates(aData.states, '170')
                );

                if(aData.count_spaces > 0){
                    $('td:eq(5)', nRow).html(
                        '<span class="badge badge-info">' + aData.count_spaces + '</span>'
                    );
                }

                if(aData.count_logs > 0) {
                    $('td:eq(6)', nRow).html(UserService.getHtmlLogs(aData.last_login_at));                    
                }

                if(aData.contacts && aData.contacts.length > 0) {
                    div = UserService.getLastContact(aData.contacts);
                    $('td:eq(7)', nRow).html(div.html());
                }
            },
            "drawCallback": function(settings, json) {
                $("#countDatatable").html(settings.fnRecordsDisplay());
                $('[data-toggle="tooltip"]').tooltip();
            },
        });

        UserService.initDatatable(table);
        UserService.initSimpleSearchSelect("#registration_states", 8);
        UserService.initSimpleSearchSelect('#with_spaces', 9);

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
            $('#agreement_at_start').prop('disabled', false);
            $('#agreement_at_end').prop('disabled', false);

            optionState = $('#registration_states').val();
            $('#registration_states option[value=complete-data]').prop('selected', true);
            $('#registration_states').prop('disabled', true);

            table.column(14)
                    .search('1')
                .column(8)
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

            table.column(12)
                    .search('0')
                .column(8)
                    .search(optionState)
                .column(13)
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

            table.column(10)
                    .search('true')
                .column(8)
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

            table.column(10)
                    .search('')
                .column(8)
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

        $('#delete_publisher').attr("data-url", '/medios/' + publisher.id);

        /** Agreement **/
        console.log('signed: ' + publisher.signed_agreement);

        var input = null;

        if(publisher.signed_agreement == 1) {
            var input = $("<input checked></input>");
            input.attr("checked", true);

            $("#link-documents").prop('disabled', false);
            console.log('si');
        }
        else {
            var input = $("<input></input>");
            $("#link-documents").prop('disabled', true);
            input.attr("checked", false);

            console.log('no');
        }

        console.log(input);


        input.attr("type", "checkbox")
            .addClass("js-switch js-switch-click")
            .data("url", "/medios/" + publisher.id + "/agreement");

        $('#publisherModal #publisher_sw_agreement').html("").append(input);

        var elem = document.querySelector(switcheryClass);
        switchery = new Switchery(elem, { 
            color: '#1AB394',
            size: 'small'
        });

        //$('#publisherModal #publisher_signed_agreement').text('(' + publisher.signed_agreement_lang + ')');
        $('#publisherModal #commission_rate').text(publisher.commission_rate);
        $('#publisherModal #signed_at').text(publisher.signed_at_datatable);
        $('#publisherModal #discount').text(publisher.discount);
        $('#publisherModal #retention').text(publisher.retention);

        /** Spaces **/
        $('#publisherModal a#link-spaces').attr('href', '/medios/' + publisher.id);
        $('#publisherModal #count-spaces').text('(' + publisher.count_spaces + ')');
        $('#publisherModal #created_at').text(publisher.created_at_humans);

        var linkDocuments = '/medios/' + publisher.id + '/acuerdo/completar';
        $('#link-documents').attr('href', linkDocuments);

        var documents = $.parseJSON(publisher.documents_json);

        $('#publisherModal #file-documents').html('');
        $.each( documents, function( key, document ) {
            var i = $('<i></i>').addClass('fa fa-file-pdf-o');
            var a = $('<a></a>')
                .attr('href', document.url)
                .attr('target', '_blank')
                .append(i)
                .append(' ' + document.name);

            var li = $('<li style="font-size:12px;"></li>').append(a);

            $('#publisherModal #file-documents').append(li);
        });

        initChangeAgreement();

        /** Contacts **/
        $('#publisherModal #newContact').attr('data-url', '/anunciantes/' + publisher.id + '/contacts');

        $('#publisherModal #comments').html('');

        $.each(publisher.contacts, function( index, contact ) {
            var socialContact = UserService.getSocialContact(contact);
            $('#publisherModal #comments').append(socialContact);
        });
    }

    function drawShowPrices() {
        var publisher = $("#publisher").data("publisher");
        var states = $("#publisher").data("states");

        console.log(states);

        $("#prueba").html(UserService.getHtmlTableStates(states, '290'));

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
    }

    function initDeletePublisher() {
        console.log('inicio');

        $("#delete_publisher").click(function(e) {   
            swal({
                title: '¿Estás seguro?',
                text: 'El medio será eliminado',
                type: "warning",
                confirmButtonText: "Eliminar",
                confirmButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                html: true
            },
            function(isConfirm) {
                if (isConfirm) {     
                    $.ajax({
                        url: $("#delete_publisher").attr('data-url'),
                        type: 'DELETE',
                        success: function(data) {
                            if(data.success) {
                                swal({
                                    "title": "Medio eliminado", 
                                    "type": "success",
                                    closeOnConfirm: true,
                                });

                                table.search(' ').draw();
                                $('#publisherModal').modal('toggle');
                            }
                            else {
                                swal({
                                    "title": "Hubo un error", 
                                    "type": "warning",
                                    closeOnConfirm: true,
                                });
                            }
                        }
                    });
                }
                else {

                } 
            });
        });
    };

    function initChangeAgreement() {
        var manual = false;
        var changeCheckbox = document.querySelector('.js-switch-click');

        changeCheckbox.onchange = function(e) {   
            if(! manual) {
                swal({
                    title: '¿Estás seguro?',
                    text: 'El acuerdo será modificado',
                    type: "warning",
                    confirmButtonText: "Confirmar",
                    confirmButtonColor: "#FFAC1A",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    html: true
                },
                function(isConfirm) {
                    if (isConfirm) {     
                        
                        var parameters = {"agreement": "0"};
                        var removeClass = "btn-primary";
                        var addClass = "btn-danger";
                        
                        if(changeCheckbox.checked) {
                            parameters = {"agreement": "1"};
                            removeClass = "btn-danger";
                            addClass = "btn-primary";
                        }

                        console.log(parameters); 
                        
                        $.post($("#publisher_sw_agreement input").data('url'), parameters, function( data ) {
                            if(data.success) {
                                console.log('bien');
                                $("#publisherModal .fa.fa-file-text-o").parent().removeClass(removeClass).addClass(addClass);
                                swal("Acuerdo actualizado", "", "success");
                            }
                            else{
                                console.log('mal');
                                manual = true;
                                changeCheckbox.click();
                                manual = false;
                                swal("Hubo un error", "", "danger");
                            }
                        });
                    } 
                    else { 
                        manual = true;
                        changeCheckbox.click();
                        manual = false;
                    } 
                });
            } 
        };
    }

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
            UserService.initInputsDateRange();
            initSearchDateRanges();
            initModalEvent();
            initSearchAgreement();
            initSearchOffers();
            initDeletePublisher();
        },
        drawShowPrices: function() {
            drawShowPrices();
        },
        getSocialContact: function(contact) {
            return UserService.getSocialContact(contact);
        },
        reload: function() {
            table.search(UserService.getFilterSearch()).draw();
        }
    };
}();