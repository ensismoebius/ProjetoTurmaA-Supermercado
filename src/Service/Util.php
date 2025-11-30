<?php

namespace GrupoA\Supermercado\Service;

class Util
{
    public static function averigua()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    }
}

class CarrinhoUtil
{
    public static function iniciarCarrinho()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public static function adicionarProduto($id, $nome, $valor, $QTDE = 1)
    {
        self::iniciarCarrinho();

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'nome' => $nome,
                'valor' => $valor,
                'QTDE' => $QTDE
            ];
        } else {
            $_SESSION['cart'][$id]['QTDE'] += $QTDE;
        }
    }

    
}
