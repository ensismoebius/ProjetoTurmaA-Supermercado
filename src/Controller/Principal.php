<?php
namespace GrupoA\Supermercado\Controller;

class Principal
{
    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;

    public function __construct()
    {
        // Construtor da classe
        $this->carregador =
            new \Twig\Loader\FilesystemLoader("./src/View/Html");

        // Combina os dados com o template
        $this->ambiente =
            new \Twig\Environment($this->carregador);
    }


    public function paginaPrincipal(array $dados)
    {
        $dados["titulo"] = "Página Principal";
        $dados["conteudo"] = "Bem-vindo à página principal!";

        // Renderiza a view principal
        echo $this->ambiente->render("principal.html", $dados);
    }
}

