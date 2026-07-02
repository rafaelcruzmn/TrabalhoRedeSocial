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
        // A imagem será tratada depois, o último parâmetro é para imagem
        $novoPost = new Post(null, $titulo, $descricao, $texto, null, $idUsuario, null);

        // 1. Inserir o post para obter o ID
        $idPost = $postDAO->incluirPost($novoPost);

        // 2. Lógica de upload de imagem, se houver
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagem = $_FILES['imagem'];
            $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
            $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($extensao), $extensoesPermitidas)) {
                // Nome do arquivo: <id_post>.<extensao>
                $novoNomeImagem = $idPost . '.' . $extensao;

                // Caminho para salvar o arquivo (relativo ao controlador)
                $pastaUpload = '../views/imagens/posts/';
                if (!is_dir($pastaUpload)) {
                    mkdir($pastaUpload, 0777, true);
                }
                $caminhoArquivo = $pastaUpload . $novoNomeImagem;

                if (move_uploaded_file($imagem['tmp_name'], $caminhoArquivo)) {
                    // 3. Atualizar o post no banco com o caminho da imagem
                    // O caminho no BD deve ser relativo à pasta 'views'
                    $caminhoParaBD = 'imagens/posts/' . $novoNomeImagem;
                    $postDAO->atualizarCaminhoImagem($idPost, $caminhoParaBD);
                }
            }
        }

        header("Location: ../views/explorar.php");
    } else {
        header("Location: ../views/formLogin.php?erro=2"); // Erro=2: Acesso negado
    }
} else if ($opcao == 2) { // Excluir Post
    if (isset($_SESSION['usuario'])) {
        $usuarioLogado = $_SESSION['usuario'];
        $idUsuario = $usuarioLogado->getIdUsuario();

        $idPost = $_POST['idpost'];
        $redirectUrl = $_POST['redirect_url'];

        $postDAO = new PostDAO();
        $postDAO->excluirPost($idPost, $idUsuario);

        header("Location: " . $redirectUrl);
        exit();

    } else {
        header("Location: ../views/formLogin.php?erro=2"); // Erro=2: Acesso negado
        exit();
    }
}
?>