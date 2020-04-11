<?php
require_once('estadisticasProductos.php');

$productosMayorPrecioVendido = productosMasVendidos();
$ventas = cargarVentas($productosMayorPrecioVendido);
//strtolower(fread(STDIN, 100));

opcion2($productosMayorPrecioVendido);
opcion3($ventas);
?>
