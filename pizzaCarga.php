<?php

include_once("pizza.php");

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];
$pizzas = Pizza::CargarJson();
$id = $pizzas !== false ? count($pizzas) : 1;
$pizza = new Pizza($sabor, $precio, $tipo, $id, $cantidad);
if ($pizzas !== false) {
    $existe = Pizza::VerificarExistencia($pizzas, $sabor, $tipo);
    if ($existe) {
        $pizzaAActualizar = Pizza::BuscarPizza($pizzas, $sabor, $tipo);
        $pizzaAActualizar->cantidad += $cantidad;
        $pizzaAActualizar->precio = $precio;
        Pizza::GuardarImagen($pizza);
        Pizza::GuardarJson($pizzas);
    } else {
        Pizza::GuardarImagen($pizza);
        array_push($pizzas, $pizza);
        Pizza::GuardarJson($pizzas);
    }
} else {
    $pizzas = array();
    array_push($pizzas, $pizza);
    Pizza::GuardarJson($pizzas);
    Pizza::GuardarImagen($pizza);
}
