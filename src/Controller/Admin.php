<?php
namespace GrupoA\Supermercado\Controller;

use GrupoA\Supermercado\Produto;
use GrupoA\Supermercado\Database;

class Admin
{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;

    public function __construct()
    {
        // Inicia a sessão, sessao é uma forma de guardar os dados do usuario temporariamente
        // Verifica se o usuário está logado
        // Se não estiver, redireciona para a página de login
        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("Location: /login");
            exit;
        }

        // Construtor da classe
        $this->carregador =
            new \Twig\Loader\FilesystemLoader("./src/View");

        // Combina os dados com o template
        $this->ambiente =
            new \Twig\Environment($this->carregador);
    }

    /**
     * Exibe o formulário para criação de um novo produto
     * @param array $dados
     * @return void
     */
public function formularioNovoProduto(array $dados)
    {
        echo $this->ambiente->render("formularioNovoProduto.html", $dados);
    }

    /**
     * Salva um novo produto
     * @param array $dados
     * @return void
     */
     public function salvaProduto(array $dados)
    {
        $nome = trim($dados["nome"]);
        $descricao = trim($dados["descricao"]);
        $valor = $dados["valor"];
        $categoria = trim($dados["categoria"]);
        $fornecedor = trim($dados["fornecedor"]);

        $avisos = "";

        if ($nome != "" && $valor > 0 && $categoria != "" && $fornecedor != "") {
            $produto = new Produto();
            $produto->prdTitulo = $nome;
            $produto->prdVlrUnit = $valor;
            $produto->prdDescr = $descricao;
            $produto->prdCateg = $categoria;
            $produto->prdFor = $fornecedor;

            $bd = new Database();
            if ($bd->saveProduto($produto)) {
                // Avisa que deu certo
                $avisos .= "Produto cadastrado com sucesso.";
            } else {
                // Avisa que deu errado
                $avisos .= "Erro ao cadastrar produto.";
            }
        }

        $dados["avisos"] = $avisos;
        echo $this->ambiente->render("formularioNovoProduto.html", $dados);
    }

}