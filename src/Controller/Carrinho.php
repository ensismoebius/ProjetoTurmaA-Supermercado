<?php
namespace GrupoA\Supermercado\Controller;

use GrupoA\Supermercado\Service\Util;
use GrupoA\Supermercado\Service\CarrinhoUtil;

class Carrinho
{
    public function __construct()
    {
         Util::averigua();
         CarrinhoUtil::iniciarCarrinho();

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
}