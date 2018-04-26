<?php
require_once('include/CestaCompra.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario'])) 
	die("Error - debe <a href='login.php'>identificarse</a>.<br />");

// Recuperamos la cesta de la compra
$cesta = CestaCompra::carga_cesta();

// Ponemos a disposición de la plantilla los datos necesarios
$usuario = $_SESSION['usuario'];
$productoscesta = $cesta->get_productos();
$coste = $cesta->get_coste();

?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Ejemplo Tema 6: Cesta de la Compra</title>
	<link href="tienda.css" rel="stylesheet" type="text/css">
</head>

<body class="pagcesta">

	<div id="contenedor">
		<div id="encabezado">
			<h1>Cesta de la compra</h1>
		</div>
		<div id="productos">
			<?php
			foreach ($productoscesta as $producto)
			{
				echo "<p>";
				echo "<span class='codigo'>".$producto->get_codigo()."</span>";
				echo "<span class='nombre'>".$producto->get_nombre()."</span>";
				echo "<span class='precio'>".$producto->get_PVP()."</span>
			</p>";
		}
		?>
		<hr />
		<p><span class='pagar'>Precio total: <?php echo $coste ?> €</span></p>
		<form action='pagar.php' method='post'>
			<p><span class='pagar'>
				<input type='submit' name='pagar' value='Pagar'/>
			</span></p>
		</form>
	</div>
	<br class="divisor" />
	<div id="pie">
		<form action='logoff.php' method='post'>
			<input type='submit' name='desconectar' value='Desconectar usuario'/>
		</form>        
	</div>
</div>
</body>
</html>
