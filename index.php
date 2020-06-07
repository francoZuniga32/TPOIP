<?php

/* * *
 * Trabajo Practico Obligatorio TUASySL
 * Ojeda Zuñiga Franco Agustin fai-1898
 */

//cargamos el arreglo de productos y ventas
$productos = productosMasVendidos();
$ventas = cargarVentas($productos);

do {
    //mostramos una opcion del menu
    menu();
    $opcion = intval(fread(STDIN, 100));
    //dada la opcion ejecutamos dicho algoritmo
    switch ($opcion) {
        case 1:
            //opcion 1 del inciso
            $arregloOpcion1 = opcion1($productos, $ventas);
            $ventas = $arregloOpcion1[0];
            $productos = $arregloOpcion1[1];
            break;
        case 2:
            //opcion 2 del inciso
            opcion2($productos);
            break;
        case 3:
            //opcion 3 del inciso
            opcion3($ventas);
            break;
        case 4:
            //opcion 4 del inciso
            opcion4($productos, $ventas);
            break;
        case 5:
            //opcion 5 del inciso
            uasort($productos, 'compararPrecios');
            print_r($productos);
            break;
        default :
            echo "Ingrese una opcion valida!!";
            break;
    }
    echo "\n desea continuar? s/n";
    $continuar = strtolower(trim(fgets(STDIN)));
} while (strcmp($continuar, 's') == 0);

/**
 * Precargamos la estructura de los productos mas vendidos por meses [0-11]
 * @return [arreglo] [retornamos el arreglo de los productos mas vendidos por meses]
 */
function productosMasVendidos() {
    $produstosMasVendos = array(
        array("prod" => 'Heladera frezer', "precioProd" => 7000, "cantProd" => 15),
        array("prod" => 'Alcatel 1156', "precioProd" => 8000, "cantProd" => 12),
        array("prod" => 'Televisor Philip', "precioProd" => 15000, "cantProd" => 5),
        array("prod" => 'Aire Acondicionado', "precioProd" => 12000, "cantProd" => 4),
        array("prod" => 'Freezer Industrial', "precioProd" => 20000, "cantProd" => 2),
        array("prod" => 'Horno Electrico', "precioProd" => 14000, "cantProd" => 5),
        array("prod" => 'Microhondas', "precioProd" => 12000, "cantProd" => 6),
        array("prod" => 'Licuadora', "precioProd" => 900, "cantProd" => 20),
        array("prod" => 'Tostadora', "precioProd" => 1000, "cantProd" => 15),
        array("prod" => 'Batidora', "precioProd" => 5000, "cantProd" => 50),
        array("prod" => 'Televisor Hitachi', "precioProd" => 9000, "cantProd" => 110),
        array("prod" => 'Mac', "precioProd" => 20000, "cantProd" => 16),
    );

    return $produstosMasVendos;
}

/* * *
 * cargamos los datos
 */

function cargarVentas($arregloProductos) {
    //creamos un arreglo de ventas
    $ventas = array();

    foreach ($arregloProductos as $producto) {
        array_push($ventas, $producto['precioProd'] * $producto['cantProd']);
    }

    return $ventas;
}

function menu() {
    echo "
  1. Ingresa la venta de un producto (mes, nombre producto, precio, cantidad vendida)
  2. Mostramos informacion del producto mas vendido en el año.
  3. Mustra el primer mes que supera el monto total de ventas dado por teclado
  4. Imprimir la informacion de un mes dado por el usuario
  ";
}

/**
 * primera opcion del menu el cual lo que vamos a hacer es, obtener los datos de un producto
 * para un mes
 * @return [type] [description]
 */
