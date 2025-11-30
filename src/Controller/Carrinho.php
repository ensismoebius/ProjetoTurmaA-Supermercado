<?php
namespace GrupoA\Supermercado\Controller;

use GrupoA\Supermercado\Service\Util;
use GrupoA\Supermercado\Service\CarrinhoUtil;

class Carrinho
{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;

    public function __construct()
    {
         Util::averigua();
         CarrinhoUtil::iniciarCarrinho();

        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View/Html");
        $this->ambiente = new \Twig\Environment($this->carregador);
    }

    public function add()
{
    $idProd = $_POST['product_id'];
    $nome = $_POST['nome'];
    $valor = floatval($_POST['valor']);
    $QTDE = isset($_POST['QTDE']) ? intval($_POST['QTDE']) : 1;

    CarrinhoUtil::adicionarProduto($idProd, $nome, $valor, $QTDE);

    header("Location: /carrinho/view");
    exit;
}

}