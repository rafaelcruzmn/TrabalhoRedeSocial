<?php
    require_once '../dao/usuarioDAO.inc.php';
    require_once '../classes/usuario.inc.php';

    $opcao = $_POST['opcao'];

    if($opcao == 1){ // autenticar
        $email = $_POST['pEmail'];
        $senha = $_POST['pSenha'];

        $usuarioDao = new UsuarioDao();
        $usuario = $usuarioDao->autenticar($email, $senha);

        if($usuario != NULL){ // achei
            session_start();
            $_SESSION['usuario'] =  $usuario;
            header('Location: ../views/perfil.php');
        }
        else{ // não logou/achou
           header('Location: ../views/index.php?erro=1');
        }

    } else if($opcao == 2) { // logout
            session_start();

            unset($_SESSION['usuario']);

            header('Location: ../views/index.php');
    } else if($opcao == 3) { // cadastrar
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $usuario = new Usuario($nome, $email, $senha, "");
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->inserirUsuario($usuario);

        session_start();
        $_SESSION["usuario"] = $usuario;
        header("Location: ../views/perfil.php");
    }
?>