@extends('layouts.pdf')

@section('css')
	<style type="text/css">
		
		body {
			font-size: 16px;
			font-family: Arial;
		}

		header {
			padding: 0 1em;
			margin-bottom: 22px;
		}

		header, header #title {
			display: block;
		}

		header #description {
			
		}

		header #description #advertiser {
			font-weight: 100;
    		font-size: 1.02em;
    		color: #383838;
    		margin-bottom: 10px;
		}

		header #description #proposal {
    		color: #636363;
    		font-weight: 100;
    		font-size: 1.05em;
    		margin-bottom: 0px;
		}

		header figure#logo {
			margin-left: 0;
			max-width: 250px;
		}

		header #title {
			margin-top: 20px;
			margin-bottom: 10px;
		}

		header #title .text-title {
			vertical-align: middle;
			display: inline-block;
			width: 49%;
		}

		header #title .text-title h1 {
    		font-weight: 400;
    		font-size: 1.15em;
		}

		header #title .text-title h1, header #title .text-title p {
			margin:0;
			color: #565555;
		}

		header #title .text-title p {
			text-align: right;
			font-weight: 100;
			font-size: 1.2em;
		}

		header #title .text-title.text-date p {
			font-size: 1.05em;
		}

		figure img {
			width: 100%;
		}

		#observations {
			padding: 6px 10px 15px 6px;
    		background: #f7f7f7;
    		display: block;
    		margin-bottom: 0px;
		}

		#observations h1 {
			font-size: 0.9em;
			color:gray;
		}

		#observations p {
			font-size: 0.64em;
			font-style: italic;
			margin: 0;
			color: #6d6d6d;
		}

		p.signature_line {
			border-top: 1px solid gray;
			width: 100%;
			display: block;
			text-align: center;
			padding-top: 5px;
			margin-bottom: 60px;
		}

		#signatures {
			display: block;
			width: 100%;
			overflow: auto;
		}

		#signatures #company #company_data p {
			font-size: 0.85em;
			margin: 0;
		}

		#signatures figure#company_signature {
			max-width: 65px;
		    margin: 0;
		    margin-bottom: 10px;
		}

		#signatures #company{
			width: 49%;
			display: block;
		}

		.sincerely {
			font-size: 1.04em;
			margin-bottom: 15px;
			color: #5f5f5f;
		}

		#spaces {
			margin-bottom: 10px;
		}

		#spaces table tr th {
			font-size: 0.75em;
			min-width: 200px;
		}

		#spaces table tr td {
			font-size: 0.75em;
			min-width: 200px;
		}

		#subtotal {
			width: 25%;
			margin-left: 75%;
			margin-bottom: 0px;
		}

		#subtotal table tr th, #subtotal table tr td {
			border: 0;
			padding: 0;
			text-align: right;
		}

		table tr#table-subtotal td {
			border: none;
		}

		.text-info {
			color: #1491c7; 
			font-weight: 600;
		}

	</style>
@endsection

