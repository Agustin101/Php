<?php


require_once("pizza.php");
require_once("pedido.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sabor = $_POST["sabor"];
    $tipo = $_POST["tipo"];
    $cantidad = isset($_POST["cantidad"]) === true ? $_POST["cantidad"] : null;
    $mail = $_POST["mail"];
    $pizzas = Pizza::CargarJson();
    if (is_array($pizzas)) {
        $existe = Pizza::BuscarPizza($pizzas, $sabor, $tipo);
        if ($existe && $existe->cantidad > $cantidad) {
            $pedidos = Pedido::CargarJson();
            if ($pedidos === false)
                $pedidos = array();
            $fecha = date("Y-m-d H:i:s");
            $nroPedido = count($pedidos) + 1;
            $id = count($pedidos) + 1;
            $existe->cantidad -= $cantidad;
            array_push($pedidos, new Pedido($fecha, $nroPedido, $id, $sabor, $tipo, $cantidad, $mail));
            $mail = substr($mail, 0, strpos($mail, "@"));
            $_FILES["imagen"]["name"] = $existe->tipo . $existe->sabor . $mail . ".png";
            $destino = "ImagenesDeLaVenta/" . $_FILES["imagen"]["name"];
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
            Pedido::GuardarJson($pedidos);
            Pizza::GuardarJson($pizzas);
        }
    }
}