function opcion1($arregloProductos, $arregloVentas) {
    //pedimos los datos del producto
    echo "Ingrese el mes de la venta [enero-febrero] (en caso de escribirlo mal este se ponda en enero)";
    $mesLeido = strtolower(trim(fgets(STDIN)));
    echo 'ingrese un mes adecuado!!';
    $mes = mesToNumero($mesLeido);
    echo "Ingrese el nombre del producto vendido:\n";
    $producto = strtolower(trim(fgets(STDIN)));
    echo "Ingrese el precio de dicho producto:\n";
    $precio = intval(fread(STDIN, 100));
    echo "Ingrese la cantidad vendida:\n";
    $cantidad = intval(fread(STDIN, 100));
    //funcion calculando e
    return opcion1Operador($arregloVentas, $arregloProductos, $mes, $producto, $precio, $cantidad);
}

/**
 * es la operaicion que se nececita en la operacion 1 en em menu:
 * 1. vamos a evaluar si las ventas de este producto son mayoreas a la que estan en ese meses
 * 2. vamos a incrementar las ventastotales del mes
 * @param  [type] $arregloVentas    [description]
 * @param  [type] $arregloProductos [description]
 * @param  [type] $producto         [description]
 * @param  [type] $precio           [description]
 * @param  [type] $cantidad         [description]
 * @return Array                    [arreglo[0]arreglo de ventas actualizado, arreglo[1] arreglo de productos actualizado]
 */
function opcion1Operador($arregloVentas, $arregloProductos, $mes, $producto, $precio, $cantidad) {
    $arreglos = array();
    echo $mes;
    //vamos a obtener las ventas totales del producto ingresado para el mes ingresado
    $totalPrecioProductoEvaluar = $precio * $cantidad;
    //vamos a obtener las ventas totales del producto mas vendido en el mes ingresado
    $totalPrecioProductoMes = $arregloProductos[$mes]['precioProd'] * $arregloProductos[$mes]['cantProd'];
    // si las ventas del mes ingresado superan las del mes almacenado, cambiamos los productos
    if ($totalPrecioProductoEvaluar > $totalPrecioProductoMes) {
        $arregloProductos[$mes]['prod'] = $producto;
        $arregloProductos[$mes]['precioProd'] = $precio;
        $arregloProductos[$mes]['cantProd'] = $cantidad;
    }

    //incrementamos las ventas totales de ese mes
    $arregloVentas[$mes] = $totalPrecioProductoEvaluar;

    array_push($arreglos, $arregloVentas);
    array_push($arreglos, $arregloProductos);
    return $arreglos;
}

/**
 * mostramos la informacion del mes con mayores ventas
 * @param  Array $arregloProductos  el arreglo de productos mas vendidos por mes
 * @return void
 */
function opcion2($arregloProductos) {
    //vamos a usar una variable para guardar el mayor precio
    $mayorPrecio = $arregloProductos[0]['precioProd'] * $arregloProductos[0]['cantProd'];
    $indiceMayor = 0;

    //vamos a recorrer el arreglo guardando esta variable
    for ($i = 0; $i < count($arregloProductos); $i++) {
        if ($mayorPrecio <= ($arregloProductos[$i]['precioProd'] * $arregloProductos[$i]['cantProd'])) {
            $indiceMayor = $i;
            $mayorPrecio = $arregloProductos[$i]['precioProd'] * $arregloProductos[$i]['cantProd'];
        }
    }

    echo "El producto con mayor venta del año es:";
    echo "Producto: " . $arregloProductos[$indiceMayor]['prod'] . " Precio: " . $arregloProductos[$indiceMayor]['precioProd'] . " Cantidad: " . $arregloProductos[$indiceMayor]['cantProd'];
}

/**
 * nos muestra el mes con mayores ventas a una ingresada por el usuario
 * @param  Array  $arregloVentas arreglo de las ventas mensuales
 * @return void                 
 */
function opcion3($arregloVentas) {
    //pedimos un monto a la persona
    echo "Ingrese un monto a superar:\n";
    $montoTeclado = intval(fread(STDIN, 100));
    $indiceMayor = 0;
    $control = true;
    $i = 0;
    //recorremos el arreglo para poder ubicar este mes
    while ($i < count($arregloVentas) && $control) {
        if ($arregloVentas[$i] >= $montoTeclado) {
            $indiceMayor = $i;
            $control = false;
        }
        $i = $i + 1;
    }

    echo "El mes que supera el monto es: " . numeroToMes($indiceMayor);
}

