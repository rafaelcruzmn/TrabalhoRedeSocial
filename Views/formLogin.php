<?php
session_start();

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

            <form action="../controlers/controlerUsuario.php" method="get" class="form-login">

                <label for="email">Email:</label>
                <input type="email" id="email" name="pEmail" required>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="pSenha" required>

                <button type="submit" class="btn-acessar">Acessar</button>

                <?php
                    if(isset($_REQUEST['erro'])){
                        if((int)($_REQUEST['erro']) == 1)
                            echo "<b><font face='Arial' size='4' color='red'> Login Incorreto!</font></b>";
                    }   
                ?>
                <input type="hidden" value="1" name="pOpcao">

            </form>

            <div class="links-extra">
                <!--
                <a href="cadastro.php" class="link-azul">Novo por aqui? Cadastre-se!</a>
                <br>
                <a href="recuperar_senha.php" class="link-azul">Recuperar Senha</a>
                -->
            </div>

        </section>

    </main>

</body>
</html>