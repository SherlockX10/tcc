<?php
$nome = $_SESSION['user']['username'];
$login=mysqli_query($conn,"SELECT * FROM users WHERE username = '$nome'");
$loginn = mysqli_fetch_array($login);
?>

<div class="header">
	<div class="logo">
		<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
			<h1>Depois da Escola - Admin</h1>
		</a>
	</div>
	<div class="user-info">
		<span><?php echo $loginn['username'] ?></span> &nbsp; &nbsp; 
		<span><?php echo $loginn['id'] ?></span> &nbsp; &nbsp; 
            <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">Sair</a>
	</div>
</div>