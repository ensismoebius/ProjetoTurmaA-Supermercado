<?php
require "vendor/autoload.php";

const URL = "http://localhost/ProjetoTurmaA-Supermercado";

// Cria o roteador
$roteador = new CoffeeCode\Router\Router(URL);

// Informa o namespace onde os controladores se encontram
$roteador->namespace("GrupoA\Supermercado\Controller");

// === Área pública ===
$roteador->group(null);
$roteador->get("/", "Principal:paginaPrincipal");

// === Área de login ===
$roteador->group("login");

// === Tarefas administrativas ===
$roteador->group("admin");

$roteador->dispatch();