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
                <h1>Cadastre-se ao NKHands</h1>
                <div class="LogoLogin">
                    <img src="Imagens/logo.png" alt="Logo">
                </div>
            </section>
            <section class="lado-direito">
                <form class="form-login" action="../controlers/controlerUsuario.php" method="post">
                    
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>

                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>

                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>

                    <button type="submit" name="opcao" value="3" class="btn-form-login btn-castrar">Cadastrar</button>

                    <div class="links-extra">
                        <a href="index.php" class="link-azul">Já possui uma conta? Faça login aqui.</a>
                    </div>   
                </form>
            </section>
        </main>
    </body>
</html>