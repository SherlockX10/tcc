<?php include('../config.php'); ?>

<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php
// Get all admin users from DB
$admins = getAdminUsers();
$types = getAdminTypes();
$escolas = getAdminTypes_escola();
?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<title>Admin | Gerenciar os Usuários</title>
</head>

<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
		<!-- Middle form - to create and edit  -->
		<div class="action">
			<h1 class="page-title">Criar/Editar Usuário</h1>

			<form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>">

				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingUser === true) : ?>
					<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Nome">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Senha">
				<input type="password" name="passwordConfirmation" placeholder="Confirmar senha">
				<select name="role">
					<option value="" selected disabled>Escolher usuário</option>
					<?php foreach ($types as $key => $type) : ?>
						<option value="<?php echo $type['idtipo_user']; ?>"><?php echo $type['tipo_user']; ?></option>
					<?php endforeach ?>
				</select>
				<?php if ($_SESSION['user']['idtipo_user'] == "1") : ?>
					<select name="escola">
						<option value="" selected disabled>Escolher Escola</option>
						<?php foreach ($escolas as $key => $escola) : ?>
							<option value="<?php echo $escola['idtipo_escola']; ?>"><?php echo $escola['tipo_escola']; ?></option>
						<?php endforeach ?>
					</select>
				<?php endif ?>
				<!-- if editing user, display the update button instead of create button -->
				<?php if ($isEditingUser === true) : ?>
					<button type="submit" class="btn" name="update_admin">Atualizar</button>
				<?php else : ?>
					<button type="submit" class="btn" name="create_admin">Salvar usuário</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($admins)) : ?>
				<h1>No admins in the database.</h1>
			<?php else : ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Admin</th>
						<th>Tipo</th>
						<th colspan="2">Ação</th>
					</thead>
					<tbody>
						<?php foreach ($admins as $key => $admin) : ?>
							<tr>
								<td><?php echo $key + 1; ?></td>
								<td>
									<?php echo $admin['username']; ?>, &nbsp;
									<?php echo $admin['email']; ?>
								</td>
								<td><?php echo $admin['idtipo_user']; ?></td>
								<td>
									<a class="fa fa-pencil btn edit" href="users.php?edit-admin=<?php echo $admin['id'] ?>">
									</a>
								</td>
								<td>
									<a class="fa fa-trash btn delete" href="users.php?delete-admin=<?php echo $admin['id'] ?>">
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>

</html>