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
    $foto1 = $_POST['foto1'] ?? "";

    CarrinhoUtil::adicionarProduto($idProd, $nome, $valor, $QTDE, $foto1);

    header("Location: /carrinho/view");
    exit;
}

     public function remove()
    {
        $id = $_POST['product_id'];
        CarrinhoUtil::removerProduto($id);

        header("Location: /carrinho/view");
        exit;
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
        header("Location: /carrinho/view");
        exit;
    }


public function view()
{
    $carrinho = $_SESSION['cart'];
    $cepUser = $_SESSION['usuario']['cep'] ?? null;

    $taxaEntrega = CarrinhoUtil::calcularTaxaEntrega('02998-060', $cepUser);
    $resumo = CarrinhoUtil::calcularResumo($carrinho, $taxaEntrega);

   $dadosResumo = [
            "tempo" => CarrinhoUtil::calcularTempoEntrega('02998-060',$_SESSION['usuario']['cep'] ?? null),
            "endereco" => $_SESSION['usuario']['endereco'] ?? "Endereço não informado",
            "subtotal" => number_format($resumo["subtotal"], 2, ',', '.'),
             "desconto" => number_format(0, 2, ',', '.'),
            "txEntrega" => number_format($resumo["txEntrega"], 2, ',', '.'),
            "total" => number_format($resumo["total"], 2, ',', '.')
        ];

        echo $this->ambiente->render("carrinho.html", [
            "carrinho" => $carrinho,
            "resumo" => $dadosResumo,
        ]);
    }
}


