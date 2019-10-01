<?php  include('config.php'); ?>
<?php  include('includes/registration_login.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title></title>
<link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<body>
<div id="wrapper">
<div id="left">
<div id="signin">
<div class="logo">
<img src="static/images/depois.png" alt="logo">
</div>

		<form method="post" action="login.php" >
        <div>
    
			<?php include(ROOT_PATH . '/includes/errors.php') ?>
            </div>
    <div>
    <label>Email ou usuário</label>
			<input type="text" class="text-input" name="username" value="<?php echo $username; ?>" placeholder="Nome">
			<label>Senha</label>
            <input type="password" class="text-input" name="password" placeholder="Senha">
            </div>
			<button type="submit" class="primary-btn" name="login_btn">Login</button>
		</form>
        <div class="links">
<a href="#">Esqueci a senha</a>

<a href="#">Entrar como compania ou escola</a>
</div>

<div class="or">
<hr class="bar">
<span>OU</span>
<hr class="bar">
</div>
<a href="register.php" class="secondary-btn">Criar uma conta</a>
</div>
<footer id="main-footer">
<p>Copyright &copy; 2019, RR Todos os direitos reservados
<div>
<a href="#">Termo de uso</a> | <a href="#">Políticas de privacidade</a>
</div>
</footer>
</div>
<div id="right">
<div id="showcase">
<div class="showcase-content">
 <h1 class="showcase-text">
 Vamos criar o futuro
 <strong>Juntos</strong></h1>
 <a href="index.php" class="secondary-btn">Início</a>

</div>
</div>
</div>
</div>
</div>



</body>
</html>
