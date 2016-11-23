var EditService = function() {

	function init(loading, button) {
		loading.show();
        button.prop("disabled", true);
	}

	function fail(loading, modal, button, status) {
		loading.hide();
        modal.modal('toggle');
        button.prop("disabled", false);
        
        swal({
            title: 'Hubo un error',
            text: 'Código ' + status,
            type: "warning",
        });
	}

	function success(loading, modal, button) {
		loading.hide();
        modal.modal('toggle');
        button.prop("disabled", false);	
	}

	function edit(url, modal, postSuccess, type) {
		var button    = modal.find(".btn-edit");
        var loading   = modal.find(".sk-spinner-modal");

        button.click(function(){
        	ajax(url, modal.find('form').serialize(), modal, loading, button, postSuccess, type);
        });
	}

	function ajax(url, parameters, modal, loading, button, postSuccess, type) {
		init(loading, button);

        $.ajax({
		    url: url,
		    type: type,
		    data: parameters,
		    success: function(result) {
		        if(result.success) {
	                postSuccess(result);
	                success(loading, modal, button);
	            }
	            else {
	                fail(loading, modal, button, result.status);
	            }
		    },
		    error: function(result) {
            	fail(loading, modal, button, result.status);
        	}
		});
	}

	return {
        post: function(url, modal, postSuccess) {
            edit(url, modal, postSuccess, 'POST');
        },
        put: function(url, modal, postSuccess) {
            edit(url, modal, postSuccess, 'PUT');
        }
    };
}()