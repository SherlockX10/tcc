<?php  include('config.php'); 

$query=mysqli_query($conn,"SELECT * FROM tipo_user WHERE idtipo_user > 1");
$queryy=mysqli_query($conn,"SELECT * FROM tipo_user WHERE idtipo_user");

if(isset($_POST['tipo'])){
$tipo=$_POST['tipo'];
}
?>

<!-- Source code for handling registration and login -->
<?php  include('includes/registration_login.php'); ?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title></title>
<link rel="stylesheet" href="static/css/register.css">
</head>
<body>
<div id="wrapper">
<div id="right">
<div id="showcase">
<div class="showcase-content">
 <h1 class="showcase-text">
 Há apenas um click de
 <strong>Distância</strong></h1>
 <a href="header.php" class="secondary-btn">Início</a>

</div>
</div>
</div>
<div id="left">
<div id="signin">
<div class="logo">
<img src="static/images/depois.png" alt="logo">
</div>

		<form method="post" action="register.php" >
		<?php include(ROOT_PATH . '/includes/errors.php') ?>
		<div>
    <label>Usuário</label>
			<input  type="text" class="text-input" name="username" value="<?php echo $username; ?>"  placeholder="Nome">
			</div>
    <div>
    <label>Email</label>
			<input type="email" class="text-input" name="email" value="<?php echo $email ?>" placeholder="Email">
			</div>
    <div>
    <label>Senha</label>
			<input type="password" class="text-input" name="password_1" placeholder="Senha">
			</div>
    <div>
    <label>Repetir senha</label>
			<input type="password" class="text-input" name="password_2" placeholder="Confirmação de senha">
			</div>
			<label>Selecione</label>
			<select class="text-select" name="tipo">
<option>Selecione</option>
<?php

while($dados = mysqli_fetch_array($queryy))
{
?>
<option value="<?php echo $dados['idtipo_user']?>"> <?php echo $dados['tipo_user']?> </option>
<?php
}
?>
</select>
    </div>
			<button type="submit" class="primary-btn" name="reg_user">Registrar</button>
		</form>
		<footer id="main-footer">
<p>Ao cadastrar aceita todos os termos.
<div>
<a href="#">Termo de uso</a> | <a href="header.php">Já possui conta?</a>
</div>
</footer>
</div>

</div>
</div>
