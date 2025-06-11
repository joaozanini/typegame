<?php

// caso o usuário já esteja logado, redireciona para a página inicial

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <form id="form" method="post" action="../src/Controllers/UserController.php">
      <div class="form-wrapper">
          <h1>Register</h1>

          <div class="form-group">
            <label for="username">Username:</label>
            <input name="username" type="text" id="username" class="form-content" spellcheck="false" required> 
            <li class="erro"></li>
          </div>

          <div class="form-group">
            <label for="nickname">Nickname:</label>
            <input name="nickname" type="text" id="nickname" class="form-content" spellcheck="false" required> 
            <li class="erro"></li>
          </div>

          <div class="form-group">
            <label for="email">Email:</label>
            <input name="email" type="text" id="email" class="form-content" spellcheck="false" required>
            <li class="erro"></li>
          </div>

          <div class="form-group">
            <label for="password1">Password:</label>
            <div class="password-wrapper">
              <input name="password1" type="password" id="senha" class="form-content" required>
              <input type="button" value="<o>" class="eye" id="show1">
            </div>
            <li class="erro"></li>
          </div>

          <div class="form-group">
            <label for="password2">Password Confirmation:</label>
            <div class="password-wrapper">
              <input name="password2" type="password" id="password2" class="form-content" required>
              <input type="button" value="<o>" class="eye" id="show2">
            </div>
            <li class="erro"></li>
          </div>
          <div>
          <input type="button" class="botao" value="Back" onclick="window.history.back()">
          <button type="submit" class="botao">Submit</button>
          </div>
      </div>
    </form>

    <div class="crt-overlay"></div>
    <div class="frame"></div>

    <script src="js/registerValidation.js"></script>
</body>
</html>