@extends('layouts.public')

@section('extra-css')
	<style type="text/css">
		
		body {
			font-size: 16px;
		}

		h1 {
			color: #14abe4;
			font-size: 1.2em;
			font-weight: 400;
			margin: 0;
			text-align: center;
		}

		header {
			background-image: url("/assets/img/proposal/bannerprincipal.png");
			background-repeat: no-repeat;
    		background-size: cover;
    		min-height: 200px;
			padding-bottom: 1em;
			width: 100%;
			background-position: center center;
		}

		header nav {
			background-color: rgba(68, 68, 68, 0.56);
			padding: 0.8em 3%;
		}

		header section#quote_title {
		    display: block;
		    background: rgba(255, 255, 255, 0.9);
		    font-size: 16px;
		    margin: 2em auto;
		    padding: 1.4em 5%;
		    text-align: center;
		    width: 90%;
		}

		header section#quote_title h1 {
		    margin: 0;
		}

		header section#quote_title h1 span {
		    font-size: 1.4em;
		    font-weight: bold;
		}

		header figure.logo {
			width: 170px;
		}

		figure img {
			width: 100%;
		}

		figure#logo-blue {
		    width: 40%;
		    margin: auto;
		}

		main {
			background-color: white;
		}

		main section {
			padding: 1.2em 5%;
		}

		section#contact {
			background-image: url("/assets/img/proposal/imagencontacto.jpg");
			background-repeat: no-repeat;
    		background-size: cover;
    		background-position: center center;
    		padding: 0;
		}



		section#contact #data h1 {
		    text-align: left;
		    color: #404040;
		    font-weight: bold;
		    font-size: 1em;
		}

		section#contact #data h2 {
			font-size: 1em;
			margin: 0.5em 0;
			font-weight: 200;
			color: #4a4949;
		}

		section#contact #data p {
			color: #505050;
		    font-size: 0.85em;
		    font-weight: 400;
		    margin: 0.5em 1em 0 0;
		    float: left;
		}

		section#contact #data i.fa {
			font-size: 1.4em;	
		}

		section#contact .row {
		    margin-top: 1.5em;
		}

		section#contact .white-cap {
			padding: 1.5em 2%;
			background-color: rgba(255, 255, 255, 0.9);
		}

		section.content {
			text-align: center;
		}

		section.content h1 {
			margin-bottom: 1em;
		}

		section.content p {
			font-size: 1em;
		}

		section#publishers .publisher {
			border-bottom: 2px solid #d2d2d2;
			margin: 1em 0;
			padding-bottom: 1em;
		}

		section#publishers article:first-of-type {
			margin-top: 2em;
		}
		

		section#publishers .publisher figure, 
		section#publishers .publisher .publisher-content {
			display: inline-block;
			vertical-align: top;
		}

		section#publishers .publisher figure{
			width: 39%;
			display: inline-block;
			vertical-align: top;
		}

		section#publishers .publisher .publisher-content {
			width: 59%;
			display: inline-block;
			vertical-align: top;
		}

		section#publishers .publisher .publisher-content .btn {
		    float: left;
		    margin-left: 1em;
		    font-weight: bold;
		}

		section#publishers .publisher .publisher-content h1 {
			color:#3a3a3a;
			font-size: 0.95em;
			font-weight: bold;
			margin-bottom: 0.5em;
			text-align: left;
		}

		section#publishers .publisher .publisher-content p {
			text-align: justify;
			font-size: 0.9em;
		}

		section#publishers .publisher .publisher-content p.publisher-format {
			font-size: 0.83em;
		    color: #848484;
		    font-weight: 400;
		    margin: 0;
		}

		section#publishers .publisher .publisher-content p.publisher-description {
			margin-top: 0.7em;
		}

		section#publishers .publisher .publisher-content p.publisher-price {
		    font-size: 1em;
		    font-weight: 500;
		    color: #616060;
		    float: left;
		    margin: 0.25em 0 0 0;
		}

		ul.publisher-dimensions {
			list-style: none;
			padding-left: 0;
		}

		ul.publisher-dimensions li {
		    font-size: 0.85em;
		    text-align: left;
		}

		ul.publisher-dimensions li:before {
		    content: "•";
		    color: #14abe4;
		    padding-right: 0.3em;
		    font-size: 1.5em;
		}

		section#rigths {
			background-color: #14abe4;
			color: white;
			text-align: right;
			font-size: 0.85em;
			padding: 0.6em 1em;
		}

		section#target {
			background-image: url("/assets/img/proposal/imagentarget.jpg");
			background-repeat: no-repeat;
    		background-size: cover;
    		background-position: center top;
    		padding: 0;
		}

		section#target .target {
		    display: inline-block;
		    margin-bottom: 1em;
		    margin-right: 2%;
		    width: 47%;
		}

		section#target .target .audience-content {
		    display: inline-block;
		    vertical-align: top;
		    width: 68%;
		}

		section#target .target figure {
		    width: 25%;
		    display: inline-block;
		    margin-right: 2%;
		    vertical-align: top;
		}

		section#target .target h1,
		section#target .target p {
		    text-align: left;
		}

		section#target .target h1 {
		    color: gray;
		    font-size: 1em;
		    margin: 0;
		    font-weight: 500;
		}

		section#target .target p.audience-name {
		    color: #00aff1;
		    font-weight: 400;
		    margin: 0.2em 0 0 0;
		}

		section#target, section#target .white-cap {
    		min-height: 200px; 
		}

		section#target h1 {
			margin-bottom: 1em;
		}


		span.border-title {
			border-bottom: 2px solid #14abe4;
			display: block;
			margin: auto;
			padding-bottom: 0.3em;
			width: 45%;
		}

		.white-cap {
			background-color: rgba(255, 255, 255, 0.85);
			padding: 1em 5%;
		}

		@media only screen and (min-width: 700px) {
		    h1 {
			    font-size: 1.4em;
			}

			header figure.logo {
			    width: 220px;
			}

			header nav {
			    padding: 1.2em 3%;
			}

			header section#quote_title {
			    margin: 4em auto;
			    padding: 1.5em 5%;
			}

			main section {
			    padding: 2.5em 5%;
			}


			section#contact #data h1 {
			    font-size: 1.4em;
			}

			section#contact #data h2 {
			    font-size: 1.2em;
			}

			section#contact #data p {
			    font-size: 1em;
			}

			section#contact .row {
			    margin-top: 2.2em;
			}

			section.content h1 {
			    margin-bottom: 1.4em;
			}

			section.content p {
			    font-size: 1.1em;
			}

			section#publishers .publisher {
			    margin: 2em 0;
			    padding-bottom: 2em;
			}

			section#publishers .publisher .publisher-content .btn {
			    font-size: 0.9em;
			}

			section#publishers .publisher .publisher-content p.publisher-format {
			    font-size: 0.9em;
			}

			section#publishers .publisher .publisher-content p.publisher-price {
			    font-size: 1.1em;
			}

			section#publishers .publisher .publisher-content h1 {
			    font-size: 1.15em;
			}

		    section#target .target {
			    margin-right: 1%;
			    width: 31%;
			}

			ul.publisher-dimensions li {
			    font-size: 0.9em;
			}

			.text-content {
				max-width: 1200px;
				margin: auto;
			}

			.white-cap {
			    padding: 2em 5%;
			}
		}

		@media only screen and (min-width: 850px) {
		    header section#quote_title {
			    margin: 6em auto;
			    padding: 2em 5%;
			}

			main section {
			    padding: 3.2em 6%;
			}
		}

		@media only screen and (min-width: 900px) {
		    
		    section#contact #data {
			    margin-top: 0;
			}

			section#contact #data p {
			    margin-top: 0;
			    margin-bottom: 0.4em;
			}

			section#contact .white-cap {
			    padding: 3em 2% 1em 2%;
			    background-color: rgba(255, 255, 255, 0.9);
			}

			section#rigths {
			    font-size: 1em;
			    padding: 1em;
			}

			section#target h1 {
			    margin-bottom: 2.5em;
			}

			section#target .target {
			    margin-right: 1%;
			    width: 23%;
			}

			section#target .target h1 {
			    font-size: 1.1em;
			    font-weight: 600;
			}

			section#target .target p.audience-name {
			    color: #049cd6;
			    font-weight: 400;
			}

		    .white-cap {
			    padding: 2.5em 5%;
			}
		}

		@media only screen and (min-width: 1000px) {
			h1 {
			    font-size: 1.5em;
			}

			header section#quote_title {
			    max-width: 700px;
			    width: 60%;
			    margin: 12em auto;
    			padding: 1.5em 5%;
			}

			header section#quote_title h1 span.border-title {
			    width: 33%;
			}

			section#contact #data p {
			    margin: 0 12% 0.5em 0;
			}

			section#contact .white-cap {
			    padding: 4em 2% 1em 2%;
			}

			section#contact figure#photo img {
				width: 80%;
   				margin: 0 10%;
			}

			section#target h1 {
			    margin-bottom: 3em;
			    font-size: 1.5em;
			}

			section#target .target h1 {
			    font-size: 1.2em;
			}

			section#target .target p.audience-name {
			    font-size: 1.1em;
			}

			span.border-title {
			    border-bottom: 3px solid #14abe4;
			    padding-bottom: 0.4em;
			    width: 15%;
			}
		    
		}

	</style>
