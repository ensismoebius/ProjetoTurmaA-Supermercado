<?php
namespace GrupoA\Supermercado\Controller;

use GrupoA\Supermercado\Model\Database;
use GrupoA\Supermercado\Model\UserRepository;

class Login
{

    private \Twig\Environment $ambiente;
    private \Twig\Loader\FilesystemLoader $carregador;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->carregador =
            new \Twig\Loader\FilesystemLoader("./src/View/Html");

        $this->ambiente =
            new \Twig\Environment($this->carregador);

        $database = new Database();
        $this->userRepository = new UserRepository($database);
    }

    /**
     * Autentica o usuário
     * @param array $dados
     * @return void
     */
    function autenticar(array $dados)
    {
        $email = filter_var(trim($dados["email"]), FILTER_SANITIZE_EMAIL);
        $senha = htmlspecialchars(trim($dados["senha"]), ENT_QUOTES, 'UTF-8');

        $avisos = "";

        if (empty($email) || empty($senha)) {
            $avisos .= "Preencha todos os campos.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $avisos .= "Formato de email inválido.";
        } else {
            $usuario = $this->userRepository->findByEmail($email);

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
        echo $this->ambiente->render("formularioLogin.html", $dados);
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
        unset($_SESSION["usuario"]);

        // destrói a sessão
        session_destroy();

        // vai redirecionar para página principal
        header("Location: /");
        exit;
    }

}

