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

    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $qty = isset($_POST['qty']) ? intval($_POST['qty']) : 1;

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'qty' => $qty
        ];
    } else {
        $_SESSION['cart'][$id]['qty'] += $qty;
    }

    header("Location: /carrinho/view");
    exit;
}
    public function remove()
{

    if (isset($_POST['product_id'])) {
        $id = $_POST['product_id'];

        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

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

    $subtotal = 0;

    foreach ($carrinho as $item) {
        $subtotal += $item['valor'] * $item['QTDE'];
    }

    //$subtotal = CarrinhoUtil::calcularSubtotal($_SESSION['cart']);
    //$desconto = CarrinhoUtil::calcularDesconto($subtotal);
    //$txEntrega = CarrinhoUtil::calcularEntrega($_SESSION['usuario']['cep'] ?? null);
    //$total = ($subtotal - $desconto) + $txEntrega;


    $dadosResumo = [
    "tempo" => CarrinhoUtil::calcularTempoEntrega(
        '02998-060', // CEP da loja (é o da etec)
        $_SESSION['usuario']['cep'] ?? null), // CEP do cliente
    "endereco" => $_SESSION['usuario']['endereco'] ?? "Endereço não informado",
    "subtotal" => number_format($subtotal, 2, ',', '.'),
    "desconto" => number_format($desconto, 2, ',', '.'),
    "txEntrega" => number_format($txEntrega, 2, ',', '.'),
    "total" => number_format($total, 2, ',', '.')
    ];


    echo $this->ambiente->render("carrinho.html", [
        "carrinho" => $carrinho,
        "resumo" => $dadosResumo, 
    ]);
}


}