<?php
require_once '../dao/likeDAO.inc.php';
require_once '../classes/usuario.inc.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idpost'])) {
    if (isset($_SESSION['usuario'])) {
        $usuarioLogado = $_SESSION['usuario'];
        $idUsuario = $usuarioLogado->getIdUsuario();
        $idPost = $_POST['idpost'];
        $redirectUrl = $_POST['redirect_url'];

        $likeDAO = new LikeDAO();

        if ($likeDAO->verificarLike($idUsuario, $idPost)) {
            // Se já curtiu, descurte
            $likeDAO->tirarLike($idUsuario, $idPost);
        } else {
            // Se não curtiu, curte
            $likeDAO->darLike($idUsuario, $idPost);
        }

        header("Location: " . $redirectUrl);
        exit();
    } else {
        // Usuário não logado
        header("Location: ../views/formLogin.php?erro=2");
        exit();
    }
} else {
    header("Location: ../views/explorar.php");
    exit();
}
?>