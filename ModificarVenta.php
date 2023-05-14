<?php

require_once("pedido.php");

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    parse_str(file_get_contents("php://input"), $put_vars);
    //$put_vars["usuario"];
    $numeroPedido = $put_vars["numeroPedido"];
    $mail = $put_vars["mail"];
    $tipo = $put_vars["tipo"];
    $cantidad = $put_vars["cantidad"];
    $sabor = $put_vars["sabor"];
    $pedidos = Pedido::CargarJson();
    if (is_array($pedidos)) {
        $pedido = Pedido::BuscarPedido($pedidos, intval($numeroPedido));
        var_dump($pedido);
        if ($pedido !== false) {
            $pedido->usuario = $mail;
            $pedido->tipo = $tipo;
            $pedido->cantidad = $cantidad;
            $pedido->sabor = $sabor;
            Pedido::GuardarJson($pedidos);
        } else {
            echo "El pedido no existe.";
        }
    } else {
        echo "Error, aun no hay pedidos cargados.";
    }
}
