<?php
    require_once '../dao/usuarioDAO.inc.php';
    require_once '../classes/Usuario.inc.php';

    $opcao = $_REQUEST['pOpcao'];

    if($opcao == 1){ // autenticar
        $email = $_REQUEST['pEmail'];
        $senha = $_REQUEST['pSenha'];

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
    } else if($opcao == 3) {
        $usuarioDAO = new usuarioDAO();

        
    }
?>