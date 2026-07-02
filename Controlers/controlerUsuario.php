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
        // Pega a descrição do formulário se houver, caso contrário define vazio
        $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : ""; 

        $usuarioDAO = new UsuarioDAO();

        // 1. Criamos o objeto temporário enviando NULL no ID (pois o banco ainda vai gerar)
        $usuarioTemp = new Usuario(NULL, $nome, $email, $senha, $descricao);
        
        // 2. Executa a inserção e captura o ID real gerado pelo banco de dados
        $idGeradoPeloBanco = $usuarioDAO->inserirUsuario($usuarioTemp);

        // 3. AGORA CRIAMOS O USUÁRIO DEFINITIVO NO CONTROLADOR COM ID E DESCRIÇÃO DO BANCO
        // Passando exatamente os 5 argumentos na ordem correta que o __construct espera
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

            // Atualiza o objeto na sessão
            $usuarioLogado->setNome($novoNome);
            $usuarioLogado->setDescricaoUsuario($novaDescricao);

            // Persiste a mudança no banco de dados
            $usuarioDAO = new UsuarioDAO();
            $usuarioDAO->atualizarUsuario($usuarioLogado);

            header("Location: ../views/perfil.php");
        } else {
            // Usuário não logado tentando atualizar, redireciona para o login
            header("Location: ../views/formLogin.php?erro=2");
        }
    }
?>