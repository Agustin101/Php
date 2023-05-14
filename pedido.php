<?php

class Pedido
{

    public $fecha;
    public $numeroPedido;
    public $id;
    public $sabor;
    public $tipo;
    public $cantidad;
    public $usuario;

    public function __construct($fecha, $numeroPedido, $id, $sabor, $tipo, $cantidad, $usuario)
    {
        $this->fecha = $fecha;
        $this->numeroPedido = $numeroPedido;
        $this->id = $id;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        $this->usuario = $usuario;
    }

    public static function GuardarJson($pedidos)
    {
        // leo a memoria archivo si hay (agrego borro edito lo que sea) y al final piso el archivo con lo
        // nuevo en memoria
        $path = fopen("pedidos.json", "w+");
        if ($path !== false) {
            $json = json_encode($pedidos, JSON_PRETTY_PRINT);
            fwrite($path, $json);
            fclose($path);
            return true;
        }

        return false;
    }

    public static function CargarJson()
    {
        if (!file_exists("pedidos.json")) {
            return false;
        }
        $path = fopen("pedidos.json", "r");
        if ($path !== false) {
            $contenido = fread($path, filesize("pedidos.json"));
            $pedidosExistentes = json_decode(
                $contenido,
                true
            );

            $pedidos = array();
            foreach ($pedidosExistentes as $pedido) {
                $fecha = $pedido["fecha"];
                $numero = $pedido["numeroPedido"];
                $id = $pedido["id"];
                $sabor = $pedido["sabor"];
                $tipo = $pedido["tipo"];
                $cantidad = $pedido["cantidad"];
                $usuario = $pedido["usuario"];
                array_push($pedidos, new Pedido($fecha, $numero, $id, $sabor, $tipo, $cantidad, $usuario));
            }
            fclose($path);
            return $pedidos;
        }
        return false;
    }

    public static function VerificarExistencia($pizzas, $sabor, $tipo)
    {

        foreach ($pizzas as $pizza) {
            if ($pizza->sabor === $sabor && $pizza->tipo == $tipo)
                return true;
        }

        return false;
    }

    public static function CantidadPedidosUsuario($pedidos, $usuario)
    {
        $contador = 0;

        foreach ($pedidos as $pedido) {
            if ($pedido->usuario === $usuario)
                $contador++;
        }
        return $contador;
    }

    public static function CantidadPedidosSabor($pedidos, $sabor)
    {
        $contador = 0;

        foreach ($pedidos as $pedido) {
            if ($pedido->sabor === $sabor)
                $contador++;
        }
        return $contador;
    }

    public static function BuscarPedido($pedidos, $numeroPedido)
    {
        foreach ($pedidos as $pedido) {
            if ($pedido->numeroPedido === $numeroPedido)
                return $pedido;
        }
        return false;
    }
}