@section('container')
	<?php 
	?>
	<header id="header" class="">
		<figure id="logo">
			<img src="https://gallery.mailchimp.com/dbb48a0358025693456baa4d9/images/b04040e6-57f4-4e52-9e3f-dff135c69378.png?_ga=1.258707594.1259824755.1470844641" alt="Logo DóndePauto">
		</figure>
		
		<div id="title">
			<div class="text-title">
				<h1>Propuesta de Medios Publicitarios</h1>	
			</div>
			<div class="text-title text-date">
				<p>Julio 29 del 2016</p>	
			</div>
		</div>

		<div id="description">
			<h2 id="advertiser"> <strong>{{ strtoupper($proposal->getAdvertiser()->company) }}</strong>, <br> {{ $proposal->advertiser_name }}, {{ $proposal->getAdvertiser()->company_role }}</h2>
			<h3 id="proposal">Ref: {{ $proposal->title }}</h3>
		</div>

	</header><!-- /header -->
	
	<main>
		<div id="spaces">
			<table>
				<thead>
					<tr>
						<th>Producto o servicio</th>
						<th>Descripción</th>
						<th>Impactos</th>
						<th>Precio Oferta</th>
						@if($proposal->total_discount > 0)
							<th style="text-align: center;">Desc.</th>
						@endif
						<th>Precio Final</th>
					</tr>
				</thead>
				<tbody>
					@foreach($proposal->viewSpaces as $space)
						<tr>
							<td>{{ $space->pivot_title }}</td>
							<td>{{ $space->pivot_description }}</td>
							<td>{{ number_format($space->impacts, 0, ',', '.') }} / {{ $space->period }}</td>
							<td> $ {{ number_format($space->prices_public_price, 0, ',', '.') }} </td>
							@if($proposal->total_discount > 0)
								<td style="text-align: center;">-{{ $space->proposal_prices_discount * 100 }}%</td>
							@endif
							<td class="text-info"> $ {{ number_format($space->proposal_prices_public_price, 0, ',', '.') }} </td>
						</tr>
					@endforeach
						<tr id="table-subtotal">
							<td></td>
							<td></td>
							<td>Subtotales</td>
							<td> $ {{ number_format($proposal->total, 0, ',', '.') }} </td>
							@if($proposal->total_discount > 0)
								<td style="text-align: center;"></td>
							@endif
							<td class="text-info"> $ {{ number_format($proposal->pivot_total, 0, ',', '.') }} </td>
						</tr>
				</tbody>
			</table>
		</div>

		<div id="subtotal">
			<table>
				<tbody>
						<tr>
							<td class="text-info">Subtotal</td>
							<td class="text-info"> $ {{ number_format($proposal->pivot_total, 0, ',', '.') }} </td>
						</tr>
						<tr>
							<td>IVA</td>
							<td style="border-bottom: 1px solid gray;"> $ {{ number_format($proposal->pivot_total_iva, 0, ',', '.') }} </td>
						</tr>
						<tr>
							<td class="text-info">TOTAL</td>
							<td class="text-info"> $ {{ number_format($proposal->pivot_total_with_iva, 0, ',', '.') }} </td>
						</tr>
				</tbody>
			</table>
		</div>

		<section id="observations">
			<h1>Observaciones</h1>
			<p>**Impactos: Los valores establecidos en la columna Impactos son valores estimados en condiciones normales del mercado, no obstante, estos pueden variar.<br>
			- Vigencia de la propuesta (precios, descuenteos o Bonificados): 15 días hábiles a partir de fecha de envío.<br>
			- Para la ejecución de la campaña se requiere verificar el pago anticipado y la orden de servicio, con mínimo 10 días de anticipación.<br>
			- Término para Pagos: Pago de contado o anticipado. Cuenta Ahorros 658-32 03 12-11 de Bancolombia.<br>
			- Para pago a 30 días, se debe realizar el procedimiento para creación de cliente, verificación de solvencia y capacidad de pago. Puede tomar 10 días adicionales.<br>
			- "La remisión de la presente propuesta firmada por el representante legal, es prueba de la aceptación de la misma, caso en el cual hará las veces de orden de servicio"
			</p>
		</section>

		<section id="signatures">
			<section id="company">
				<p class="sincerely">Atentamente:</p>
				<figure id="company_signature">
					<img src="https://gallery.mailchimp.com/dbb48a0358025693456baa4d9/images/e7344d5d-1a38-4ddc-88fd-feaaf5f3ed20.png" alt="Foto Leonardo Rueda">
				</figure>
				<div id="company_data">
					<p><strong>Leonardo Rueda Plazas</strong></p>
					<p class="text-info">leonardo@dondepauto.co</p>
					<p>315 215 5050</p>
					<p><strong>DONDEPAUTO SAS</strong> - Nit 900.774.988-7</p>
					<p>Carrera 11a #119-35, Piso 2A</p>	
				</div>
			</section>
		</section>

	</main>


@endsection

@section('footer')

@endsection