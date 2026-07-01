<?php
session_start();
    if(isset($_SESSION["usuario"])){
        header("Location: perfil.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>NKHands - Login</title>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <main class="container">
            <section class="lado-esquerdo">
                <h1>Bem Vindo ao NKHands</h1>
                    <div class="LogoLogin">
                        <img src="Imagens/logo.png" alt="Logo">
                    </div>
            </section>
            <section class="lado-direito">

                <form action="../controlers/controlerUsuario.php" method="post" class="form-login">

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="pEmail" required>

                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="pSenha" required>

                    <div class="container-botos-login">
                        <button type="submit" name="opcao" value="1" class="btn-form-login">Acessar</button>
                        <button type="button" class="btn-form-login" onclick="window.location.href='cadastro.php'">Criar Usuário</button>
                    </div>

                    <?php
                        if(isset($_REQUEST['erro'])){
                            if((int)($_REQUEST['erro']) == 1)
                                echo "<b><font face='Arial' size='4' color='red'> Login Incorreto!</font></b>";
                            }
                    ?>

                </form>
            </section>
        </main>
    </body>
</html>