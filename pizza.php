<?php

class Pizza
{

    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;
    public $id;


    public function __construct($sabor, $precio, $tipo, $id, $cantidad)
    {
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        $this->id = $id;
    }

    public function GetSabor()
    {
        return $this->sabor;
    }

    public function GetPrecio()
    {
        return $this->precio;
    }

    public function GetTipo()
    {
        return $this->tipo;
    }

    public static function GuardarJson($pizzas)
    {
        // leo a memoria archivo si hay (agrego borro edito lo que sea) y al final piso el archivo con lo
        // nuevo en memoria
        $path = fopen("pizza.json", "w+");
        if ($path !== false) {
            // if ($pizzas != false) {
            //     array_push($pizzas, $pizza);
            // } else {
            //     $pizzas = array();
            //     array_push($pizzas, $pizza);
            // }
            $json = json_encode($pizzas, JSON_PRETTY_PRINT);
            fwrite($path, $json);
            fclose($path);
            return true;
        }

        return false;
    }

    public static function CargarJson()
    {
        if (!file_exists("pizza.json")) {
            return false;
        }
        $path = fopen("pizza.json", "r");
        if ($path !== false) {

            $contenido = fread($path, filesize("pizza.json"));
            $pizzasExistentes = json_decode(
                $contenido,
                true
            );

            $pizzas = array();
            foreach ($pizzasExistentes as $key => $val) {
                $sabor = $val["sabor"];
                $precio = $val["precio"];
                $tipo = $val["tipo"];
                $id = $val["id"];
                $cantidad = $val["cantidad"];
                array_push($pizzas, new Pizza($sabor, $precio, $tipo, $id, $cantidad));
            }
            fclose($path);
            return $pizzas;
        }
        return false;
    }

    public static function VerificarExistencia($pizzas, $sabor, $tipo)
    {
        foreach ($pizzas as $pizza) {
            if ($pizza->sabor === $sabor && $pizza->tipo === $tipo) {
                return true;
            }
        }
        $existeTipo = false;
        $existeSabor = false;

        foreach ($pizzas as $pizza) {
            if ($pizza->tipo === $tipo) {
                $existeTipo = true;
                break;
            }
        }

        foreach ($pizzas as $pizza) {
            if ($pizza->sabor === $sabor) {
                $existeSabor = true;
                break;
            }
        }

        if ($existeTipo && !$existeSabor) {
            return "No existe el sabor";
        } else if (!$existeTipo && $existeSabor) {
            return "No existe el tipo";
        } else {
            return "No existe tipo ni sabor";
        }
    }

    public static function BuscarPizza($pizzas, $sabor, $tipo)
    {
        foreach ($pizzas as $pizza) {
            if ($pizza->sabor === $sabor && $pizza->tipo == $tipo)
                return $pizza;
        }
        return false;
    }

    public static function GuardarImagen($pizza)
    {
        $_FILES["imagen"]["name"] = $pizza->tipo . $pizza->sabor . ".png";
        $destino = "ImagenesDePizzas/" . $_FILES["imagen"]["name"];
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
    }
}
