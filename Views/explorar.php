<?php
include 'includes/menu.php';
require_once '../classes/usuario.inc.php';
require_once '../dao/postDAO.inc.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: formLogin.php");
    exit();
}

$postDAO = new PostDAO();
$posts = $postDAO->getTodosPosts();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NKHands - Criar Post</title>
    <link rel="stylesheet" href="css/explorar.css">
</head>

<body>

    <div class="explorar-container">
        <h1>Crie uma nova publicação</h1>

        <form class="form-post" action="../controlers/controlerPost.php" method="POST">
            <input type="hidden" name="opcao" value="1">

            <div class="form-grupo">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div class="form-grupo">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao">
            </div>

            <div class="form-grupo">
                <label for="conteudo">Conteúdo:</label>
                <textarea id="conteudo" name="conteudo" required></textarea>
            </div>

            <button type="submit" class="btn-postar">Postar</button>
        </form>
    </div>

    <div class="feed-container">
        <h2 class="feed-titulo">Feed de Publicações</h2>
        <div class="lista-posts">
            <?php if (count($posts) > 0) : ?>
                <?php foreach ($posts as $post) : ?>
                    <div class="post">
                        <span>
                            <a href="perfil.php?id=<?= $post['autor_id'] ?>" style="text-decoration: none; color: inherit;">
                                @<?= htmlspecialchars($post['nome_autor']) ?>
                            </a>
                        </span>
                        <h2>
                            <?= htmlspecialchars($post['titulo']) ?>
                        </h2>
                        <?php if (!empty($post['descricao'])) : ?>
                            <h4>
                                <?= htmlspecialchars($post['descricao']) ?>
                            </h4>
                        <?php endif; ?>
                        <p>
                            <?= nl2br(htmlspecialchars($post['texto'])) ?>
                        </p>
                        <small>
                            POSTADO EM <?= strtoupper(date('d/m/Y \à\s H:i', strtotime($post['datapost']))) ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="sem-posts">
                    Ainda não há nenhuma publicação. Seja o primeiro a postar!
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
<?php include 'Includes/rodape.php'; ?>