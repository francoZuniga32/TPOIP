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
    echo ">> "; $opcion = intval(trim(fgets(STDIN)));
    $continuar = true;
    //dada la opcion ejecutamos dicho algoritmo
    switch ($opcion) {
        case 1:
            ingresarVenta($productos, $ventas);
            break;
        case 2:
            //opcion 2 del inciso
            productoMasVendido($productos);
            break;
        case 3:
            //opcion 3 del inciso
            mesSuperaMonto($ventas);
            break;
        case 4:
            //opcion 4 del inciso
            imprimirInformacionMes($productos, $ventas);
            break;
        case 5:
            //la opcion 5 del inciso
            ordenarPorductosMayorMonto($productos);
            break;
        case 6:
            //terminamos la ejecucion
            $continuar = false;
        default :
            echo "Ingrese una opcion valida!!";
            break;
    }
} while ($continuar);

/**
 * imprimimos el menu en pantalla
 * @return void
 */
function menu() {
    echo "
  ----------------------------------------------------------------------------------
  1. Ingresa la venta de un producto (mes, nombre producto, precio, cantidad vendida)
  2. Mostramos informacion del producto mas vendido en el año.
  3. Mustra el primer mes que supera el monto total de ventas dado por teclado
  4. Imprimir la informacion de un mes dado por el usuario
  5. Ordenar los productos de mayor a menor y muestra todos los productos
  6. Salir
  ";
}

/**
 * Precargamos la estructura de los productos mas vendidos por meses [0-11]
 * @return Array retornamos el arreglo de los productos mas vendidos por meses
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

/**
 * cargamos el arreglo de ventas con los productos iniciales
 * @param  Array $arregloProductos es le arreglo inicial de productos
 * @return Array                   arreglo de las ventas por meses
 */
function cargarVentas($arregloProductos) {
    //creamos un arreglo de ventas
    $ventas = array();

    foreach ($arregloProductos as $producto) {
        array_push($ventas, $producto['precioProd'] * $producto['cantProd']);
    }

    return $ventas;
}

/**
 * primera opcion del menu. ingresamos un productos para un mes, lo comparamos con
 * el producto del mes actual y si sus ventas sin mayores lo remplazamos, e
 * incrementamos el total de ventas de ese mes
 * @return void
 */
function ingresarVenta(&$arregloProductos, &$arregloVentas) {
    //pedimos los datos del producto
    $mes = ingresarMesValido();
    echo "Ingrese el nombre del producto vendido:\n";
    $producto = strtolower(trim(fgets(STDIN)));
    echo "Ingrese el precio de dicho producto:\n";
    $precio = intval(trim(fgets(STDIN)));
    echo "Ingrese la cantidad vendida:\n";
    $cantidad = intval(trim(fgets(STDIN)));
    //funcion calculando si el producto ingresado es el mas vendido y carga la venta
    operadorIngresarVenta($arregloVentas, $arregloProductos, $mes, $producto, $precio, $cantidad);
}

/**
 * pide que ingrese un mientras este no se valido
 * @return Number retorna el indice de mes ingresado por teclado
 */
function ingresarMesValido(){
    $control = true;
    $mesRetorno = 0;
    while($control){
        //pedimos los datos del producto
        echo "Ingrese el mes [enero-diciembre]:\n";
        $mesLeido = strtolower(trim(fgets(STDIN)));
        $mes = mesToNumero($mesLeido);
        if($mes > -1 && $mes < 12){
           $control = false;
           $mesRetorno = $mes;
        }
    }
    return $mes;
}

/**
 * operamos sobre los datos obtenidos anteriormente, si la ventas son mayores a
 * las del producto del mes este pasa a ser le producto del mes.Ademas de cargan
 * a las ventas del mes
 * @param  Array  $arregloVentas      Arreglo de productos mas vendidos
 * @param  Array  $arregloProductos   Arreglo de las ventas
 * @param  Number $mes                indice del mes ingresado
 * @param  String $producto           Nombre del producto ingresado
 * @param  Number $precio             Precio del producto ingresado
 * @param  Number $cantidad           Cantidad vendida del producto ingresado
 * @return void
 */
function operadorIngresarVenta(&$arregloVentas, &$arregloProductos, $mes, $producto, $precio, $cantidad) {
    $precioTotal = $precio * $cantidad;
    //vamos a obtener las ventas totales del producto mas vendido en el mes ingresado
    $precioTotalProductoAcutual = $arregloProductos[$mes]['precioProd'] * $arregloProductos[$mes]['cantProd'];
    // si las ventas del mes ingresado superan las del mes almacenado, cambiamos los productos
    if ($precioTotal > $precioTotalProductoAcutual) {
        $arregloProductos[$mes]['prod'] = $producto;
        $arregloProductos[$mes]['precioProd'] = $precio;
        $arregloProductos[$mes]['cantProd'] = $cantidad;
    }

    //incrementamos las ventas totales de ese mes
    $arregloVentas[$mes] = $arregloVentas[$mes] + $precioTotal;
}

/**
 * imprimimos informacion sobre el producto mas vendido
 * @param  Array $arregloProductos es el arreglo de productos donde buscar
 * @return void                   
 */
function productoMasVendido($arregloProductos) {
    //vamos a usar una variable para guardar el mayor precio
    $indice = masVendido($arregloProductos);

    echo "El producto con mayor venta del año es:";
    informacionMesProducto($arregloProductos[$indice]);
}

