<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>    
    <form id="form">
      <div class="form-wrapper">
          <h1>Registro</h1>
          <div class="form-group">
            <label for="user">Nome de usuário:</label>
            <input type="text" id="user" class="form-content">
            <li class="erro"></li>
          </div>

          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" class="form-content">
            <li class="erro"></li>
          </div>

          <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" class="form-content">
            <li class="erro"></li>
          </div>

          <div class="form-group">
            <label for="confirm">Confirme a senha:</label>
            <input type="password" id="confirm" class="form-content">
            <li class="erro"></li>
          </div>

          <input type="submit" id="submit" value="Continuar" class="botao">
      </div>
    </form>

    <div class="crt-overlay"></div>
    <div class="frame"></div>

    <script src="js/register.js"></script>
</body>
</html>