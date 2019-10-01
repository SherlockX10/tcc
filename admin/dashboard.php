<?php  include('../config.php'); 

$nome = $_SESSION['user']['username'];
$login=mysqli_query($conn,"SELECT * FROM users WHERE username = '$nome'");
$loginn = mysqli_fetch_array($login);
?>

	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Dashboard</title>
</head>
<body>
	<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
				<h1>Depois da Escola - Admin</h1>
			</a>
		</div>
		<?php if (isset($_SESSION['user'])): ?>
			<div class="user-info">
				<span><?php echo $loginn['username'] ?></span> &nbsp; &nbsp; 
				<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">Sair</a>
			</div>
		<?php endif ?>
	</div>
	<div class="container dashboard">
		<h1>Bem vindo</h1>
		<div class="stats">
			<a href="users.php" class="first">
				<span>43</span> <br>
				<span>Usuários recém-registrados</span>
			</a>
			<a href="posts.php">
				<span>43</span> <br>
				<span>Posts publicados</span>
			</a>
			<a>
				<span>43</span> <br>
				<span>Comentários publicados</span>
			</a>
		</div>
		<br><br><br>
		<div class="buttons">
			<a href="users.php">Add Usuário(s)</a>
			<a href="posts.php">Add Postagem(s)</a>
		</div>
	</div>
</body>
</html>