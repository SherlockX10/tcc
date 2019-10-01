<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Get all topics from DB -->
<?php $topics = getAllTopics();	?>
	<title>Admin | Tópicos</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Forma intermediária - para criar e editar -->
		<div class="action">
			<h1 class="page-title">Criar/Editar Tópicos</h1>
			<form method="post" action="<?php echo BASE_URL . 'admin/topics.php'; ?>" >
				<!-- erros de validação para o formulário -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<!-- Aprenda a pronunciar se o tópico de edição, o id é necessário para identificar esse tópico -->
				<?php if ($isEditingTopic === true): ?>
					<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
				<?php endif ?>
				<input type="text" name="topic_name" value="<?php echo $topic_name; ?>" placeholder="Tópico">
				<!-- se o tópico de edição, exibir o botão de atualização em vez de criar botão -->
				<?php if ($isEditingTopic === true): ?> 
					<button type="submit" class="btn" name="update_topic">Atualizar</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_topic">Salvar Tópico</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Forma intermediária - para criar e editar -->

		<!-- Exibir registros do banco de dados-->
		<div class="table-div">
			<!-- Mostrar mensagem de notificação -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<?php if (empty($topics)): ?>
				<h1>Nenhum tópico no banco de dados.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Nome do Tópico</th>
						<th colspan="2">Ação</th>
					</thead>
					<tbody>
					<?php foreach ($topics as $key => $topic): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $topic['name']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="topics.php?edit-topic=<?php echo $topic['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete"								
									href="topics.php?delete-topic=<?php echo $topic['id'] ?>">
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