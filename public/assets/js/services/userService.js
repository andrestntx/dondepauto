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
	        $('.input-daterange').datepicker({
	        	format: 'dd/mm/yyyy',
	            keyboardNavigation: false,
	            forceParse: false,
	            autoclose: true,
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

		initDrawDateRange: function(inputInit, inputFinish) 
		{
			$(inputInit + ', ' + inputFinish).on('change', function() {
	            dataTable.draw();
	        } );
		},

		searchDateRange: function (aData, inputInit, inputFinish, column) {
	        var iFini = $(inputInit).val();
	        var iFfin = $(inputFinish).val();

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
			$("#prueba").html(UserService.getHtmlModalStates(user.states, ''));
	        $('#' + inputId + ' #modalEdit').attr('href', '/' + urlName + '/' + user.id + '/edit');

	        /** Personal Data **/
	        $('#' + inputId +' #company_name').text(user.company);
	        $('#' + inputId +' #name').text(user.name);
	        $('#' + inputId +' #email a').attr('href', 'mailto:' + user.email).text(user.email);
	        $('#' + inputId +' a#phone').attr('href', 'tel:' + user.phone).text(user.phone);
	        $('#' + inputId +' a#cel').attr('href', 'tel:' + user.cel).text(user.cel);

	        /** Data Detail **/
	        $('#' + inputId +' #economic_activity').text(user.economic_activity_name);
	        $('#' + inputId +' #city').text(user.city_name);
	        $('#' + inputId +' #address').text(user.address);
	        $('#' + inputId +' #company_nit').text(user.company_nit);
	        $('#' + inputId +' #company_role').text(user.company_role);
	        $('#' + inputId +' #company_area').text(user.company_area);

	        /** Comments **/
	        $('#' + inputId +' #comments').text(user.comments);

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
	    		var text    = $('<p></p>').addClass('steps-name').text(state.text);
	    		var button	= $('<button type="button"></button>').addClass('steps-img btn-circle btn btn-' + state.class).append(i);
	    		var div 	= $('<div></div>').addClass('state text-center').append(button).append(text);
	    		htmlStates.append(div);
			});
			
			return html.append(line).append(htmlStates);
	    },

	    getHtmlTableStates: function (states, cols) 
	    {
	    	var html 		= $('<div style="width:190px;"></div>').addClass('text-center');

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