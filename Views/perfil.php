<?php
include 'includes/menu.php';
require_once '../dao/usuarioDAO.inc.php';
require_once '../classes/usuario.inc.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: formLogin.php");
    exit();
}
$usuarioLogado = $_SESSION['usuario'];
$usuarioDAO = new UsuarioDAO();
$idDoUsuario = $usuarioLogado->getUsuario_id();

// Passa o ID para a DAO resgatar a descrição diretamente - Obs tentei fazer da mesma forma que o getNome() do h1, porêm não consegui, então fiz assim mesmo.
$descricao = $usuarioDAO->getDescricaoUsuarioDAO($idDoUsuario);
if (empty($descricao)) {
    $descricao = "Este usuário ainda não adicionou uma descrição.";
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NKHands - Login</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>

<div class="perfil-container">


    <!-- LADO ESQUERDO PERFIL -->
    <aside class="perfil-info">


        <div class="perfil-titulo">

            <h1>
                <?= htmlspecialchars($usuarioLogado->getNome()) ?>
            </h1>

            <button class="btn-editar">
                ✎
            </button>

        </div>



        <p class="descricao">
            <?= htmlspecialchars($descricao) ?>
        </p>




        <div class="estatisticas">


            <p>
                <b>POSTS TOTAIS:</b>
                0
            </p>

            <p>
                <b>COMENTÁRIOS TOTAIS:</b>
                0
            </p>


        </div>

    </aside>







    <!-- AREA PRINCIPAL -->

    <section class="perfil-conteudo">



        <!-- MENU SECUNDARIO -->

        <div class="sub-menu">


            <button class="aba ativa">
                Posts
            </button>


            <button class="aba">
                Comentários
            </button>


        </div>







        <!-- LISTAGEM DE POSTS -->


        <div class="lista-posts">



            <div class="post">


                <span>
                    @USUARIO
                </span>



                <h2>
                    Titulo do post
                </h2>



                <h4>
                    ASSUNTO DO POST
                </h4>




                <p>
                    Texto do post que será carregado
                    pelo sistema.
                </p>



                <small>
                    POSTAGEM FEITA EM 00/00/0000
                </small>

            

            </div>

            <!-- Mensagem quando não existir -->


            <div class="sem-posts">


                Esse usuário não possui posts!


            </div>



        </div>




    </section>


</div>

<?php include 'Includes/rodape.php'; ?>