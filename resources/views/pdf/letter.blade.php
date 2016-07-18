<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
	<style type="text/css">
		body {
			text-align: justify;
			font-family: arial;
		}
		.uppercase {
			text-transform: uppercase;
		}
		.container {
			margin: 20px 30px 0px 30px;
			font-size: 15px;
		}
		.container .footer: {
			font-size: 12.5px;
			color: #636363;
			font-style: italic;
		}
	</style>
</head>
<body>
	<div class="container">
		<p>Bogotá, {{ $date }}</p><br>
		
		<p>
			Señores<br>
			<strong class="uppercase">dondepauto S.A.S.</strong><br>
			NIT: 900.774.988-7<br>
			<strong>Sr. Freddy Alexander Niño Rueda. Representante Legal</strong><br>
			Bogotá
		</p>
		
		<p>Estimados Señores,</p>

		<p>Yo, <strong class="uppercase">{{ $publisher->representative->name }}</strong>, identificado con cédula de ciudadanía No. {{ $publisher->representative->doc }}, en calidad de representante legal de la empresa <strong>{{ $publisher->company_legal }}</strong>, sociedad comercial, domiciliada en la ciudad de {{ $publisher->city->name }} e identificada con <strong>NIT. No. {{ $publisher->company_nit }}</strong>, manifiesto que cuento con las
		autorizaciones legales y estatutarias necesarias para obligar a la sociedad que represento, que
		disponemos de capacidad legal y operativa para comercializar o promover la oferta de espacios
		publicitarios a nuestro cargo, y que nos encontramos interesados en dar a conocer nuestra oferta
		de medios a través de DóndePauto.Co con el objeto de lograr negocios efectivos con las empresas
		anunciantes clientes de DóndePauto.</p>

		<p>Por medio de la presente carta de aceptación autorizo a {{ $publisher->company_legal }} para el uso de la
		plataforma <a href="http://www.dondepauto.co">www.dondepauto.co</a> para la presentación de nuestros medios, de conformidad con los
		“Términos y Condiciones de la Plataforma”, los cuales manifestamos conocer. De acuerdo con lo
		anterior:</p>

		<ul>
			<li>{{ $publisher->company_legal }} <strong>acepta pagar a DONDEPAUTO un incentivo económico equivalente al {{ $publisher->commission_rate }}% 
				más IVA</strong>, de la inversión en publicidad que reciba {{ $publisher->company_legal }} por las ventas referenciadas o 
				gestionadas por DONDEPAUTO que hayan sido efectivamente facturadas y cobradas por 
				nuestra empresa. Cualquier variación en volúmenes la anexamos a esta carta, con firma.
			</li>

			<li>
				Autorizo a <strong class="uppercase">{{ $publisher->name }}</strong>, para actuar en nombre de nuestro Medio 
				Publicitario, llevar a cabo la transmisión o publicación de nuestras ofertas en la Plataforma, y
				ser el canal comercial con DóndePauto.
			</li>

			<li>
				Autorizo para que cualquier notificación relevante respecto a modificaciones en las condiciones
				de la Plataforma, métricas d de negociaciones comerciales y ventas finalizadas, o cualquier
				modificación a nuestra cuenta de usuario, me sean notificadas a: <strong>{{ $publisher->representative->email }}</strong>
			</li>
		</ul>

		<br><br><br>
		<p>____________________________________<br>
			<span class="uppercase">{{ $publisher->representative->name }} </span><br>
			<strong>Representante Legal</strong><br>
			{{ $publisher->company_legal }}<br>
			{{ $publisher->city->name }}<br>
			{{ $publisher->address }}<br>
			{{ $publisher->representative->phone }}
		</p>

		<p class="footer">Enviar esta carta de aceptación original firmada a la siguiente dirección:<br>
			<strong>Carrera 11 A #119–35, Piso 2 A. Santa Bárbara, Bogotá. Teléfono: (1) 6 31 41 63. DóndePauto SAS.</strong><br>
			Dirigida a: Freddy Alexander Niño Rueda, Rep. Legal, Director Ejecutivo. DóndePauto SAS<br>
			<strong>Nota:</strong> Esta carta se validará junto con la información de Cámara de Comercio y RUT registrada por el MEDIO
			PUBLICITARIO en la Plataforma.
		</p>
	</div>
</body>
</html>