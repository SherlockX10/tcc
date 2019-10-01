<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Get all topics -->
<?php $topics = getAllTopicsV();	?>
	<title>Admin | Criar postagem</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Forma intermediária - para criar e editar -->
		<div class="action create-post-div">
			<h1 class="page-title">Criar/Editar Vídeo</h1>
            
			<form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_video.php'; ?>" >
				<!-- erros de validação para o formulário -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
                <input type="hidden" name="user_id" value="<?php echo $loginn['id']; ?>">
				<!-- se editar post, o id é necessário para identificar esse post -->
				<?php if ($isEditingPost === true): ?>
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
				<?php endif ?>

				<input type="text" name="title" value="<?php echo $title; ?>" placeholder="Título">
				<label style="float: left; margin: 5px auto 5px;">Imagem</label>
				<input type="file" name="featured_image" >
				<textarea name="body" id="body" cols="30" rows="10"><?php echo $body; ?></textarea>
				<select name="topic_id">
					<option value="" selected disabled>Escolha o tópico</option>
					<?php foreach ($topics as $topic): ?>
						<option value="<?php echo $topic['id']; ?>">
							<?php echo $topic['name']; ?>
						</option>
					<?php endforeach ?>
				</select>
				
				<!-- Somente usuários administradores podem visualizar o campo de entrada de publicação -->
				<?php if ($_SESSION['user']['idtipo_user'] == "1" || $_SESSION['user']['idtipo_user'] == "6"): ?>
					<!-- exibir caixa de seleção de acordo com a publicação da postagem ou não -->
					<?php if ($published == true): ?>
						<label for="publish">
						Publicar
							<input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
						</label>
					<?php else: ?>
						<label for="publish">
						Publicar
							<input type="checkbox" value="1" name="publish">&nbsp;
						</label>
					<?php endif ?>
				<?php endif ?>
				
				<!-- se editar post, exibir o botão de atualização em vez de criar botão -->
				<?php if ($isEditingPost === true): ?> 
					<button type="submit" class="btn" name="update_video">Atualizar</button>
				<?php else: ?>
                 
					<button type="submit" class="btn" name="create_video">Salvar Postagem</button>
				<?php endif ?>

			</form>
		</div>
		<!-- // Forma intermediária - para criar e editar -->
	</div>
    
</body>
</html>

<script>
	CKEDITOR.replace('body');
</script>