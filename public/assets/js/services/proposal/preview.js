var PreviewService = function() {

	var selectedPublishers; 
	var classSelect = "publisher-selected";
	var iCheck;
	var iva;
	var subtotal = 0;
	var ivaPrice = 0;
	var total = 0;
	var count = 0;

	function defaults() {
		iCheck 	= $("<i></i>").addClass("fa fa-check-square-o");
		iva 	= $("#iva").data("iva");

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

	function changeTextPrices() 
	{
		$("#dinamic-quote #quote-subtotal-price").text(numeral(subtotal).format('$ 0,0') );
		$("#dinamic-quote #quote-iva-price").text(numeral(ivaPrice).format('$ 0,0') );
		$("#dinamic-quote #quote-price").text(numeral(total).format('$ 0,0') );
		$("#quote-price span").text(numeral(total).format('$ 0,0') );

		$("#dinamic-quote h2").text(count + " Medios seleccionados");
		$(".quote.modal-quote h2").text(count + " Medios seleccionados");
	}

	function calculatePrices()
	{
		ivaPrice 	= subtotal * iva;
		total 		= subtotal + ivaPrice;
	}

	function getPublisherId(article) 
	{
		return article.attr("data-publisherId");
	}

	function getPublisherPrice(article)
	{
		return article.data("price");	
	}

	function sumPrices(article, id) 
	{
		subtotal += getPublisherPrice(article);
		count ++;
		calculatePrices();
		addSelectPublisherId(id);
	}

	function subtractPrices(article, id) 
	{
		subtotal -= getPublisherPrice(article);
		count --;
		calculatePrices();
		removeSelectPublisherId(id);
	}

	function verificModalPrices()
	{
		if(count > 0 && ! $(".quote.modal-quote").hasClass("modal-show")) {

			$(".quote.modal-quote").addClass("modal-show");
		} else if(count == 0) {
			$(".quote.modal-quote").removeClass("modal-show");
		}
	}

	function selectArticle(article, button)
	{
		article.addClass(classSelect);	
		button.html("Seleccionado");
	}

	function deselectArticle(article, button)
	{
		article.removeClass(classSelect);
		button.html(iCheck).append(" Seleccionar");
	}

	function addSelectPublisherId(id)
	{	
		if($.inArray(id, selectedPublishers) != 1) {
			selectedPublishers.push(id);
		}
	}

	function removeSelectPublisherId(id)
	{
		selectedPublishers = $.grep(selectedPublishers, function( n, i ) {
			return id != n ;
		});
	}

	function clickPrice(article, button) {
		var id = getPublisherId(article);

		if( article.hasClass(classSelect)) {
			subtractPrices(article, id);
			removeSelectPublisherId(id);
		}	
		else {
			sumPrices(article, id);
			selectArticle(article, button);
		}

		changeTextPrices();
	}

	function reloadPrices() 
	{
		subtotal = 0;
		ivaPrice = 0;
		total = 0;
		count = 0;
		var id;

		$(".publisher-selected").each(function(index, article) {
			article = $(article);
			sumPrices(article, getPublisherId(article));
		});

		changeTextPrices();
	}

	function initSelect() {
		$(".btn-select").click(function() {
			clickPrice($(this).closest(".publisher"), $(this));
			verificModalPrices();
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

		selectedPublishers = new Array();
		reloadPrices();
		verificModalPrices();
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

