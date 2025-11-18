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
$roteador->get("/", "Login:paginaLogin");
$roteador->post("/autenticar", "Login:autenticar");

// === Área administrativa ===
$roteador->group("admin");
$roteador->get("/produto/{id}/editar", "Admin:formularioEditarProduto");

$roteador->post("/produto/editar", "Admin:editarProduto");


$roteador->dispatch();