/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var PublisherService = function() {

    var table;
    var switchery;
    var switcheryClass = ".js-switch";
    var publisherEdit;

    function initTable(urlSearch) {
        table = $('#publishers-datatable').DataTable({
            "order": [[1, "desc"]],
            'info': true,
            "ajax": urlSearch,
            "pageLength": 50,
            "deferRender": true,
            "processing": true,
            "serverSide": true,
            "columns": [
                { "data": null, "name": "company", "orderable": false },
                { "data": "created_at_datatable", "name": "created_at_datatable"}, // 1
                { "data": "company" , "name": "company" },
                { "data": "first_name" , "name": "first_name" },
                { "data": "state" , "name": "state" },
                { "data": "count_spaces" , "name": "count_spaces" },
                { "data": "count_logs" , "name": "count_logs" },
                { "data": "comments" , "name": "comments" }, // 7

                { "data": "state_id", "name": "state_id"},
                { "data": "space_city_names", "name": "space_city_names"},
                { "data": "has_offers", "name": "has_offers"}, // 10

                { "data": "activated_at_datatable", "name": "activated_at_datatable"}, // 11
                { "data": "signed_agreement", "name": "signed_agreement"}, // 12
                { "data": "signed_at_datatable", "name": "signed_at_datatable"}, // 13
                { "data": "last_offer_at_datatable", "name": "last_offer_at_datatable"}, // 14

                { "data": null, "name": "action"},
                { "data": null, "name": "action_range"}, // 16

                { "data": "has_logo", "name": "has_logo"}, // 17
                { "data": "tag_id", "name": "tag_id"} // 18
            ],
            "columnDefs": [
                {
                    "targets": [0,1,2,3,4,5,6,7],
                    "searchable": false,
                    "visible": true
                },
                {
                    "targets": [8,9,10,11,12,13,14,15,16,17,18],
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
                    "<button class='btn btn-xs btn-success publisherModal' data-publisher='" + JSON.stringify(aData) + "' title='Ver Anunciante' data-toggle='modal' data-target='#userModal'><i class='fa fa-search-plus'></i></button>"
                );

                if(!aData.company || !aData.company.trim()) {
                    $('td:eq(2)', nRow).html('--');
                } else {
                    $('td:eq(2)', nRow).attr('style', 'font-weight: bold; min-width: 170px;');
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
                    $('td:eq(6)', nRow).html(UserService.getHtmlLogs(aData.count_logs, aData.last_login_at));                    
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

        UserService.initDatatable(table, true);
        UserService.initSimpleSearchSelect("#registration_states", 8);
        UserService.initSimpleSearchSelect('#with_spaces', 9);
        UserService.initActions(15);
        UserService.initActionsRange(16);
        UserService.initSimpleSearchSelect('#has_logo', 17);
        UserService.initSimpleSearchSelect('#tag_id', 18);

        $("#publishers-datatable_filter input").unbind();

        $("#publishers-datatable_filter input").bind('keyup', function(e) {
            if(e.keyCode == 13) {
                table.search(this.value).draw();   
            }
        }); 
    }

    function reload() {
        table.search(UserService.getFilterSearch());
        table.draw();
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

        $(".userEditDataAgreementModal #form-edit-data-agreement").click(function() {            
            UserService.postModal(
                $(".userEditDataAgreementModal #user_company").attr('data-url'), {
                    'signed_at':        $(".userEditDataAgreementModal #signed_at").val(),
                    'commission_rate':  $(".userEditDataAgreementModal #commission_rate").val(),
                    'retention':        $(".userEditDataAgreementModal #retention").val(),
                    'discount':         $(".userEditDataAgreementModal #discount").val(),
                    'bank_name':        $(".userEditDataAgreementModal #bank_name").val(),
                    'bank_account':     $(".userEditDataAgreementModal #bank_account").val()
                }, $(".userEditDataAgreementModal"), true
            );
        });

        $("#change-documents").click(function() {
            swal({
                title: '¿Estás seguro?',
                text: 'El medio podrá editar los datos',
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
                                $('#userModal').modal('toggle');
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
    }

    function drawModal(publisher) {
        publisherEdit = publisher;
        UserService.drawModalUser("userModal", publisherEdit, "medios", true);

        $("#edit-data-agreement").click(function(){
            drawModalEditAgreement(publisherEdit, '/medios/' + publisher.id + '/ajax');
        });

        var documents = $.parseJSON(publisher.documents_json);
        $('#userModal #publisher_logo').html('');

        /** Logo */
        if(publisherEdit.has_logo) {

            var a = $("<img src='' />")
                .attr('src', publisherEdit.logo)
                .attr('style', 'max-height: 20px; margin-left: 10px;');

            $('#userModal #publisher_logo').html(a);    
        }

        /** Commercial state **/
        $('#userModal #by_contact').text(publisher.count_by_contact_intentions);
        $('#userModal #sold').text(publisher.count_sold_intentions);
        $('#userModal #discarded').text(publisher.count_discarded_intentions);

        $('#delete_publisher').attr("data-url", '/medios/' + publisher.id);

        /** Agreement **/
        var input = null;

        if(publisher.signed_agreement == 1) {
            var input = $("<input checked></input>");
            input.attr("checked", true);

            $("#change-documents").prop('disabled', false);
        }
        else {
            var input = $("<input></input>");
            $("#change-documents").prop('disabled', true);
            input.attr("checked", false);
        }

        input.attr("type", "checkbox")
            .addClass("js-switch js-switch-click")
            .attr("data-url", "/medios/" + publisher.id + "/agreement");

        $('#userModal #publisher_sw_agreement').html("").append(input);

        /** change Documents */
        $('#userModal #publisher_sw_documents').html("");

        if(documents.bank != null || documents.commerce != null || documents.bank != null) {
            
            var inputDocuments = null;

            if(publisher.change_documents == 1) {
                var inputDocuments = $("<input checked></input>");
                inputDocuments.attr("checked", true);

                //$("#change-documents").prop('disabled', false);
            }
            else {
                var inputDocuments = $("<input></input>");
                //$("#change-documents").prop('disabled', true);
                inputDocuments.attr("checked", false);
            }

            inputDocuments.attr("type", "checkbox")
                .addClass("js-switch js-switch-click")
                .attr("data-url", "/medios/" + publisher.id + "/change-documents");
                
            $('#userModal #publisher_sw_documents').append(inputDocuments);
        }
        

        var elems = Array.prototype.slice.call(document.querySelectorAll(switcheryClass));

        elems.forEach(function(html) {
            var switchery = new Switchery(html, { 
                color: '#1AB394',
                size: 'small'
            });
        });

        $('#userModal #publisher_sw_documents .switchery')
            .attr('data-toggle', 'tooltip')
            .attr('data-placement', 'top')
            .attr('title', 'Habilitar cambio de documentos');

        //$('#userModal #publisher_signed_agreement').text('(' + publisher.signed_agreement_lang + ')');
        UserService.drawAgreementData("userModal", publisherEdit);

        /** Spaces **/
        $('#userModal a#link-spaces').attr('href', '/medios/' + publisherEdit.id);
        $('#userModal #count-spaces').text('(' + publisherEdit.count_spaces + ')');
        $('#userModal #created_at').text(publisherEdit.created_at_humans);

        var linkDocuments = '/medios/' + publisherEdit.id + '/acuerdo/completar';
        $('#link-documents').attr('href', linkDocuments);

        $('#userModal #file-documents').html('');
        $.each( documents, function( key, document ) {
            var i = $('<i></i>').addClass('fa fa-file-pdf-o');
            var a = $('<a></a>')
                .attr('href', document.url)
                .attr('target', '_blank')
                .append(i)
                .append(' ' + document.name);

            var li = $('<li style="font-size:12px;"></li>').append(a);

            $('#userModal #file-documents').append(li);
        });

        initChangeAgreement();
        initChangeDocuments();

        /** Contacts **/
        $('#userModal #newContact').attr('data-url', '/anunciantes/' + publisher.id + '/contacts');

        $('#userModal #comments').html('');

        console.log('DIBUJANDO');
        console.log(publisher.contacts);

        $.each(publisher.contacts, function( index, contact ) {
            var socialContact = UserService.getSocialContact(contact);
            $('#userModal #comments').append(socialContact);
        });

        $('[data-toggle="tooltip"]').tooltip();
    }

    function drawModalEditAgreement(publisher, url) {
        $(".userEditDataAgreementModal #user_company").text(publisher.company);
        $(".userEditDataAgreementModal #signed_at").val(publisher.signed_at_date);
        $(".userEditDataAgreementModal #commission_rate").val(publisher.commission_rate);
        $(".userEditDataAgreementModal #retention").val(publisher.retention);
        $(".userEditDataAgreementModal #discount").val(publisher.discount);
        $(".userEditDataAgreementModal #bank_name").val(publisher.bank_name);
        $(".userEditDataAgreementModal #bank_account").val(publisher.bank_account);

        $(".userEditDataAgreementModal #user_company").attr('data-url', url)

        $(".userEditDataAgreementModal").modal();
    }

    function drawShowPrices() {
        var publisher = $("#publisher").data("publisher");
        var states = $("#publisher").data("states");

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
                                $('#userModal').modal('toggle');
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
        var changeCheckbox = document.querySelector('#publisher_sw_agreement .js-switch-click');

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
                        
                        $.post($("#publisher_sw_agreement input").attr('data-url'), parameters, function( data ) {
                            if(data.success) {
                                $("#userModal .fa.fa-file-text-o").parent().removeClass(removeClass).addClass(addClass);
                                reload();
                                swal("Acuerdo actualizado", "", "success");
                            }
                            else{
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

    function initChangeDocuments() {
        var manual = false;
        var changeCheckbox = document.querySelector('#publisher_sw_documents .js-switch-click');

        if(changeCheckbox) {
            changeCheckbox.onchange = function(e) {   
                if(! manual) {
                    swal({
                        title: '¿Estás seguro?',
                        text: 'El medio podrá o no subir nuevos documentos',
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
                            
                            var parameters = {"change_documents": "0"};
                            var removeClass = "btn-primary";
                            var addClass = "btn-danger";
                            
                            if(changeCheckbox.checked) {
                                parameters = {"change_documents": "1"};
                                removeClass = "btn-danger";
                                addClass = "btn-primary";
                            }
                            
                            $.post($("#publisher_sw_documents input").attr('data-url'), parameters, function( data ) {
                                if(data.success) {
                                    $("#userModal .fa.fa-file-text-o").parent().removeClass(removeClass).addClass(addClass);
                                    
                                    if(changeCheckbox.checked) {
                                        swal("El medio podrá subir nuevos documentos", "", "success");
                                    }
                                    else {
                                        swal("El medio ya no podrá subir nuevos documentos", "", "success");
                                    }

                                    reload();
                                }
                                else{
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
        
    }

    return {
        init: function(urlSearch) {
            initTable(urlSearch);
            UserService.initInputsDateRange();
            initSearchDateRanges();
            initModalEvent();
            initDeletePublisher();
            UserService.initActionNotifications(16);
            UserService.initChangeTag();
        },
        drawShowPrices: function() {
            drawShowPrices();
        },
        getSocialContact: function(contact) {
            return UserService.getSocialContact(contact);
        },
        reload: function() {
            reload();
        },
        drawModal: function(pulbihser) {
            drawModal(pulbihser);
            $("#userModal").modal();
        }
    };
}();