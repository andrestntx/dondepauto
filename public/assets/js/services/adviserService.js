/**
 * Created by Desarrollador 1 on 15/04/2016.
 */

var AdviserService = function() {

    var unLinkTable;
    var linkTable;
    var adviserId;
    var urlSearch = $("#urlSearch").data('url');

    function initLinkTable() {
        linkTable = $('.advertisers-datatable').DataTable({
            "order": [[0, "desc"]],
            "ajax": urlSearch,
            "rowId": 'id',
            "deferRender": true,
            "columns": [
                { "data": "company" },
                { "data": "name" },
                { "data": "email" },
                { "data": "state" },
            ],
            "language": {
                "lengthMenu": "Ver _MENU_ por página",
                "zeroRecords": "Lo siento, no se enontraron anunciantes",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay anuncioantes",
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
            "columnDefs": [
                {
                    "className": "text-center",
                    "targets": [3]
                }
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if(aData.state.length > 30) {
                    $('td:eq(3)', nRow).html(aData.state);
                }
                else {
                    $('td:eq(3)', nRow).html(
                        UserService.getHtmlTableStates(aData.states)
                    );
                }
                
            },
            "drawCallback": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    function initUnlinkTable() {
        unLinkTable = $('#link-advertisers').DataTable( {
            "ajax": '/anunciantes/unlinked',
            "rowId": 'id',
            "columns": [
                { "data": "company" },
                { "data": "name" },
                { "data": "email" },
                { "data": "state" },
            ],
            "order": [[ 1, "desc" ]],
            "language": {
                "lengthMenu": "Ver _MENU_ por página",
                "zeroRecords": "Lo siento, no se enontraron anunciantes",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay anuncioantes",
                "infoFiltered": "(Filtrado de _MAX_ asignados)",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Buscar:",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            },
            "columnDefs": [
                {
                    className: "text-center",
                    "targets": [3]
                }
            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if(aData.state.length > 30) {
                    $('td:eq(3)', nRow).html(aData.state);
                }
                else {
                    $('td:eq(3)', nRow).html(
                        UserService.getHtmlTableStates(aData.states)
                    );
                }
            },
            "drawCallback": function(settings, json) {
                $('[data-toggle="tooltip"]').tooltip();
            }
            
        } );
    }

    function initEventUnLink() {
        $("#unlink").confirm({
            text: "¿Está seguro de desvincular estos anunciantes?",
            title: "Confirmar desvinculación",
            confirm: function(button) {
                var advertisers = [];
                $('.selected-warning').each(function(){
                    advertisers.push($(this).attr('id'));
                });
                var parameters = {'advertisers': advertisers};

                $.post("/asesores/" + adviserId + "/unlink", parameters, function( data ) {
                    if(data.success) {
                        var rows = linkTable.rows('.selected-warning').nodes();
                        $('.selected-warning').addClass('selecteds-warning').removeClass('selected-warning');
                        linkTable.rows('.selecteds-warning').remove().draw(false);
                        unLinkTable.rows.add(rows);
                        $("#count-advertisers").html('(' + linkTable.rows().count() + ')');
                        $('#unlink').attr('disabled','disabled');

                        toastr.success(data.message);
                    }
                    else{
                        toastr.danger(data.message);
                    }
                });
            },
            cancel: function(button) {

            },
            confirmButton: "Si, desvincular",
            cancelButton: "No",
            post: true,
            confirmButtonClass: "btn-primary",
            cancelButtonClass: "btn-danger",
            dialogClass: "modal-dialog modal-md" // Bootstrap classes for large modal
        });
    }

    function initEventLink() {
        $( "#link" ).click(function() {
            $('.modal .selected-warning').removeClass('selected-warning');
            $('#advertisersModal').modal();
        });
    }
    
    function initEventCancel() {
        $( "#cancel" ).click(function() {
            $(".checkbox-unlink").hide();
            $(".checkboxes").hide();
            $("a#unlink").removeAttr("disabled").show();
            $("a#link").removeAttr("disabled").show();
            $("#cancel").attr('disabled','disabled').hide();
            $("#confirm").attr('disabled','disabled').hide();
        });
    }

    function initEventLinkConfirm() {
        $("#modal-confirm").confirm({
            text: "¿Está seguro de asignar estos anunciantes?",
            title: "Confirmar Asingación",
            confirm: function(button) {
                var advertisers = [];
                $('.selected-success').each(function(){
                    advertisers.push($(this).attr('id'));
                });
                var parameters = {'advertisers': advertisers};

                $.post("/asesores/" + adviserId + "/link", parameters, function( data ) {
                    if(data.success) {
                        var rows = unLinkTable.rows('.selected-success').nodes();
                        $('.selected-success').addClass('selecteds-success').removeClass('selected-success');
                        unLinkTable.rows('.selecteds-success').remove().draw(false);
                        linkTable.rows.add(rows).draw(false);

                        $("#count-advertisers").html('(' + linkTable.rows().count() + ')');
                        $('#modal-confirm').attr('disabled','disabled');
                        $('#advertisersModal').modal('hide');
                        toastr.success(data.message);
                        $('.selected-success').removeClass('selected-success');
                    }
                    else{
                        toastr.danger(data.message);
                    }
                });
            },
            cancel: function(button) {
                // nothing to do
            },
            confirmButton: "Si, Asignar",
            cancelButton: "No",
            post: true,
            confirmButtonClass: "btn-primary",
            cancelButtonClass: "btn-danger",
            dialogClass: "modal-dialog modal-md" // Bootstrap classes for large modal
        });
    }

    function initSelectedUnLink(){
        $('#unlink-advertisers tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected-warning');
            
            if($('.selected-warning').length > 0) {
                $('#unlink').removeAttr("disabled");
            }
            else {
                $('#unlink').attr('disabled','disabled');
            }
        } );
    }

    function initSelectedLink(){
        $('#link-advertisers tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected-success');

            if($('.selected-success').length > 0) {
                $('#modal-confirm').removeAttr("disabled");
            }
            else {
                $('#modal-confirm').attr('disabled','disabled');
            }
        } );
    }

    return {
        init: function() {
            adviserId = $("#adviserId").data('ids');
            // Events Unlink
            initLinkTable();
            initEventUnLink();
            initEventCancel();
            initSelectedUnLink();
            
            // Events Link
            initUnlinkTable();
            initEventLink();
            initEventLinkConfirm();
            initSelectedLink();
        }
    };
}();