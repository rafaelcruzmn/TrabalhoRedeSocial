<?php
require_once '../dao/comentarioDAO.inc.php';
require_once '../classes/comentario.inc.php';
require_once '../classes/usuario.inc.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['opcao'])) {

    $opcao = $_POST['opcao'];

    if ($opcao == 1) { // Criar Comentário
        if (isset($_SESSION['usuario'])) {
            $usuarioLogado = $_SESSION['usuario'];
            $idUsuario = $usuarioLogado->getIdUsuario();

            $textoComentario = $_POST['texto'];
            $idPost = $_POST['idpost'];
            $redirectUrl = $_POST['redirect_url']; // Para voltar à página correta

            $comentarioDAO = new ComentarioDAO();
            $novoComentario = new Comentario(null, $textoComentario, null, $idPost, $idUsuario);

            $comentarioDAO->inserirComentario($novoComentario);

            header("Location: " . $redirectUrl);
            exit();

        } else {
            header("Location: ../views/formLogin.php?erro=2"); // Erro=2: Acesso negado
            exit();
        }
    }
} else {
    header("Location: ../views/explorar.php");
    exit();
}
?>