<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

<!-- Obter todas as postagens de administrador do DB-->
<?php $posts = getAllPosts(); ?>
<title>Admin | Manage Posts</title>
</head>

<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Exibir registros do banco de dados-->
		<div class="table-div" style="width: 80%;">
			<!-- Mostrar mensagem de notificação -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($posts)) : ?>
				<h1 style="text-align: center; margin-top: 20px;">Nenhuma postagem no banco de dados.</h1>
			<?php else : ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Author</th>
						<th>Título</th>
						<th>Visualização</th>
						<!-- Apenas o administrador pode publicar / cancelar a publicação -->
						<?php if ($_SESSION['user']['idtipo_user'] == "1" || $_SESSION['user']['idtipo_user'] == "6") : ?>
							<th><small>Publicar</small></th>
						<?php endif ?>
						<th><small>Editar</small></th>
						<th><small>Deletar</small></th>
					</thead>
					<tbody>
						<?php foreach ($posts as $key => $post) : ?>
							<tr>
								<td><?php echo $key + 1; ?></td>
								<td><?php echo $post['author']; ?></td>
								<td>
									<a target="_blank" href="<?php echo BASE_URL . 'single_post.php?post-slug=' . $post['slug'] ?>">
										<?php echo $post['title']; ?>
									</a>
								</td>
								<td><?php echo $post['views']; ?></td>

								<!-- Apenas o administrador pode publicar / cancelar a publicação -->
								<?php if ($_SESSION['user']['idtipo_user'] == "1" || $_SESSION['user']['idtipo_user'] ==  "6") : ?>
									<td>
										<?php if ($post['published'] == true) : ?>
											<a class="fa fa-check btn unpublish" href="posts.php?unpublish=<?php echo $post['id'] ?>">
											</a>
										<?php else : ?>
											<a class="fa fa-times btn publish" href="posts.php?publish=<?php echo $post['id'] ?>">
											</a>
										<?php endif ?>
									</td>
								<?php endif ?>

								<td>
									<a class="fa fa-pencil btn edit" href="create_post.php?edit-post=<?php echo $post['id'] ?>">
									</a>
								</td>
								<td>
									<a class="fa fa-trash btn delete" href="posts.php?delete-post=<?php echo $post['id'] ?>">
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Exibir registros do banco de dados -->
	</div>
</body>

</html>