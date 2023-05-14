<?php

require_once("./pizza.php");
$pizzas = Pizza::CargarJson();
if ($pizzas) {
    $sabor = $_GET["sabor"];
    $tipo = $_GET["tipo"];
    $existe = Pizza::VerificarExistencia($pizzas, $sabor, $tipo);

    if ($existe === true) {
        echo "Si hay";
    } else {
        echo $existe;
    }
}
