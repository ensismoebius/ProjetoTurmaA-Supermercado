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

    public static function adicionarProduto($id, $nome, $valor, $QTDE = 1, $foto1 = "")
    {
        CarrinhoUtil::iniciarCarrinho();

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'id' => $id, 
                'nome' => $nome,
                'valor' => $valor,
                'QTDE' => $QTDE,
                'foto1' => $foto1
            ];
        } else {
            $_SESSION['cart'][$id]['QTDE'] += $QTDE;
        }
    }

    
    public static function calcularTempoEntrega($cepOrigem, $cepDestino, $codigoServico = '04014') {
        if (empty($cepDestino) || empty($cepOrigem)) {
        return null;
    }
        //API que faz requisição com o calculador online de entrega
    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrazo"
         . "?nCdServico={$codigoServico}"
         . "&sCepOrigem={$cepOrigem}"
         . "&sCepDestino={$cepDestino}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resposta = curl_exec($ch);

    if ($resposta === false) {
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    $xml = simplexml_load_string($resposta);
    if ($xml === false || !isset($xml->Servicos->cServico->PrazoEntrega)) {
        return null; 
    }

    return (int) $xml->Servicos->cServico->PrazoEntrega;
}



     public static function calcularResumo(array $carrinho): array
    {
        $subtotal = 0;
        $txEntrega = 5.89; // a taxa fixa do mercado
        $total = 0;

        foreach ($carrinho as $p) {
            $qtde = $p["QTDE"] ?? 1;
            $valor = $p["valor"] ?? 0;

            $subtotal += $valor * $qtde;
        }

        $total = $subtotal + $txEntrega;

        return [
            "subtotal" => $subtotal,
            "txEntrega" => $txEntrega,
            "total" => $total
            "desconto" => 0
        ];
    }
}
