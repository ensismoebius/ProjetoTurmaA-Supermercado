<?php
require "vendor/autoload.php";

const URL = "http://localhost";

$roteador = new CoffeeCode\Router\Router(URL);

$roteador->namespace("GrupoA\Supermercado\Controller");

// === Área pública ===

// === Área de login ===


$roteador->get('/logout', "Login:logout");

$roteador->dispatch();