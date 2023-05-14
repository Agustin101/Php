<?php

require_once("./pizza.php");
require_once("./pedido.php");
$pedidos = Pedido::CargarJson();
$pizzas = Pizza::CargarJson();
$consulta = $_GET['consulta'];

if (is_array($pedidos) && $consulta === "cantidad") {
    $total = 0;
    foreach ($pedidos as $pedido) {
        $total += $pedido->cantidad;
    }

    echo "El total de pizzas vendidas es: " . $total;
} else if ($consulta === "ventasFechas") {
    $desde = $_GET["desde"];
    $hasta = $_GET["hasta"];
    if ($pedidos) {
        $pedidosFiltrados = array();
        foreach ($pedidos as $pedido) {
            if ($pedido->fecha >= $desde && $pedido->fecha <= $hasta) {
                array_push($pedidosFiltrados, $pedido);
            }
        }

        function cmp($a, $b)
        {
            return strcmp($a->sabor, $b->sabor);
        }

        var_dump($pedidosFiltrados);
        usort($pedidosFiltrados, "cmp");
        var_dump($pedidosFiltrados);

        foreach ($pedidosFiltrados as $pedido) {
            echo "<ul>
                <li>$pedido->fecha</li>
            </ul>";
        }
    }
} else if ($consulta === "usuario") {
    $usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : null;

    if ($usuario && !is_numeric($usuario)) {
        $pedidos = Pedido::CargarJson();
        $cantidadPedidos = Pedido::CantidadPedidosUsuario($pedidos, $usuario);
        echo "La cantidad de pedidos del usaurio " . $usuario . " es " . $cantidadPedidos;
    } else {
        echo "Formato de usuario incorrecto " . $_GET["usuario"];
    }
} else if ($consulta === "sabor") {
    $sabor = isset($_GET["sabor"]) ? $_GET["sabor"] : null;

    if (!is_null($sabor) && !is_numeric($sabor) && is_string($sabor)) {
        $cantidadPedidos = Pedido::CantidadPedidosSabor($pedidos, $sabor);
        echo "La cantidad de pedidos del sabor es " . $sabor . " es " . $cantidadPedidos;
    } else {
        echo "Formato de consulta incorrecto";
    }
}
