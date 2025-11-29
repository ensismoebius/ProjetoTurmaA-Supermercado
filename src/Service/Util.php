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

    public static function calcularTempoEntrega($cepOrigem, $cepDestino, $codigoServico = '04014') {
        //API que faz requisição com o calculador online de entrega
    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrazo"
         . "?nCdServico={$codigoServico}"
         . "&sCepOrigem={$cepOrigem}"
         . "&sCepDestino={$cepDestino}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resposta = curl_exec($ch);

    curl_close($ch);

    $xml = simplexml_load_string($resposta);

    return (int) $xml->Servicos->cServico->PrazoEntrega;
}

}
