<?php
include_once("pedido.php");


if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $numeroPedido = isset($_GET["numeroPedido"]) ? intval($_GET["numeroPedido"]) : 0;
    $pedidos = Pedido::CargarJson();
    if(is_array($pedidos)){
        $pedido = Pedido::BuscarPedido($pedidos, $numeroPedido);
        if ($pedido !== false) {
            $newArray = array_filter($pedidos, function ($pedidox) use ($numeroPedido) {
                return $pedidox->numeroPedido !== $numeroPedido;
            });
            $mail = substr($pedido->usuario, 0, strpos($pedido->usuario, "@"));
            $nombreArchivo = $pedido->tipo . $pedido->sabor . $mail . ".png";
            $ubicacion = 'ImagenesDeLaVenta/' . $nombreArchivo;
            $nuevaUbicacion = 'BACKUPVENTAS/' . $nombreArchivo;
            $moved = rename($ubicacion, $nuevaUbicacion);
            if ($moved) {
                echo "File moved successfully";
                Pedido::GuardarJson($newArray);
            }
        }
        else{
            echo "El numero de pedido es inexistente";
        }

    }
    else{
        echo "No hay pedido cargados";
    }
}