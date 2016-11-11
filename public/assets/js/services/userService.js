var UserService = function() {
	
	var dataTable;
	var columnCreatedAt;
	var columnLoginAt;
	var userEdit;

	function drawPersonalData(inputId, user) {
    	$('#' + inputId + ' #company_name').text(user.company);
        $('#' + inputId + ' #name').text(user.name);
        $('#' + inputId + ' #company_role').text(user.company_role);
        $('#' + inputId + ' #email a').attr('href', 'mailto:' + user.email).text(user.email);
        $('#' + inputId + ' #company_area').text(user.company_area);
        $('#' + inputId + ' a#phone').attr('href', 'tel:' + user.phone).text(user.phone);
        $('#' + inputId + ' a#cel').attr('href', 'tel:' + user.cel).text(user.cel);
        $('#' + inputId + ' #text-comments').text(user.comments);
    };
    
    function drawDetailData(inputId, user, isPublisher) {
    	$('#' + inputId +' #economic_activity').text(user.economic_activity_name);
        $('#' + inputId +' #city').text(user.city_name);
        $('#' + inputId +' #address').text(user.address);
        $('#' + inputId +' #company_nit').text(user.company_nit);

        if(isPublisher) {
        	$('#' + inputId +' #company_legal').text(user.company_legal);
	        $('#' + inputId +' #repre_name').text(user.repre_name);
	        $('#' + inputId +' #repre_email').text(user.repre_email);
	        $('#' + inputId +' #repre_doc').text(user.repre_doc);
	        $('#' + inputId +' #repre_phone').text(user.repre_phone);	
        }
    };

    function drawAgreementData(inputId, user) {
        $('#' + inputId + ' #commission_rate').text(user.commission_rate);
        $('#' + inputId + ' #signed_at').text(user.signed_at_datatable);
        $('#' + inputId + ' #discount').text(user.discount);
        $('#' + inputId + ' #retention').text(user.retention);
    };

    function drawModalEditContact(user, url) {
        $(".userEditDataContactModal #user_company").text(user.company);
        $(".userEditDataContactModal #first_name").val(user.first_name);
        $(".userEditDataContactModal #last_name").val(user.last_name);

        $(".userEditDataContactModal #company_role").val(user.company_role);
        $(".userEditDataContactModal #company_area").val(user.company_area);

        $(".userEditDataContactModal #email").val(user.email);
        $(".userEditDataContactModal #phone").val(user.phone);
        $(".userEditDataContactModal #cel").val(user.cel);
        $(".userEditDataContactModal #comments").val(user.comments);

        $(".userEditDataContactModal #user_company").attr('data-url', url);

        $(".userEditDataContactModal").modal();
    };

    function drawModalEditDetail(user, url, isPublisher) {
        $(".userEditDataDetailModal #user_company").text(user.company);
        $(".userEditDataDetailModal #company").val(user.company);
        $(".userEditDataDetailModal #company_nit").val(user.company_nit);
        $(".userEditDataDetailModal #city_id").val(user.city_id);
        $(".userEditDataDetailModal #address").val(user.address);

        $(".userEditDataDetailModal #user_company").attr('data-url', url);

        if(isPublisher) {
			$(".userEditDataDetailModal #company_legal").val(user.company_legal);
			$(".userEditDataDetailModal #repre_name").val(user.repre_name);
			$(".userEditDataDetailModal #repre_email").val(user.repre_email);
			$(".userEditDataDetailModal #repre_doc").val(user.repre_doc);
			$(".userEditDataDetailModal #repre_phone").val(user.repre_phone);        	
        }

        $(".userEditDataDetailModal").modal();
    };

    function getFilterSearch() {
    	return $(".dataTables_filter input").val();
    }

    function initModalsEdit(isPublisher) {
    	$(".userEditDataContactModal #form-edit-data-contact").click(function() {

            postModal(
                $(".userEditDataContactModal #user_company").attr('data-url'), {
	                'first_name':   $(".userEditDataContactModal #first_name").val(),
	                'last_name':    $(".userEditDataContactModal #last_name").val(),
	                'company_role': $(".userEditDataContactModal #company_role").val(),
	                'company_area': $(".userEditDataContactModal #company_area").val(),
	                'email':        $(".userEditDataContactModal #email").val(),
	                'phone':        $(".userEditDataContactModal #phone").val(),
	                'cel':          $(".userEditDataContactModal #cel").val(),
                    'comments':     $(".userEditDataContactModal #comments").val()
	            }, $(".userEditDataContactModal"), isPublisher
            );
        });

        $(".userEditDataDetailModal #form-edit-data-detail").click(function() {
            postModal(
                $(".userEditDataDetailModal #user_company").attr('data-url'), {
	                'company':      $(".userEditDataDetailModal #company").val(),
	                'company_nit':  $(".userEditDataDetailModal #company_nit").val(),
	                'city_id':      $(".userEditDataDetailModal #city_id").val(),
	                'address':      $(".userEditDataDetailModal #address").val(),
	                'company_legal': 	$(".userEditDataDetailModal #company_legal").val(),
	                'repre': {
	                	'name':     $(".userEditDataDetailModal #repre_name").val(),
						'email': 	$(".userEditDataDetailModal #repre_email").val(),
						'doc': 		$(".userEditDataDetailModal #repre_doc").val(),
						'phone': 	$(".userEditDataDetailModal #repre_phone").val()
	                }

	            }, $(".userEditDataDetailModal"), isPublisher
            );
        });
    };

    function postModal(url, parameters, modal, isPublisher) {
        modal.find("#sk-spinner-modal").show();
        modal.find(".form-edit-data").prop("disabled", true);

        $.post(url, parameters, function( data ) {
            if(data.success) {
                userEdit = data.user;
                
                drawPersonalData("userModal", userEdit);
                drawDetailData("userModal", userEdit, isPublisher);

                if(isPublisher) {
                	drawAgreementData("userModal", userEdit);
                }

                modal.find("#sk-spinner-modal").hide();

                dataTable.search(getFilterSearch()).draw();

                modal.modal('toggle');
                modal.find(".form-edit-data").prop("disabled", false);

            }
            else {
                modal.find("#sk-spinner-modal").hide(); 
                modal.modal('toggle');
                modal.find(".form-edit-data").prop("disabled", false);
                
                swal({
                    title: 'Hubo un error',
                    text: 'Error controlado',
                    type: "warning",
                });
            }
        }).fail(function(data) {
            modal.find("#sk-spinner-modal").hide();
            modal.modal('toggle');
            modal.find(".form-edit-data").prop("disabled", false);
            swal({
                title: 'Hubo un error',
                text: 'Código ' + data.status,
                type: "warning",
            });
        });
    }

	return {
		initDatatable: function(table, isPublisher) 
		{
			dataTable = table;
			initModalsEdit(isPublisher);
		},

		postModal: function(url, parameters, modal, isPublisher)
		{
			postModal(url, parameters, modal, isPublisher);
		},

		drawAgreementData: function(inputId, user) 
		{
			drawAgreementData(inputId, user);
		},

		setUserEdit: function(user) 
		{
			userEdit = user;
		},

		getFilterSearch: function()
		{
			getFilterSearch();
		},

		initActions: function(column) {
			 $(".btn-group > .btn").click(function() {
                $(this).addClass("active").siblings().removeClass("active");

                dataTable
                	.column(column)
                	.search($(this).data('action'))
                	.draw();
            });
		},

		initActionsRange: function(column) {

            var start = moment().subtract(3, 'years');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('D MMM, YYYY') + ' - ' + end.format('D MMM, YYYY'));
                
                dataTable
                	.column(column)
                	.search(start.format('YYYY-MM-DD') + ',' + end.format('YYYY-MM-DD'))
                	.draw();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                "locale": {
                    "format": "DD MMM, YYYY",
                    "separator": " - ",
                    "applyLabel": "Buscar",
                    "cancelLabel": "Cerrar",
                    "fromLabel": "Hasta",
                    "toLabel": "Desde",
                    "customRangeLabel": "Seleccionar",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sab"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Deciembre"
                    ],
                    "firstDay": 1
                },
                ranges: {
                   'Vencidas': [moment().subtract(3, 'years'), moment().subtract(1, 'days')],
                   'Hoy': [moment(), moment()],
                   'Mañana': [moment().add(1, 'days'), moment().add(1, 'days')],
                   'Esta semana': [moment().day(1), moment().day(7)],
                   'Próxima semana': [moment().day(8), moment().day(14)]
                }
            }, cb); 

		},

		initInputsDateRange: function() {

	        $('.input-daterange').datepicker({
	        	format: 'dd/mm/yyyy',
	            keyboardNavigation: false,
	            forceParse: false,
	            autoclose: true,
	        }).on('changeDate', function(e) {
	        	dataTable
	            	.column($(this).data('column'))
	            	.search($($(this).children('input')[0]).val() + ',' + $($(this).children('input')[1]).val())
	            	.draw();
	        }).on('clearDate', function(e) {
	        	dataTable
	            	.column($(this).data('column'))
	            	.search($($(this).children('input')[0]).val() + ',' + $($(this).children('input')[1]).val())
	            	.draw();
	        });
	    },

		initSimpleSearchSelect: function (input, column) 
		{
			$(input).on( 'change', function () {
	            dataTable
	                .column(column)
	                .search( this.value )
	                .draw();
	        } );
		},

		initSimpleSearchSelectText: function (input, column) 
		{
			$(input).on( 'change', function () {
	            dataTable
	                .column(column)
	                .search( $(this).find("option:selected").text() )
	                .draw();
	        } );
		},

		cleanColumnSearch: function (column) 
		{           
            dataTable
                .column(column)
                .search('')
                .draw();
		},

        initActionNotifications: function(column) 
        {
            $("#action-notifications").click(function() {
                dataTable
                    .column(column)
                    .search(moment().format("YYYY-MM-DD") + "," + moment().format("YYYY-MM-DD"))
                    .draw();    
            });
        },

		cleanColumnsSearch: function (columns) 
		{            
            dataTable
                .columns(columns)
                .search('')
                .draw();
		},

		initExactSearchSelect: function(input, column) 
		{
			$(input).on( 'change', function () {
	            if (!this.value.trim()) {
	                dataTable
	                    .column(column)
	                    .search( this.value )
	                    .draw();
	            }
	            else {
	                dataTable
	                    .column(column)
	                    .search( "^\\s*"+ this.value +"\\s*$", true, false)
	                    .draw();
	            }

	        } );
		},

		getLastContact: function(contacts) {
            var lastContact = contacts[0];
            var action_name = $("<span>NA</span>").addClass("small"); 
            var action_date = $("<a>NA</a>").addClass("small"); 

            if(lastContact.action) {
                action_name.text('').append($("<strong></strong>").text(lastContact.action.name)); 
                action_date.text(lastContact.action.action_at_date)
                            .attr('data-toggle', 'tooltip')
                            .attr('data-placement', 'top')
                            .attr('title', lastContact.action.action_at_humans); 
            }

            var date    = $("<a></a>")
                            .attr('style', 'margin-left: 4px;')
                            .attr('data-toggle', 'tooltip')
                            .attr('data-placement', 'top')
                            .attr('title', lastContact.comments)
                            .addClass("small")
                            .text(lastContact.created_at_humans);

            var count   = $("<span></span>")
                            .addClass("label label-default")
                            .text(contacts.length);

            var li      = $("<li></li>")
                            .attr('style', 'border: 0px; padding: 5px 0; min-width: 320px;')
                            .addClass("list-group-item")
                            .append(count)
                            .append(date)
                            .append(" /   ")
                            .append(action_name)
                            .append(" - ")
                            .append(action_date);

            var div     = $("<div></div>").append(li);

            return div;
	    },

		getSocialContact: function(contact) {
			var action_at = '';
	        var action_name = '';
	        var created_at  = $("<a></a>")
	                            .attr("href", "#")
	                            .text(contact.created_at_format);

	        if(contact.action) {
	        	action_at   = $("<a></a>")
	                            .attr("href", "#")
	                            .text(contact.action.action_at);	

	            action_name	= $("<strong></strong>").text(contact.action.name);
	        }

	        var body        = $("<div></div>")
	                            .addClass("media-body")
	                            .append("Contacto: ")
	                            .append(created_at)
	                            .append(" " + contact.comments)
	                            .append("<br>")
	                            .append("Acción:")
	                            .append(action_at)
	                            .append(" ")
	                            .append(action_name);

	        var socialContact   = $("<div></div>")
	                                .addClass("social-comment")
	                                .append(body);

	        return socialContact;
	    },

		/*initDrawDateRange: function(inputInit, inputFinish, column) 
		{
			$('#created_at_start').change(function() {
				console.log('busca fecha 1');
	            dataTable
	            	.column(column)
	            	.search($(inputInit).val() + ',' + $(inputFinish).val())
	            	.draw();
	        } );

			$(inputFinish).on('change', function() {
				console.log('busca fecha 2');
	            dataTable
	            	.column(column)
	            	.search($(inputInit).val() + ',' + $(inputFinish).val())
	            	.draw();
	        } );
		},*/

		searchDateRange: function (aData, inputInit, inputFinish, column) {

	        var iFini = $(inputInit).val();
	        var iFfin = $(inputFinish).val();

	        console.log(iFini);
	        console.log(iFfin);

	        iFini = iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
	        iFfin = iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

	        if ( iFini === "" && iFfin === "") {
	            return true;
	        }
	        else {
	            var datoDateCol = aData[column].substring(6,10) + aData[column].substring(3,5)+ aData[column].substring(0,2);
	            if (iFini <= datoDateCol && iFfin === "") {
	                return true;
	            }
	            else if (iFfin >= datoDateCol && iFini === "") {
	                return true;
	            }
	            else if (iFini <= datoDateCol && iFfin >= datoDateCol) {
	                return true;
	            }
	        }

	        return false;
	    },

	    drawPersonalData: function(inputId, user) {
	    	drawPersonalData(inputId, user);
	    },
	    
	    drawDetailData: function(inputId, user, isPublisher) {
	    	drawDetailData(inputId, user, isPublisher);
	    },

		drawModalUser: function (inputId, user, urlName, isPublisher) {

			console.log(' es publisher: ' + isPublisher);

			userEdit = user;

            console.log(userEdit);
            console.log(userEdit.states);

			$("#prueba").html(UserService.getHtmlTableStates(userEdit.states, 200));
	        $('#' + inputId + ' #modalEdit').attr('href', '/' + urlName + '/' + userEdit.id + '/edit');
            $('#' + inputId + ' #modalShow').attr('href', '/admin/' + urlName + '/' + userEdit.id);
            $('#' + inputId + ' .select-tags')
                .val(userEdit.tag_id)
                .attr('data-url', '/users/' + userEdit.id + '/tag');

	        /** Personal Data **/
	        drawPersonalData(inputId, userEdit, isPublisher);
	        $('#' + inputId +' #source').text(userEdit.source);

	        /** Detail Data **/
	        drawDetailData(inputId, userEdit, isPublisher);

	        /** Comments **/
	        //$('#' + inputId +' #comments').text(user.comments);

	        /** State **/
	        $('#' + inputId +' #state')
	            .removeClass()
	            .addClass('btn btn-circle btn-' + userEdit.state_class)
	            .attr('data-original-title', userEdit.state);

	        $('#' + inputId +' #state i')
	            .removeClass()
	            .addClass('fa ' + userEdit.state_icon);


	        $("#edit-data-contact").click(function() {
            	drawModalEditContact(userEdit, '/' + urlName + '/' + userEdit.id + '/ajax', isPublisher);
	        });

	        $("#edit-data-detail").click(function(){
	            drawModalEditDetail(userEdit, '/' + urlName + '/' + userEdit.id + '/ajax', isPublisher);
	        });
		},

        initChangeTag: function () {
            $(".select-tags").change(function() {
                var url = $(this).attr('data-url');
                var parameters = {
                    'tag_id': $(this).val()
                };

                $.post(url, parameters, function( data ) {
                    if(data.success) {
                        dataTable.search(getFilterSearch()).draw();
                    }
                    else {
                        swal({
                            title: 'Hubo un error',
                            text: 'Error controlado',
                            type: "warning",
                        });
                    }
                }).fail(function(data) {
                    swal({
                        title: 'Hubo un error',
                        text: 'Código ' + data.status,
                        type: "warning",
                    });
                });
            });    
        },

		initSearchDateRanges: function(columnCreatedAtP, columnLoginAtP, columnActivatedAtP)
	    {
	    	columnCreatedAt = columnCreatedAtP;
	    	columnActivatedAt = columnActivatedAtP;
	    	columnLoginAt = columnLoginAtP;

	    	UserService.initDrawDateRange('#created_at_start', '#created_at_end');
        	//UserService.initDrawDateRange('#activated_at_start', '#activated_at_end');
        	//UserService.initDrawDateRange('#last_login_at_start', '#last_login_at_end');

	        $.fn.dataTableExt.afnFiltering.push(
	            function( oSettings, aData, iDataIndex) {
	                return UserService.searchDateRange(aData, '#created_at_start', '#created_at_end', columnCreatedAt)
	                		//UserService.searchDateRange(aData, '#activated_at_start', '#activated_at_end', columnActivatedAt) && 
	                        //UserService.searchDateRange(aData, '#last_login_at_start', '#last_login_at_end', columnLoginAt);
	            }
	        );
	    },

	    getHtmlModalStates: function (states, cols) 
	    {
	    	var html 		= $('<div></div>');
	    	var line 		= $('<div></div>').addClass('linea');
	    	var htmlStates 	= $('<div></div>').addClass('states');

	    	$.each( states, function( key, state ) {
	    		var i 		= $('<i></i>').addClass(state.icon);
	    		var text    = $('<p></p>').addClass('steps-name');//.text(state.text);
	    		var button	= $('<button type="button"></button>')
	    						.addClass('steps-img btn-circle btn btn-' + state.class)
	    						.attr('data-toggle', 'tooltip')
	    						.attr('data-placement', 'top')
	    						.attr('title', state.text + ' / ' + state.date)
	    						.append(i);

	    		var div 	= $('<div></div>').addClass('state text-center').append(button).append(text);
	    		htmlStates.append(div);
			});
			
			return html.append(line).append(htmlStates);
	    },

	    getHtmlLogs: function(count, date)
	    {
	    	return $('<span></span>')
                        .addClass('badge badge-info')
                        .text(count)
                        .attr('data-toggle', 'tooltip')
                        .attr('data-placement', 'top')
                        .attr('title', date); 

	    },

	    getHtmlTableStates: function (states, width) 
	    {
	    	if(! width) {
	    		width = '190';
	    	}

	    	var html 		= $('<div style="width:' + width + 'px; margin: 0 auto;"></div>').addClass('text-center');

	    	$.each( states, function( key, state ) {
	    		var i 		= $('<i></i>').addClass(state.icon);
	    		var button	= $('<button type="button"></button>')
	    						.addClass('steps-img btn-circle btn btn-' + state.class)
	    						.attr('data-toggle', 'tooltip')
	    						.attr('data-placement', 'top')
	    						.attr('title', state.text + ' / ' + state.date)
	    						.append(i);

	    		var div 	= $('<div></div>').addClass('text-center table-state').append(button);
	    		html.append(div);
			});
			
			return html;
	    }
	}
}();