<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="main">
    <form id="form">
        <div class="form-wrapper">
            <h1>Login</h1>
            <div class="form-group">
                <label for="user">Email:</label>
                <input type="text" id="email" class="form-content" spellcheck="false">
                <li class="erro"></li>
            </div>

            <div class="form-group">
                <label for="senha">Password:</label>
                <div class="password-wrapper">
                    <input name="password1" type="password" id="senha" class="form-content">
                    <input type="button" value="<o>" class="eye" id="show1">
                </div>
                <li class="erro"></li>
            </div>

            <div>
                <input type="button" class="botao" value="Back">
                <button type="submit" class="botao" id="submit">Play!</button>
            </div>
        </div>
    </form>
    <div class="redirect">
        <p>Do not have a account yet? </p>
        <a href="register.php"> Click Here!</a>
    </div>
</div>

    <div class="crt-overlay"></div>
    <div class="frame"></div>

    <script src="js/loginValidation.js"></script>
    
</body>
</html>