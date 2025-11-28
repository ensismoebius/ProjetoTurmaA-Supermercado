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
}
