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

        $this->carregador = new \Twig\Loader\FilesystemLoader("./src/View/html");
        $this->ambiente = new \Twig\Environment($this->carregador);
    }

    public function formularioLogin(array $dados)
    {
        echo $this->ambiente->render("login.html", $dados);
    }


    /**
     * Autentica o usuário
     * @param array $dados
     * @return void
     */
    function autenticar(array $dados)
    {
        $email = trim($dados["email"]);
        $senha = $dados["senha"];

        $avisos = "";

        if ($email == "" || $senha == "") {
            $avisos .= "Preencha todos os campos.";
        } else {
            $bd = new Database();
            $usuario = $bd->loadUserByEmail($email);

            if ($usuario && password_verify($senha, $usuario["senha"])) {
                $_SESSION["usuario"] = $usuario;
                header("Location: /");
                exit;
            } else {
                $avisos .= "Email ou senha inválidos.";
            }
        }

        $dados["avisos"] = $avisos;
        // mudar conforme criarem o html
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

