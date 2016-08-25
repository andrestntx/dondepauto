var UserService = function() {
	
	var dataTable;
	var columnCreatedAt;
	var columnLoginAt;

	return {
		initDatatable: function(table) 
		{
			dataTable = table;
		},

		initInputsDateRange: function() {
			console.log('initInputsDateRange');
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

		drawModalUser: function (inputId, user, urlName) {
			$("#prueba").html(UserService.getHtmlTableStates(user.states, 200));
	        $('#' + inputId + ' #modalEdit').attr('href', '/' + urlName + '/' + user.id + '/edit');

	        /** Personal Data **/
	        $('#' + inputId +' #company_name').text(user.company);
	        $('#' + inputId +' #name').text(user.name);
	        $('#' + inputId +' #email a').attr('href', 'mailto:' + user.email).text(user.email);
	        $('#' + inputId +' a#phone').attr('href', 'tel:' + user.phone).text(user.phone);
	        $('#' + inputId +' a#cel').attr('href', 'tel:' + user.cel).text(user.cel);
	        $('#' + inputId +' #source').text(user.source);

	        /** Data Detail **/
	        $('#' + inputId +' #economic_activity').text(user.economic_activity_name);
	        $('#' + inputId +' #city').text(user.city_name);
	        $('#' + inputId +' #address').text(user.address);
	        $('#' + inputId +' #company_nit').text(user.company_nit);
	        $('#' + inputId +' #company_role').text(user.company_role);
	        $('#' + inputId +' #company_area').text(user.company_area);

	        /** Comments **/
	        //$('#' + inputId +' #comments').text(user.comments);

	        /** State **/
	        $('#' + inputId +' #state')
	            .removeClass()
	            .addClass('btn btn-circle btn-' + user.state_class)
	            .attr('data-original-title', user.state);

	        $('#' + inputId +' #state i')
	            .removeClass()
	            .addClass('fa ' + user.state_icon);
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
	    						.attr('title', state.text)
	    						.append(i);

	    		var div 	= $('<div></div>').addClass('state text-center').append(button).append(text);
	    		htmlStates.append(div);
			});
			
			return html.append(line).append(htmlStates);
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
	    						.attr('title', state.text)
	    						.append(i);

	    		var div 	= $('<div></div>').addClass('text-center table-state').append(button);
	    		html.append(div);
			});
			
			return html;
	    }
	}
}();