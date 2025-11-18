<?php
require "vendor/autoload.php";

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = str_replace(basename($scriptName), '', $scriptName);
const URL = "{$protocol}://{$host}{$basePath}";

// Cria o roteador
$roteador = new CoffeeCode\Router\Router(URL);

// Informa o namespace onde os controladores se encontram
$roteador->namespace("GrupoA\Supermercado\Controller");

// === Área pública ===
$roteador->group(null);
$roteador->get("/", "Principal:paginaPrincipal");

// === Área de login ===
$roteador->group("login");

// === Área administrativa ===
$roteador->group("admin");
$roteador->get("/produto/{id}/editar", "Admin:formularioEditarProduto");

$roteador->post("/produto/editar", "Admin:editarProduto");


$roteador->dispatch();