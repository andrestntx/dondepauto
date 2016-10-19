<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title></title>
	<style type="text/css">
		body {
			text-align: justify;
		}

		p, h1, h2, h3, span, td, th {
			font-family: Arial, Helvetica, sans-serif;
		}

		.uppercase {
			text-transform: uppercase;
		}

		.container {
			margin: 15px 15px 0px 15px;
			font-size: 15px;
		}

		.container .footer: {
			font-size: 12.5px;
			color: #636363;
			font-style: italic;
		}

		.page-break {
		    page-break-after: always;
		}
		
		table {
			border-spacing: 0;
  			border-collapse: collapse;
  			margin-bottom: 10px;
  			width: 100%;
		}

		table thead, table thead tr {
			background: #f9f9f9;
		}

		table tr td, table tr th {
			border-bottom: 1px solid #ddd;
  			line-height: 1.42857143;
  			padding: 5px;
  			text-align: left;
  			vertical-align: top;
		}

		table tr th {
			font-size: 0.82em;
			font-weight: 500;
		}

		table tr td {
			font-size: 0.9em;
		}



	</style>
	@yield('css')
</head>
<body>
	<div class="container">
		@yield('container')

		<p class="footer">
			@yield('footer')
		</p>
	</div>
</body>
</html>