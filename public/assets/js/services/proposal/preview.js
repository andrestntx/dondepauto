var PreviewService = function() {

	var selectedPublishers = new Array(); 
	
	function defaults() {
		$.fn.arcticScroll = function (options) {

		    var defaults = {
		        elem: $(this),
		        speed: 500
		    };

		    var options = $.extend(defaults, options);

		    options.elem.click(function(event){    
		        event.preventDefault();
		        var offset = ($(this).attr('data-offset')) ? $(this).attr('data-offset') : false,
		            position = ($(this).attr('data-position')) ? $(this).attr('data-position') : false;         
		        if (offset) {
		            var toMove = parseInt(offset);
		          $('html,body').stop(true, false).animate({scrollTop: ($(this.hash).offset().top + toMove) }, options.speed);
		        } else if (position) {
		          var toMove = parseInt(position);
		          $('html,body').stop(true, false).animate({scrollTop: toMove }, options.speed);
		        } else {
		          $('html,body').stop(true, false).animate({scrollTop: ($(this.hash).offset().top) }, options.speed);
		        }
		    });
		};	
	}

	function getParams() {
		return $.param({"spaces": selectedPublishers});
	}

	function initSelect() {
		
		var classSelect = "publisher-selected";
		var iva = $("#iva").data("iva");
		var ivaPrice = 0;
		var subtotal = 0;
		var total = 0;
		var count = 0;

		$(".btn-select").click(function() {
			var article = $(this).closest(".publisher");
			var i = $("<i></i>").addClass("fa fa-check-square-o");
			var id = article.attr("data-publisherId");

			if( article.hasClass(classSelect)) {
				selectedPublishers = $.grep(selectedPublishers, function( n, i ) {
					return id != n ;
				});
				
				article.removeClass(classSelect);
				$(this).html(i).append(" Seleccionar");
				subtotal -= article.data("price");
				count --;
			}	
			else {
				selectedPublishers.push(id);
				article.addClass(classSelect);	
				$(this).html("Seleccionado");
				subtotal += article.data("price");
				count ++;
			}

			ivaPrice = subtotal * iva;
			total = subtotal + ivaPrice;

			if(count > 0 && ! $(".quote.modal-quote").hasClass("modal-show")) {
				$(".quote.modal-quote").addClass("modal-show");
			} else if(count == 0) {
				$(".quote.modal-quote").removeClass("modal-show");
			}

			$("#dinamic-quote #quote-subtotal-price").text(numeral(subtotal).format('$ 0,0') );
			$("#dinamic-quote #quote-iva-price").text(numeral(ivaPrice).format('$ 0,0') );
			$("#dinamic-quote #quote-price").text(numeral(total).format('$ 0,0') );
			$("#quote-price span").text(numeral(total).format('$ 0,0') );

			$("#dinamic-quote h2").text(count + " Medios seleccionados");
			$(".quote.modal-quote h2").text(count + " Medios seleccionados");
		});

		$("#quote-close").click(function(){
			$(this).closest(".quote.modal-quote").addClass("modal-close");
		});

		$("#dinamic-quote button, .quote.modal-quote button").click(function() {
			var $this = $(this);
			$this.button('loading');

			$.post($(this).attr("data-url"), {"spaces[]": selectedPublishers}, function( data ) {
                if(data.file.length > 0) {
                    var link = document.createElement("a");
                    link.download = 'cotizacion.pdf';
                    link.href = data.file;
                    link.click();
                }
                $this.button('reset');
            }).fail(function(data) {
            	$this.button('reset');
                alert('falló');
            });
		});
	}

	return {
		init: function() {
			defaults();

			$('#dinamic-quote').affix({
			    offset: {
			        top: $('#dinamic-quote').offset().top
			    }
			});	

			$(".arctic_scroll").arcticScroll({
			    speed: 800
			});   

			initSelect();   
		}
	}	
}();

