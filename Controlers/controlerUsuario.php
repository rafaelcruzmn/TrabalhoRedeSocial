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

        $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : ""; 

        $usuarioDAO = new UsuarioDAO();

        $usuarioTemp = new Usuario(NULL, $nome, $email, $senha, $descricao);
        
        $idGeradoPeloBanco = $usuarioDAO->inserirUsuario($usuarioTemp);

        $usuario = new Usuario($idGeradoPeloBanco, $nome, $email, $senha, $descricao);

        session_start();
        $_SESSION["usuario"] = $usuario;
        header("Location: ../views/perfil.php");
    } else if($opcao == 4) { // atualizar perfil
        session_start();
        if (isset($_SESSION['usuario'])) {
            $usuarioLogado = $_SESSION['usuario'];
            
            $novoNome = $_POST["nome"];
            $novaDescricao = $_POST["descricao"];

            $usuarioLogado->setNome($novoNome);
            $usuarioLogado->setDescricaoUsuario($novaDescricao);

            $usuarioDAO = new UsuarioDAO();
            $usuarioDAO->atualizarUsuario($usuarioLogado);

            header("Location: ../views/perfil.php");
        } else {
            header("Location: ../views/formLogin.php?erro=2");
        }
    }
?>