<?php
require_once '../dao/postDAO.inc.php';
require_once '../classes/post.inc.php';
require_once '../classes/usuario.inc.php';

session_start();

$opcao = $_POST['opcao'];

if ($opcao == 1) { // Criar Post
    if (isset($_SESSION['usuario'])) {
        $usuarioLogado = $_SESSION['usuario'];
        $idUsuario = $usuarioLogado->getIdUsuario();

        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $texto = $_POST['conteudo'];

        $postDAO = new PostDAO();
        $novoPost = new Post(null, $titulo, $descricao, $texto, null, $idUsuario);

        $postDAO->incluirPost($novoPost);

        header("Location: ../views/explorar.php");
    } else {
        header("Location: ../views/formLogin.php?erro=2"); // Erro=2: Acesso negado
    }
}
?>