/* * *
 * 
 */

function opcion4($arregloProductos, $arregloVentas) {
    //vamos a solicitar un mes
    echo "ingrese un mes a imprimir:\n";
    $nombreMes = strtolower(fread(STDIN, 100));
    $mes = mesToNumero($nombreMes);
    if ($mes >= 0 && $mes <= 11) {
        //vamos a imprimir la informacion de ese mes
        echo
        "<$nombreMes>
        El producto con mayor monto de venta: " . $arregloProductos[$mes]['prod'] . "
        Cantidad de Productos Vendidos: " . $arregloProductos[$mes]['cantProd'] . "
        Precio Unitario: $" . $arregloProductos[$mes]['precioProd'] . "
        Monto de venta del producto: $" . $arregloProductos[$mes]['cantProd'] * $arregloProductos[$mes]['precioProd'] . "
        Monto acumulado de ventas del mes diciembre: $" . $arregloVentas[$mes];
    } else {
        echo "ingrese un mes valido!!";
    }
}


function compararPrecios($producto1, $producto2){
    $mayorPrecio1 = $producto1['precioProd'] * $producto1['cantProd'];
    $mayorPrecio2 = $producto2['precioProd'] * $producto2['cantProd'];
    $retorno = 0;
    
    if ($mayorPrecio1 != $mayorPrecio2) {
        $retorno = ($mayorPrecio1 > $mayorPrecio2) ? -1 : 1;
    }
    
    return $retorno;
}

/**
 * dado un numero, obtenemos el mes correspondiente
 * @param  Int $numero el numero del mes que queremos recuperar
 * @return String      el mes resultado del pedido
 */
function numeroToMes($numero) {
    $retorno;
    switch ($numero) {
        case 0:
            $retorno = "enero";
            break;
        case 1:
            $retorno = "febrero";
            break;
        case 2:
            $retorno = "marzo";
            break;
        case 3:
            $retorno = "abril";
            break;
        case 4:
            $retorno = "mayo";
            break;
        case 5:
            $retorno = "junio";
            break;
        case 6:
            $retorno = "julio";
            break;
        case 7:
            $retorno = "agosto";
            break;
        case 8:
            $retorno = "septiembre";
            break;
        case 9:
            $retorno = "octubre";
            break;
        case 10:
            $retorno = "noviembre";
            break;
        case 11:
            $retorno = "diciembre";
            break;
        default:
            $retorno = "enero";
            break;
    }
    return $retorno;
}

/**
 * dado un mes retornamos el numero correspondiente, ojo este retorna entre 0-11
 * @param  String $mes  el mes que queremos pasa a numero
 * @return Int      el numero correspondiente al mes
 */
function mesToNumero($mes) {
    $retorno = 0;
    switch ($mes) {
        case "enero":
            $retorno = 0;
            break;
        case "febrero":
            echo "Aqiu";
            $retorno = 2;
            break;
        case "abril":
            $retorno = 3;
            break;
        case "mayo":
            $retorno = 4;
            break;
        case "junio":
            $retorno = 5;
            break;
        case "julio":
            $retorno = 6;
            break;
        case "agosto":
            $retorno = 7;
            break;
        case "septiembre":
            $retorno = 8;
            break;
        case "octubre":
            $retorno = 9;
            break;
        case "noviembre":
            $retorno = 10;
            break;
        case "diciembre":
            $retorno = 11;
            break;
    }
    return $retorno;
}

function listar($arregloProductos, $ventas) {
    for ($i = 0; $i < count($arregloProductos); $i++) {
        echo $arregloProductos[$i]['prod'] . "--\t\t" . $arregloProductos[$i]['precioProd'] . "--\t\t" . $arregloProductos[$i]['cantProd'] . "--\t\t" . $ventas[$i] . "\n";
    }
}

?>
