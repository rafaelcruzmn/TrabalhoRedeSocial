<?php
include 'includes/menu.php';
require_once '../dao/usuarioDAO.inc.php';
require_once '../dao/postDAO.inc.php';
require_once '../dao/comentarioDAO.inc.php';
require_once '../dao/likeDAO.inc.php';
require_once '../classes/usuario.inc.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: formLogin.php");
    exit();
}
$usuarioLogado = $_SESSION['usuario'];
$usuarioDAO = new UsuarioDAO();

$idPerfil = null;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idPerfil = $_GET['id'];
} else {
    $idPerfil = $usuarioLogado->getIdUsuario();
}

$usuarioDoPerfil = $usuarioDAO->getUsuarioById($idPerfil);

if ($usuarioDoPerfil == null) {
    header("Location: perfil.php");
    exit();
}

$isOwner = ($usuarioLogado->getIdUsuario() == $usuarioDoPerfil->getIdUsuario());

$descricao = $usuarioDoPerfil->getDescricaoUsuario();
if (empty($descricao)) {
    $descricao = "Este usuário ainda não adicionou uma descrição.";
}

$postDAO = new PostDAO();
$totalPosts = $postDAO->countPostsByUsuario($usuarioDoPerfil->getIdUsuario());

$comentarioDAO = new ComentarioDAO();
$totalComentarios = $comentarioDAO->countComentariosByUsuario($usuarioDoPerfil->getIdUsuario());

// Buscar os posts do usuário do perfil
$postsDoPerfil = $postDAO->getPostsByUsuarioId($usuarioDoPerfil->getIdUsuario());
$postsComentados = $comentarioDAO->getPostsComentadosPeloUsuario($usuarioDoPerfil->getIdUsuario());
$likeDAO = new LikeDAO();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NKHands - Perfil</title>
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/comentarios.css">
    <link rel="stylesheet" href="css/likes.css">
</head>

