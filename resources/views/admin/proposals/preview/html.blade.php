@extends('layouts.public')

@section('extra-css')
	<link rel="stylesheet" type="text/css" href="/assets/css/proposal/style.css">
@endsection

@section('content')
	<section class="quote modal-quote">
		<button class="btn btn-xs btn-default" id="quote-close"><i class="fa fa-times"></i></button>
		<h2>0 Medios seleccionados</h2>
		<div id="quote-total">
			<p>Total</p>
			<p id="quote-price"><span>0</span> + IVA</p>
		</div>
		<button class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i> Descargar cotización</button>
	</section> 

	<header>
		<nav>
			<div class="row">
				<figure class="logo col-xs-6 col-sm-3">
					<img src="/assets/img/proposal/logotodoblanco.png" alt="">
				</figure>
				<div class="col-xs-6 col-sm-9 hidden-xs">
					<ul>
						<li><a href="#contact" class="arctic_scroll">Contacto</a></li>
						<li><a href="#publishers" class="arctic_scroll">Medios para campaña</a></li>
						<li><a href="#justification" class="arctic_scroll">Justificación de propuesta</a></li>
					</ul>		
				</div>
			</div>
			
		</nav>
		<section id="quote_title">
			<h1>
				Propuesta de Medios <br>
				<span id="advertiser_company">{{ ucfirst($proposal->getAdvertiser()->company) }}</span>
				<span class="border-title"></span>
			</h1>
		</section>
	</header><!-- /header -->
	
	<main>
		<section id="justification" class="content">
			<article class="text-content">
				<h1>Justificación de <strong>Propuesta</strong>
					<span class="border-title"></span>
				</h1>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. 
				</p>
				<p>
					Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</p>		
			</article>
		</section>
		<section id="target">
			<div class="white-cap">
				<div class="text-content">
					<h1> <strong>Target</strong> para la campaña
						<span class="border-title"></span>
					</h1>
					@foreach($proposal->getAudiencesArray() as $type => $audiences)
						<div class="target">
							<figure>
								<img src="{{ $audiences['img'] }}" alt="{{ $type }}">
							</figure>
							<div class="audience-content">
								<h1>{{ $type }}</h1>
								<p class="audience-name">
									{{ $audiences['names'] }}
								</p>
							</div>
						</div>
					@endforeach	
				</div>
			</div>
		</section>
		
		<div class="container">
			<section id="publishers" class="content">
				<div class="col-xs-12 publishers-title">
					<h1><strong>Medios</strong> para la campaña
						<span class="border-title"></span>
					</h1>
					<p>
						Según el tipo de producto, el perfil del cliente y su presupuesto; proponemos los siguientes medios:
					</p>
				</div>
				<div class="col-xs-12 col-md-8">
					@foreach($proposal->viewSpaces as $space)
						<article class="publisher publisher-selected">
							<div class="row">
								<div class="col-xs-12">
									<figure class="publisher-check">
										<img src="/assets/img/proposal/seleccionar.png" alt="">
									</figure>
									<span class="publisher-check-text">
										seleccionado
									</span>
								</div>	
								<figure class="col-xs-12 col-sm-5 col-md-4">
									<img src="http://system.dondepauto.co/images/marketplace/big/1083_33539758064.jpg" alt="">
								</figure>
								<div class="publisher-content col-xs-12 col-sm-7 col-md-8">
									<h1>{{ $space->pivot_title }}</h1>
									<p class="publisher-format">
										{{ $space->sub_category_name }} / {{ $space->format_name }}
									</p>
									@if($space->dimensions)
										<ul class="publisher-dimensions">
											<li>
												<strong>Dimensiones: </strong>{{ $space->dimensions }}
											</li>
										</ul>
									@endif
									<p class="publisher-description">
										{!! $space->pivot_description !!}
									</p>
									<p class="publisher-price">
										<span>$ {{ number_format($space->pivot_public_price, 0, ',', '.') }} </span> por {{ $space->period }} 
									</p>
									<button id="btn-select" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Seleccionar</button>
									<a href="{{ $space->url_marketplace }}" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> Ver más</a>
								</div>	
							</div>
							
						</article>
					@endforeach
				</div>
			</section>

			<section class="quote content col-xs-12 col-md-4 scrollspy">
				<div id="dinamic-quote" class="quote-content" data-spy="top-affix">
					<h1>Medios seleccionados</h1>
					<h2>0 Medios seleccionados</h2>
					<div id="quote-total">
						<p>Total</p>
						<p id="quote-price"><span>0</span> + IVA</p>
						<p class="notes">* Para recibir más información y realizar la compra comunicate con nuestra área encargada</p>
					</div>
					<button class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i> Descargar cotización</button>
				</div>	
			</section> 	
		</div>
	</main>

	<footer>
		<section id="contact">
			<div class="white-cap">
				<div class="text-content">
					<figure id="logo-blue">
						<img src="/assets/img/logodonde.png" alt="Logo DóndePauto">	
					</figure>
					<div class="row">
						<figure id="photo" class="col-xs-offset-1 col-sm-offset-2 col-md-offset-1 col-xs-3 col-md-2">
							<img src="/assets/img/proposal/imagenleo.png" alt="">	
						</figure>
						<div id="data" class="col-xs-8 col-sm-6 col-md-8">
							<div id="contact-role" class="col-xs-12 col-md-6">
								<h1>Leonardo Rueda Plazas</h1>	
								<h2>Director General de Marketing</h2>
							</div>
							
							<div id="contact-numbers" class="col-xs-12 col-md-6">
								<p><i class="fa fa-phone"></i> <strong>Tel:</strong> (1)6314163</p> 

								<p><i class="fa fa-mobile-phone"></i> <strong>Cel:</strong> 3152155050</p> 

								<p><i class="fa fa-envelope"></i>  leonardo@dondepauto.co</p>	
							</div>
						</div>
					</div>
				</div>	
			</div>	
		</section>	
		<section id="rigths">
			<i class="fa fa-copyright"></i> {{ date("Y") }} | Todos los derechos reservados
		</section>	
	</footer>

	<script src="/assets/js/jquery-2.1.1.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>
	<script>
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

		$('#dinamic-quote').affix({
		    offset: {
		        top: $('#dinamic-quote').offset().top
		    }
		});	

		$(".arctic_scroll").arcticScroll({
            speed: 800
        });      
	</script>
@endsection