@endsection

@section('content')
	<header>
		<nav>
			<figure class="logo">
				<img src="/assets/img/proposal/logotodoblanco.png" alt="">
			</figure>
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
		<section id="publishers" class="content text-content">
			<h1><strong>Medios</strong> para la campaña
				<span class="border-title"></span>
			</h1>
			<p>
				Según el tipo de producto, el perfil del cliente y su presupuesto; proponemos los siguientes medios:
			</p>
			@foreach($proposal->viewSpaces as $space)
				<article class="publisher">
					<figure>
						<img src="http://system.dondepauto.co/images/marketplace/big/1147755221461611361.png" alt="">
					</figure>
					<div class="publisher-content">
						<h1>{{ $space->pivot_title }}</h1>
						<p class="publisher-format">
							{{ $space->sub_category_name }} / {{ $space->format_name }}
						</p>
						@if($space->dimensions)
							<ul class="publisher-dimensions">
								<li>
									{{ $space->dimensions }}
								</li>
							</ul>
						@endif
						<p class="publisher-description">
							{!! $space->pivot_description !!}
						</p>
						<p class="publisher-price">
							$ {{ number_format($space->pivot_public_price, 0, ',', '.') }} 
						</p>
						<a href="{{ $space->url_marketplace }}" target="_blank" class="btn btn-sm btn-warning">Ver más</a>
					</div>
				</article>
			@endforeach
		</section>
	</main>

	<footer>
		<section id="contact">
			<div class="white-cap">
				<div class="text-content">
					<figure id="logo-blue">
						<img src="/assets/img/logodonde.png" alt="Logo DóndePauto">	
					</figure>
					<div class="row">
						<figure id="photo" class="col-xs-offset-1 col-xs-3 col-md-2">
							<img src="/assets/img/proposal/imagenleo.png" alt="">	
						</figure>
						<div id="data" class="col-xs-7 col-sm-offset-1 col-sm-6 col-md-offset-0 col-md-8">
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

@endsection