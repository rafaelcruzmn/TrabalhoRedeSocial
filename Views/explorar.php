<?php
include 'includes/menu.php';
require_once '../classes/usuario.inc.php';
require_once '../dao/postDAO.inc.php';
require_once '../dao/comentarioDAO.inc.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: formLogin.php");
    exit();
}

$postDAO = new PostDAO();
$posts = $postDAO->getTodosPosts();
$comentarioDAO = new ComentarioDAO();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NKHands - Criar Post</title>
    <link rel="stylesheet" href="css/explorar.css">
    <link rel="stylesheet" href="css/comentarios.css">
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

                        <!-- Seção de Comentários -->
                        <div class="comentarios-secao">
                            <h5 class="comentarios-titulo">Comentários</h5>
                            
                            <?php 
                                $comentarios = $comentarioDAO->getComentariosByPostId($post['idpost']);
                                if (count($comentarios) > 0): 
                            ?>
                                <div class="lista-comentarios">
                                    <?php foreach ($comentarios as $comentario): ?>
                                        <div class="comentario">
                                            <p>
                                                <a href="perfil.php?id=<?= $comentario['usuario_idusuario'] ?>">
                                                    <strong>@<?= htmlspecialchars($comentario['nome_autor']) ?></strong>
                                                </a>:
                                                <?= htmlspecialchars($comentario['texto']) ?>
                                            </p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="sem-comentarios">Seja o primeiro a comentar!</p>
                            <?php endif; ?>

                            <!-- Formulário para novo comentário -->
                            <form action="../controlers/controlerComentario.php" method="POST" class="form-comentario">
                                <input type="hidden" name="opcao" value="1">
                                <input type="hidden" name="idpost" value="<?= $post['idpost'] ?>">
                                <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                <input type="text" name="texto" placeholder="Escreva um comentário..." required>
                                <button type="submit">Comentar</button>
                            </form>
                        </div>
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