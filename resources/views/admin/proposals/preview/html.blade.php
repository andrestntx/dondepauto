@extends('layouts.public')

@section('extra-css')
	<link rel="stylesheet" type="text/css" href="/assets/css/proposal/style.css">
@endsection

@section('content')
	<section class="quote modal-quote">
		<a class="btn btn-xs btn-default arctic_scroll" href="#dinamic-quote" id="quote-close"><i class="fa fa-times"></i></a>
		<h2>0 Medios seleccionados</h2>
		<div id="quote-total">
			<p>Total</p>
			<p id="quote-price"><span>0</span> IVA incluido</p>
		</div>
		<button class="btn btn-sm btn-danger" data-url="{{ route('proposals.select', $proposal) }}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Generando cotización"><i class="fa fa-file-pdf-o"></i> Descargar cotización</button>
	</section> 

	<header id="iva" data-iva="{{ env('IVA') }}">
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
					{{ $proposal->observations }}
				</p>	
				@if($proposal->has_observations_file)
                    <a href="/{{ $proposal->observations_file }}" target="_blank" ="" style="font-size: 1.2em; margin-bottom: 0.5em; display: block;">
                        <i class="fa fa-file-pdf-o"></i> Ver Presentación Complementaria
                    </a>	
               @endif
			</article>
		</section>
		<section id="target">
			<div class="white-cap">
				<div class="text-content">
					<h1> <strong>Target</strong> para la campaña
						<span class="border-title"></span>
					</h1>
					@foreach($proposal->spaceAudiences->groupBy("type_name") as $type => $audiences)
						<div class="target">
							<figure>
								<img src="{{ $audiences->first()->type_img }}" alt="{{ $type }}">
							</figure>
							<div class="audience-content">
								<h1>{{ $type }}</h1>
								<p class="audience-name">
									{{ $audiences->implode('name', ', ') }}
								</p>
							</div>
						</div>
					@endforeach	
						<div class="target">
							<figure>
								<img src="/assets/img/proposal/ciudades.png" alt="Ciudades">
							</figure>
							<div class="audience-content">
								<h1>Ciudades</h1>
								<p class="audience-name">
									{{ $proposal->cities->implode('name', ', ') }}
								</p>
							</div>
						</div>

						<div class="target">
							<figure>
								<img src="/assets/img/proposal/intereses.png" alt="Escenarios de impacto">
							</figure>
							<div class="audience-content">
								<h1>Escenarios de impacto</h1>
								<p class="audience-name">
									{{ $proposal->impactScenes->implode('name', ', ') }}
								</p>
							</div>
						</div>
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
					@foreach($proposal->viewSpaces->sortByDesc('publisher_company') as $space)
						<article {!! Html::classes(['publisher', 'publisher-selected' => $space->pivot->selected]) !!} data-price="{{ $space->proposal_prices_public_price }}" data-discount="{{ $space->proposal_prices_discount_price }}" data-publisherId="{{ $space->id }}">
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
									<img src="{{ $space->first_image }}" alt="">
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

									@if($space->proposal_prices_discount > 0)
										<p class="publisher-public-price">
											Precio Normal: <span>$ {{ number_format($space->prices_public_price, 0, '.', ',') }} </span> por {{ $space->period }} 
										</p>
										<p class="publisher-price">
											Precio con Descuento: <span>$ {{ number_format($space->proposal_prices_public_price, 0, '.', ',') }} </span> por {{ $space->period }} 
										</p>
									@else 
										<p class="publisher-price">
											Precio Normal: <span>$ {{ number_format($space->proposal_prices_public_price, 0, '.', ',') }} </span> por {{ $space->period }} 
										</p>
									@endif

									<button data-url="{{ route('proposals.spaces.select', [$proposal, $space]) }}" class="btn btn-sm btn-success btn-select"> 		
										@if($space->pivot->selected) 
											Seleccionado 
										@else 
											<i class="fa fa-check-square-o"></i> Seleccionar
										@endif
									</button>

									<a href="{{ $space->url_marketplace }}" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> Ver más</a>
								</div>	
							</div>
							
						</article>
					@endforeach
				</div>
			</section>

			<section class="quote content col-xs-12 col-md-4 scrollspy">
				<div data-spy="top-affix" id="dinamic-quote">
					<div class="quote-content" >
						<h1>Medios seleccionados</h1>
						<h2>0 Medios seleccionados</h2>
						
						<div id="quote-subtotal" class="col-xs-12">
							<div class="row">
								<div class="col-xs-offset-3 col-xs-4 col-md-offset-2">
									<p>Subtotal</p>
								</div>
								<div class="col-xs-5 col-md-6">
									<p id="quote-subtotal-price">0</p>
								</div>
							</div>
						</div>	
						
						<div id="quote-iva" class="col-xs-12">
							<div class="row">
								<div class="col-xs-offset-3 col-xs-4 col-md-offset-2">
									<p>IVA</p>
								</div>
								<div class="col-xs-5 col-md-6">
									<p id="quote-iva-price">0</p>
								</div>
								</div>
						</div>	
						
						<div id="quote-total" class="col-xs-12">
							<div class="row">
								<div class="col-xs-offset-3 col-xs-4 col-md-offset-2">
									<p>Total</p>
								</div>
								<div class="col-xs-5 col-md-6">
									<p id="quote-price">0</p>
								</div>
							</div>
						</div>
						
						<p class="notes">* Para recibir más información y realizar la compra comunicate con nuestra área encargada</p>
						
						<button class="btn btn-sm btn-danger" data-url="{{ route('proposals.select', $proposal) }}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Generando cotización"><i class="fa fa-file-pdf-o"></i> Descargar cotización</button>
					</div>	

					<div id="total-discount">
						<span class="total-discount-text">* Con DóndePauto ahorras:</span>
						<span class="total-discount-price">0</span>
					</div>
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
						<figure id="photo" class="col-xs-offset-1 col-sm-offset-2 col-md-offset-1 col-xs-3 col-md-2" style="display: inline-block; vertical-align: middle; float: none;">
							<img src="/assets/img/proposal/imagenleo.png" alt="">	
						</figure>
						<div id="data" class="col-xs-8 col-sm-6 col-md-8" style="display: inline-block; vertical-align: middle; float: none;">
							<div id="contact-role" class="col-xs-12 col-md-6">
								<h1>Leonardo Rueda Plazas</h1>	
								<h2>Director General de Marketing</h2>
							</div>
							
							<div id="contact-numbers" class="col-xs-12 col-md-6">
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
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
	<script src="/assets/js/plugins/number/jquery.number.min.js"></script>
	<script src="/assets/js/services/proposal/preview.js"></script>
	
	<script>
	    $(document).ready(function() {
            PreviewService.init();
        });
	</script>

@endsection