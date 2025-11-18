<?php
namespace GrupoA\Supermercado\Controller;

use GrupoA\Supermercado\Database;
use GrupoA\Supermercado\User;

class Login
{

    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;

    public function __construct()
    {
        session_start();

        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View/Html"); 
        $this->ambiente = new \Twig\Environment($this->carregador); 
    }
    

     /**
     * exibe o formulário de login
     * @param array $dados
     * @return void
     */
    public function paginaLogin() { echo $this->ambiente->render("login.html", []); }

    /**
     * Autentica o usuário
     * @param array $dados
     * @return void
     */
    function autenticar(array $dados)
    {
        $nome = trim($dados["nome"]);
        $senha = $dados["senha"];

        $avisos = "";

        if ($nome == "" || $senha == "") {
            $avisos .= "Preencha todos os campos.";
        } else {
            $bd = new Database();
            $usuario = $bd->loadUserByName($nome);

            if ($usuario && password_verify($senha, $usuario["senha"])) {
                $_SESSION["usuario"] = $usuario;
                header("Location: /");
                exit;
            } else {
                $avisos .= "Nome ou senha inválidos.";
            }
        }

        $dados["avisos"] = $avisos;
        
        echo $this->ambiente->render("login.html", $dados);
    }


    //colocar rotas

    /**
     * Salva um novo login
     * @param array $dados
     * @return void
     */
    public function salvarLogin(array $dados)
    {
        echo $this->ambiente->render("login.html", []);

    }


    public function logout(array $dados)
    {
        session_start();

        unset($_SESSION["usuario"]);

        // destrói a sessão
        session_destroy();

        // vai redirecionar para página principal
        header("Location: /");
        exit;
    }
}



