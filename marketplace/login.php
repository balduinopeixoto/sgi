<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}else{
   session_destroy();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SGI</title>
    <style>
        /* Estilos Globais e do Corpo */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/properties.jpg') no-repeat center center fixed; /* Substitua pelo caminho da sua imagem */
            background-size: cover;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Cores e Gradientes */
        :root {
            --cor-nav: #2c589e; /* Azul Marinho da barra de navegação */
            --cor-texto-claro: white;
            --gradiente-btn: linear-gradient(to right, #4dc4e0, #4dd087); /* Gradiente do botão 'PESQUISAR' */
            --cor-fundo-card: rgba(255, 255, 255, 0.95); /* Branco quase opaco para o formulário */
        }

        /* Cabeçalho/Barra de Navegação */
        .header {
            background-color: var(--cor-nav);
            color: var(--cor-texto-claro);
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            color: var(--cor-texto-claro);
            text-decoration: none;
            font-weight: bold;
            font-size: 1.5em;
        }
        /* Ajuste para o logo real, que parece ser uma imagem/ícone */
        .logo span {
            /* Simula o texto ao lado do ícone */
            margin-left: 10px;
        }

        .nav-links a, .login-btn a {
            color: var(--cor-texto-claro);
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .login-btn a {
            border: 1px solid var(--cor-texto-claro);
            background: none;
        }
        
        /* Layout Principal da Página de Login */
        .login-container {
            flex-grow: 1; /* Permite que o container ocupe o espaço restante */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background-color: var(--cor-fundo-card);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px; /* Largura máxima para o formulário */
            text-align: center;
        }

        .login-card h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 2em;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Garante que padding não aumente a largura total */
            font-size: 1em;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            color: var(--cor-texto-claro);
            /* Aplica o gradiente da identidade visual */
            background-image: var(--gradiente-btn);
            transition: opacity 0.3s;
            margin-top: 10px;
        }

        .submit-btn:hover {
            opacity: 0.9;
        }

        .links-adicionais {
            margin-top: 20px;
            font-size: 0.9em;
        }

        .links-adicionais a {
            color: var(--cor-nav);
            text-decoration: none;
            margin: 0 10px;
        }

        /* Rodapé (Baseado na segunda imagem) */
        .footer {
            background-color: #3b74d4; /* Azul da faixa inferior */
            color: var(--cor-texto-claro);
            padding: 50px 0;
            text-align: center;
        }

        .copyright {
            background-color: white;
            color: #333;
            padding: 15px 0;
            font-size: 0.9em;
            border-top: 1px solid #eee;
        }

        .copyright a {
            color: var(--cor-nav);
            text-decoration: none;
            font-weight: bold;
        }

        /* Media Queries para responsividade */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 15px 20px;
            }

            .nav-links {
                margin-top: 10px;
                text-align: center;
            }

            .nav-links a, .login-btn a {
                margin: 5px;
                display: inline-block;
            }
        }

    </style>
</head>
<body>

    <header class="header">
        <div class="logo">
            <a href="#"><img src="images/logo.png" alt="Logo" style="width: 100px; height: 60px;"></a>
        </div>
        <nav class="nav-links">
            <a href="./">Home</a>
            <a href="sobre.php">Sobre Nós</a>
            <a href="visita.php">Agende uma Visita</a>
        </nav>
        <!--<div class="login-btn">
            <a href="#">Registrar</a>
        </div>-->
    </header>

    <div class="login-container">
        <div class="login-card">
            <h2>Login</h2>
            <form action="../controller/login_controller.php?acao=login" method="POST" >
                <div class="form-group">
                    <label for="email">Usuário</label>
                    <input type="text" id="usuario" name="usuario" required placeholder="Digite o nome de usuário">
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required placeholder="Digite sua senha">
                </div>

                <button type="submit" class="submit-btn">
                    LOGIN
                </button>
            </form>
            <div class="links-adicionais">
                <a href="#">Esqueceu a senha?</a>
                |
                <a href="#">Criar Conta</a>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="footer">
            </div>
        <div class="copyright">
            Copyright &copy;2025 Todos direitos reservados ♡ by <a href="#">SCI</a>
        </div>
    </footer>
<script type="txt/jascript" src="sweetalert2.js"></script>

</body>
</html>