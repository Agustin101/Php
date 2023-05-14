<?php

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        include_once("./pizzaCarga.php");
        break;
    case 'GET':
        include_once("./pizzaConsultar.php");
        break;
}
