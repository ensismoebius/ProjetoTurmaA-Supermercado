<?php
namespace Controller;

class Admin
{
    public function __construct()
    {
        if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
            header('Location: /login.php'); 
            exit;
        }
    }
}    