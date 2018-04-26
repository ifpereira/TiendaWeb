<?php
require_once('include/DB.php');
require_once('include/CestaCompra.php');

// Recuperamos la información de la sesión
session_start();

// Y comprobamos que el usuario se haya autentificado
if (!isset($_SESSION['usuario'])) 
	die("Error - debe <a href='login.php'>identificarse</a>.<br />");

// Recuperamos la cesta de la compra
$cesta = CestaCompra::carga_cesta();

// Comprobamos si se ha enviado el formulario de vaciar la cesta
if (isset($_POST['vaciar'])) {
	unset($_SESSION['cesta']);
	$cesta = new CestaCompra();
}

// Comprobamos si se quiere añadir un producto a la cesta
if (isset($_POST['enviar'])) {
	$cesta->nuevo_producto($_POST['cod']);
	$cesta->guarda_cesta();
}

// Ponemos a disposición de la plantilla los datos necesarios
$usuario = $_SESSION['usuario'];
$productos = DB::obtiene_productos();
$productoscesta = $cesta->get_productos();

?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Ejemplo Tema 6: Listado de Productos</title>
	<link href="tienda.css" rel="stylesheet" type="text/css">
</head>

<body class="pagproductos">

	<div id="contenedor">
		<div id="encabezado">
			<h1>Listado de productos</h1>
		</div>

		<div id="cesta">      
			<h3><img src='cesta.png' alt='Cesta' width='24' height='21'> Cesta</h3>
			<hr />
			<?php
			if (empty($productoscesta)){
				echo "<p>Cesta vacía</p>";
			}
			else
			{
				foreach ($productoscesta as $producto)
					echo "<p>{$producto->get_codigo()}</p>";
			}
			?>

			<form id='vaciar' action='productos.php' method='post'>
				<?php
				if (empty($productoscesta)){
					echo "<input type='submit' name='vaciar' value='Vaciar Cesta' disabled='true' />";
				}
				else
				{
					echo "<input type='submit' name='vaciar' value='Vaciar Cesta' />";
				}
				?>
			</form>
			<form id='comprar' action='cesta.php' method='post'>
				<?php
				if (empty($productoscesta)){
					echo "<input type='submit' name='comprar' value='Comprar' disabled='true' />";
				}
				else{
					echo "<input type='submit' name='comprar' value='Comprar'/>";
				}
				?>
			</form> 
		</div>

		<div id="productos">
			<?php
			foreach ($productos as $producto)
			{
				echo "<p><form id='".$producto->get_codigo()."' action='productos.php' method='post'>";
				echo "<input type='hidden' name='cod' value='".$producto->get_codigo()."'/>";
				echo "<input type='submit' name='enviar' value='Añadir'/>
				".$producto->get_nombrecorto()." : ".$producto->get_PVP()." euros.</form></p>";
			}
			
			?>
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