<div class="perfil-container">

    <aside class="perfil-info">

        <?php if ($isOwner) : ?>
            <form action="../controlers/controlerUsuario.php" method="POST" id="form-perfil">
                <input type="hidden" name="opcao" value="4">

                <div class="perfil-titulo">
                    <div id="display-nome">
                        <h1><?= htmlspecialchars($usuarioDoPerfil->getNome()) ?></h1>
                    </div>
                    <div id="edit-nome" style="display: none;">
                        <input type="text" name="nome" value="<?= htmlspecialchars($usuarioDoPerfil->getNome()) ?>" class="input-edit-nome" required>
                    </div>

                    <button type="button" class="btn-editar" id="btn-editar">✎</button>
                    <button type="submit" class="btn-salvar" id="btn-salvar" style="display: none;">Salvar</button>
                    <button type="button" class="btn-cancelar" id="btn-cancelar" style="display: none;">Cancelar</button>
                </div>

                <div id="display-descricao">
                    <p class="descricao"><?= htmlspecialchars($descricao) ?></p>
                </div>
                <div id="edit-descricao" style="display: none;">
                    <textarea name="descricao" class="textarea-edit-descricao"><?= htmlspecialchars($usuarioDoPerfil->getDescricaoUsuario()) ?></textarea>
                </div>
            </form>

        <?php else : ?>
            <div class="perfil-titulo">
                <h1><?= htmlspecialchars($usuarioDoPerfil->getNome()) ?></h1>
            </div>
            <p class="descricao"><?= htmlspecialchars($descricao) ?></p>

        <?php endif; ?>

        <div class="estatisticas">


            <p>
                <b>POSTS TOTAIS:</b>
                <?= $totalPosts ?>
            </p>

            <p>
                <b>COMENTÁRIOS TOTAIS:</b>
                <?= $totalComentarios ?>
            </p>


        </div>

        <?php if ($isOwner) : ?>
            <form action="../controlers/controlerUsuario.php" method="POST" class="form-logout">
                <button type="submit" name="opcao" value="2" class="btn-logout">Sair (Logout)</button>
            </form>
        <?php endif; ?>

    </aside>







    <!-- AREA PRINCIPAL -->

    <section class="perfil-conteudo">



        <!-- MENU SECUNDARIO -->

        <div class="sub-menu">


            <button id="btn-aba-posts" class="aba ativa">
                Posts
            </button>


            <button id="btn-aba-comentarios" class="aba">
                Comentários
            </button>


        </div>

        <div id="conteudo-posts" class="lista-posts">
            <?php if (count($postsDoPerfil) > 0) : ?>
                <?php foreach ($postsDoPerfil as $post) : ?>
                    <div class="post">
                        <span>
                            <a href="perfil.php?id=<?= $post['autor_id'] ?>" style="text-decoration: none; color: inherit;">
                                @<?= htmlspecialchars($post['nome_autor']) ?>
                            </a>
                        </span>
                        <h2><?= htmlspecialchars($post['titulo']) ?></h2>
                        <?php if (!empty($post['descricao'])) : ?>
                            <h4><?= htmlspecialchars($post['descricao']) ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($post['imagem'])) : ?>
                            <img src="<?= htmlspecialchars($post['imagem']) ?>" alt="Imagem do post" class="post-imagem">
                        <?php endif; ?>
                        <p><?= nl2br(htmlspecialchars($post['texto'])) ?></p>
                        <small>POSTADO EM <?= strtoupper(date('d/m/Y \à\s H:i', strtotime($post['datapost']))) ?></small>

                        <?php
                            $totalLikes = $likeDAO->contarLikes($post['idpost']);
                            $usuarioCurtiu = $likeDAO->verificarLike($usuarioLogado->getIdUsuario(), $post['idpost']);
                        ?>
                        <div class="like-secao">
                            <form action="../controlers/controlerLike.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="idpost" value="<?= $post['idpost'] ?>">
                                <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                <button type="submit" class="btn-like <?= $usuarioCurtiu ? 'liked' : '' ?>">
                                    <?= $usuarioCurtiu ? 'Curtido' : 'Curtir' ?>
                                </button>
                            </form>
                            <span class="like-count"><?= $totalLikes ?> <?= ($totalLikes == 1) ? 'curtida' : 'curtidas' ?></span>
                        </div>
                        
                        <?php if ($isOwner && $usuarioLogado->getIdUsuario() == $post['autor_id']) : ?>
                            <div class="post-actions">
                                <form action="../controlers/controlerPost.php" method="POST" style="margin-top: 10px;">
                                    <input type="hidden" name="opcao" value="2">
                                    <input type="hidden" name="idpost" value="<?= $post['idpost'] ?>">
                                    <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                    <button type="submit" class="btn-excluir-post" onclick="return confirm('Tem certeza que deseja excluir este post?');">Excluir Post</button>
                                </form>
                            </div>
                        <?php endif; ?>

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
                <div class="sem-posts">Esse usuário ainda não possui posts!</div>
            <?php endif; ?>
        </div>

        <div id="conteudo-comentarios" class="lista-posts" style="display: none;">
            <?php if (count($postsComentados) > 0) : ?>
                <?php foreach ($postsComentados as $post) : ?>
                    <div class="post">
                        <span>
                            <a href="perfil.php?id=<?= $post['autor_id'] ?>" style="text-decoration: none; color: inherit;">
                                @<?= htmlspecialchars($post['nome_autor']) ?>
                            </a>
                        </span>
                        <h2><?= htmlspecialchars($post['titulo']) ?></h2>
                        <?php if (!empty($post['descricao'])) : ?>
                            <h4><?= htmlspecialchars($post['descricao']) ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($post['imagem'])) : ?>
                            <img src="<?= htmlspecialchars($post['imagem']) ?>" alt="Imagem do post" class="post-imagem">
                        <?php endif; ?>
                        <p><?= nl2br(htmlspecialchars($post['texto'])) ?></p>
                        <small>POSTADO EM <?= strtoupper(date('d/m/Y \à\s H:i', strtotime($post['datapost']))) ?></small>

                        <?php
                            $totalLikes = $likeDAO->contarLikes($post['idpost']);
                            $usuarioCurtiu = $likeDAO->verificarLike($usuarioLogado->getIdUsuario(), $post['idpost']);
                        ?>
                        <div class="like-secao">
                            <form action="../controlers/controlerLike.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="idpost" value="<?= $post['idpost'] ?>">
                                <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                <button type="submit" class="btn-like <?= $usuarioCurtiu ? 'liked' : '' ?>">
                                    <?= $usuarioCurtiu ? 'Curtido' : 'Curtir' ?>
                                </button>
                            </form>
                            <span class="like-count"><?= $totalLikes ?> <?= ($totalLikes == 1) ? 'curtida' : 'curtidas' ?></span>
                        </div>

                        <?php if ($isOwner && $usuarioLogado->getIdUsuario() == $post['autor_id']) : ?>
                            <div class="post-actions">
                                <form action="../controlers/controlerPost.php" method="POST" style="margin-top: 10px;">
                                    <input type="hidden" name="opcao" value="2">
                                    <input type="hidden" name="idpost" value="<?= $post['idpost'] ?>">
                                    <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                    <button type="submit" class="btn-excluir-post" onclick="return confirm('Tem certeza que deseja excluir este post?');">Excluir Post</button>
                                </form>
                            </div>
                        <?php endif; ?>

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
                <div class="sem-posts">O usuário não comentou em nenhum post ainda.</div>
            <?php endif; ?>
        </div>
    </section>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica das abas
        const abaPosts = document.getElementById('btn-aba-posts');
        const abaComentarios = document.getElementById('btn-aba-comentarios');
        const conteudoPosts = document.getElementById('conteudo-posts');
        const conteudoComentarios = document.getElementById('conteudo-comentarios');

        abaPosts.addEventListener('click', function() {
            conteudoPosts.style.display = 'block';
            conteudoComentarios.style.display = 'none';
            abaPosts.classList.add('ativa');
            abaComentarios.classList.remove('ativa');
        });

        abaComentarios.addEventListener('click', function() {
            conteudoPosts.style.display = 'none';
            conteudoComentarios.style.display = 'block';
            abaComentarios.classList.add('ativa');
            abaPosts.classList.remove('ativa');
        });

        <?php if ($isOwner) : ?>
        // Lógica de edição do perfil
        const btnEditar = document.getElementById('btn-editar');
        const btnSalvar = document.getElementById('btn-salvar');
        const btnCancelar = document.getElementById('btn-cancelar');
        const displayNome = document.getElementById('display-nome');
        const editNome = document.getElementById('edit-nome');
        const inputNome = editNome.querySelector('input');
        const displayDescricao = document.getElementById('display-descricao');
        const editDescricao = document.getElementById('edit-descricao');
        const textareaDescricao = editDescricao.querySelector('textarea');
        const originalNome = inputNome.value;
        const originalDescricao = textareaDescricao.value;

        function toggleEdit(isEditing) {
            displayNome.style.display = isEditing ? 'none' : 'block';
            displayDescricao.style.display = isEditing ? 'none' : 'block';
            btnEditar.style.display = isEditing ? 'none' : 'inline-block';
            editNome.style.display = isEditing ? 'block' : 'none';
            editDescricao.style.display = isEditing ? 'block' : 'none';
            btnSalvar.style.display = isEditing ? 'inline-block' : 'none';
            btnCancelar.style.display = isEditing ? 'inline-block' : 'none';
        }
        btnEditar.addEventListener('click', () => toggleEdit(true));
        btnCancelar.addEventListener('click', () => {
            inputNome.value = originalNome;
            textareaDescricao.value = originalDescricao;
            toggleEdit(false);
        });
        <?php endif; ?>
    });
</script>

<?php include 'Includes/rodape.php'; ?>