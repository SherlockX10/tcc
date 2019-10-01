<?php if (isset($_SESSION['user']['username'])) { ?>
	<div class="logged_in_info">
		<span>Bem vindo <?php echo $_SESSION['user']['username'] ?></span>
		|
		<span><a href="logout.php">Sair</a></span>
	</div>
<?php }else{ ?>
	<div class="banner">
		<div class="welcome_msg">
			<h1>Inspiração de hoje</h1>
			<p> 
			    Um dia sua vida <br>
irá piscar diante dos seus olhos. <br>
Certifique-se de que vale a pena assistir. <br>
				<span>~ Gerard Way</span>
			</p>
			<a href="register.php" class="btn">Join us!</a>
		</div>

		<div class="login_div">
			<form action="<?php echo BASE_URL . 'index.php'; ?>" method="post" >
				<h2>Login</h2>
				<div style="width: 60%; margin: 0px auto;">
					<?php include(ROOT_PATH . '/includes/errors.php') ?>
				</div>
				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Nome">
				<input type="password" name="password"  placeholder="Senha"> 
				<button class="btn" type="submit" name="login_btn">Entrar</button>
			</form>
		</div>
	</div>
<?php } ?>