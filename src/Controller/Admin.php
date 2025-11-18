<?php
namespace GrupoA\Supermercado\Controller;

use GrupoA\Supermercado\User;
use GrupoA\Supermercado\Produto;
use GrupoA\Supermercado\Database;

class Admin
{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("Location: /ProjetoTurmaA-Supermercado/login");
            exit;
        }

        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View");
        $this->ambiente = new \Twig\Environment($this->carregador);
    }

    /**
     * Exibe o formulário para atualizar produto pelo id
     * @param array $dados
     * @return void
     */

    public function formularioEditarProduto(array $dados)
{
    $id = intval($dados["id"] ?? 0);
    $bd = new Database();
    $produto = $bd->buscarProdutoPorId($id);

    if (!$produto) {
        echo $this->ambiente->render("AtualizarProduto.html", 
        [
            "avisos" => "Produto não encontrado."
        ]);
        return;
    }
// nao tem o html ainda
    echo $this->ambiente->render("AtualizarProduto.html", [
        "produto" => $produto
    ]);
}


    /**
     * listar do produto
     * @param array $dados
     * @return void
     */

    public function listarProdutos(): void
{
    $bd = new Database();
    $produtos = $bd->buscarProdutos(); 

    echo $this->ambiente->render("ListarProdutos.html", [
        "produtos" => $produtos
    ]);
}


    /**
     * Processa atualização do produto
     * @param array $dados
     * @return void
     */
    public function editarProduto(array $dados)
    {
        $id = trim($dados["id"]);
        $nome = trim($dados["nome"]);
        $valor = floatval($dados["valor"]);
        $categoria = trim($dados["categoria"]);
        $descricao = trim($dados["descricao"]);
        $quantidade = intval($dados["quantidade"]);

        $avisos = "";

        if ($id != "" && $nome != "" && $valor > 0) {
            $produto = new Produto();
            $produto->id = $id;
            $produto->nome = $nome;
            $produto->valor = $valor;
            $produto->categoria = $categoria;
            $produto->descricao = $descricao;
            $produto->quantidade = $quantidade;

            $bd = new Database();
            if ($bd->atualizaProduto($produto)) {
                $avisos = "Produto atualizado com sucesso!";
            } else {
                $avisos = "Erro ao atualizar produto.";
            }
        } else {
            $avisos = "Preencha todos os campos corretamente.";
        }

        echo $this->ambiente->render("AtualizarProduto.html", ["avisos" => $avisos]);
    }
}