/**
 * retorna el indice del producto mas vendido
 * @param  [Array]  $productos arreglo de los productos donde buscar
 * @return [Number]            es el indice donde se encuentra el producto mas vendido
 */
function masVendido($productos){
    //vamos a usar una variable para guardar el mayor precio
    $mayorPrecio = $productos[0]['precioProd'] * $productos[0]['cantProd'];
    $indiceMayor = 0;
    $indice = 0;

    //vamos a recorrer el arreglo guardando esta variable
    foreach ($productos as $producto) {
        if ($mayorPrecio <= ($producto['precioProd'] * $producto['cantProd'])) {
            $mayorPrecio = $producto['precioProd'] * $producto['cantProd'];
            $indiceMayor = $indice;
        }
        $indice++;
    }
    return $indiceMayor;
}

/**
 * nos muestra el mes con mayores ventas a una ingresada por el usuario
 * @param  Array  $arregloVentas arreglo de las ventas mensuales
 * @return void
 */
function mesSuperaMonto($arregloVentas) {
    //pedimos un monto a la persona
    echo "Ingrese un monto a superar:\n";
    $montoTeclado = intval(trim(fgets(STDIN)));
    //recorremos el arreglo para poder ubicar este mes
    $mes = buscarMes($arregloVentas, $montoTeclado);

    if($mes > -1){
        echo "El mes que supera el monto es: " . numeroToMes($mes);
    } else {
        echo "no hay mes que supere el monto: ".$montoTeclado;
    }
}

/**
 * retorna el indice del primer mes que supera el monto pasado por parametro
 * @param  Array  $ventas el arreglo de ventas donde buscar
 * @param  Number $monto  el monto a superar
 * @return Number         el indice donde se encuentra el mes que supera el monto
 */
function buscarMes($ventas, $monto){
    $retorno = -1;
    $control = true;
    $i = 0;
    while($i < count($ventas) && $control){
        if($ventas[$i] >= $monto){
            $control = false;
            $retorno = $i;
        }
        $i++;
    }
    return $retorno;
}

/**
 * imprimosmos informacion de un mes ingresado por el usuario
 * @param  Array $arregloProductos [description]
 * @param  Array $arregloVentas    [description]
 * @return type                   [description]
 */
function imprimirInformacionMes($arregloProductos, $arregloVentas) {
    //vamos a solicitar un mes
    $mes = ingresarMesValido();
    if ($mes >= 0 && $mes <= 11) {
        //vamos a imprimir la informacion de ese mes
        echo "<". numeroToMes($mes).">";
        informacionMesProducto($arregloProductos[$mes]);
        informacionMesVentas($arregloVentas[$mes]);
    } else {
        echo "ingrese un mes valido!!";
    }
}

/**
 * mostramos la informacion de el producto ingresado.
 * @param  Array $mes es el producto ingresado
 * @return void      
 */
function informacionMesProducto($mes){
    echo"
    El producto con mayor monto de venta: " . $mes['prod'] . "
    Cantidad de Productos Vendidos: " . $mes['cantProd'] . "
    Precio Unitario: $" . $mes['precioProd'] . "
    Monto de venta del producto: $" . $mes['cantProd'] * $mes['precioProd'];
}

/**
 * mostramos las ventas dadas
 * @param  Number $venta las ventas a mostrar
 * @return void        
 */
function informacionMesVentas($venta){
    echo "\n Monto acumulado de ventas del mes: $" . $venta;
}

/**
 * ordenamos los productos de mayor a menor monto
 * @param  Array $produtos es el arreglo de productos a ordenar
 * @return void           
 */
function ordenarPorductosMayorMonto($produtos) {
    //copiamos el arreglo para no modificar el orden de los mesese
    $produtosCopia = copiarArreglo($produtos);
    //opcion 5 del inciso
    uasort($produtosCopia, 'compararPrecios');
    /*     * *
     * print_r : Imprime información legible para humanos sobre una variable
     * es mas rapido que hacer recorrer el arreglo con for ademas de que
     * puede sacar la dimencionalidad del arreglo (si tiene mas subarreglos
     * ya que usa funciones recursivas).
     */
    print_r($produtosCopia);
}

/**
 * es la funcoin que compara los precios de los productos
 * @param  Array $producto1 primer producto
 * @param  Array $producto2 segundo producto
 * @return Number           es el resultado de la comparacion
 */
function compararPrecios($producto1, $producto2) {
    $mayorPrecio1 = $producto1['precioProd'] * $producto1['cantProd'];
    $mayorPrecio2 = $producto2['precioProd'] * $producto2['cantProd'];
    $retorno = 0;

    if ($mayorPrecio1 != $mayorPrecio2) {
        $retorno = ($mayorPrecio1 > $mayorPrecio2) ? -1 : 1;
    }

    return $retorno;
}

/**
 * realiza una copia del arraglo provisto
 * @param  Array $arreglo es el arreglo a clonar o copiar
 * @return Array          es la copia de arreglo
 */
function copiarArreglo($arreglo){
    $produtosArrayObject = new ArrayObject($arreglo);
    return $produtosArrayObject->getArrayCopy();
}

/**
 * dado un numero, obtenemos el mes correspondiente
 * @param  Number $numero el numero del mes que queremos recuperar
 * @return String      el mes resultado del pedido
 */
function numeroToMes($numero) {
    $retorno = "";
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
            $retorno = "No Existe dicho Mes";
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
    $retorno = -1;
    switch ($mes) {
        case "enero":
            $retorno = 0;
            break;
        case "febrero":
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
