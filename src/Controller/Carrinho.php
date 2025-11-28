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
    echo $this->ambiente->render("carrinho.html", [
        "carrinho" => $carrinho, 
    ]);
}


}