<?php 
// Post variables

$user_id = 0;
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_slug = "";
$body = "";
$featured_image = "";
$post_topic = "";

/* - - - - - - - - - - 
- funções de postagem
- - - - - - - - - - -*/
// recebe todas as postagens do DB
function getAllPosts()
{
	global $conn;
// O administrador pode ver todas as postagens
// O autor só pode ver suas postagens
	if ($_SESSION['user']['idtipo_user'] == "1") {
		$sql = "SELECT * FROM posts";
	} elseif ($_SESSION['user']['idtipo_user'] == "5" || $_SESSION['user']['idtipo_user'] == "6") {
		$user_id = $_SESSION['user']['id'];
		$sql = "SELECT * FROM posts WHERE user_id=$user_id";
	}
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['author'] = getPostAuthorById($post['user_id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function getAllVideos()
{
	global $conn;
// O administrador pode ver todas as postagens
// O autor só pode ver suas postagens
	if ($_SESSION['user']['idtipo_user'] == "1") {
		$sql = "SELECT * FROM posts_video";
	} elseif ($_SESSION['user']['idtipo_user'] == "5" || $_SESSION['user']['idtipo_user'] == "6") {
		$user_id = $_SESSION['user']['id'];
		$sql = "SELECT * FROM posts_video WHERE user_id=$user_id";
	}
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['author'] = getPostAuthorById($post['user_id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}
// obtém o autor / nome de usuário de uma postagem
function getPostAuthorById($user_id)
{
	global $conn;
	$sql = "SELECT username FROM users WHERE id=$user_id";
	$result = mysqli_query($conn, $sql);
	if ($result) {
// return username
		return mysqli_fetch_assoc($result)['username'];
	} else {
		return null;
	}
}

/* - - - - - - - - - - 
- Publicar ações
- - - - - - - - - - -*/
// se o usuário clicar no botão de criação de postagens
if (isset($_POST['create_post'])) { createPost($_POST); }
// se o usuário clicar no botão Editar postagem
if (isset($_GET['edit-post'])) {
	$isEditingPost = true;
	$post_id = $_GET['edit-post'];
	editPost($post_id);
}
// se o usuário clicar no botão de postagem de atualização
if (isset($_POST['update_post'])) {
	updatePost($_POST);
}
// se o usuário clicar no botão Excluir postagem
if (isset($_GET['delete-post'])) {
	$post_id = $_GET['delete-post'];
	deletePost($post_id);
}

if (isset($_POST['create_video'])) { createVideo($_POST); }
// se o usuário clicar no botão Editar postagem
if (isset($_GET['edit-video'])) {
	$isEditingPost = true;
	$post_id = $_GET['edit-video'];
	editPost($post_id);
}
// se o usuário clicar no botão de postagem de atualização
if (isset($_POST['update_video'])) {
	updatePost($_POST);
}
// se o usuário clicar no botão Excluir postagem
if (isset($_GET['delete-video'])) {
	$post_id = $_GET['delete-video'];
	deletePost($post_id);
}

/* - - - - - - - - - - 
- funções de postagem
- - - - - - - - - - -*/
function createPost($request_values)
	{
        global $conn, $errors, $user_id, $title, $featured_image, $topic_id, $body, $published;
        $user_id = esc($request_values['user_id']);
		$title = esc($request_values['title']);
		$body = htmlentities(esc($request_values['body']));
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
        }
		if (isset($request_values['publish'])) {
			$published = esc($request_values['publish']);
		}
		// create slug: if title is "The Storm Is Over", return "the-storm-is-over" as slug
		$post_slug = makeSlug($title);
// validar formulário
		if (empty($title)) { array_push($errors, "O título da postagem é obrigatório"); }
		if (empty($body)) { array_push($errors, "Post body é obrigatório"); }
		if (empty($topic_id)) { array_push($errors, "Postar tópico é obrigatório"); }
		// Obter nome da imagem
	  	$featured_image = $_FILES['featured_image']['name'];
	  	if (empty($featured_image)) { array_push($errors, "Imagem em destaque é necessária"); }
	  	// diretório do arquivo de imagem
	  	$target = "../static/images/" . basename($featured_image);
	  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
	  		array_push($errors, "Não foi possível fazer o upload da imagem. Por favor, verifique as configurações do arquivo para o seu servidor ");
	  	}
// Assegure-se de que nenhuma postagem seja salva duas vezes. 
		$post_check_query = "SELECT * FROM posts WHERE slug='$post_slug' LIMIT 1";
		$result = mysqli_query($conn, $post_check_query);

		if (mysqli_num_rows($result) > 0) { // Se existir postagem
			array_push($errors, "Uma postagem já existe com esse título.");
		}
// criar post se não houver erros no formulário
		if (count($errors) == 0) {
			$query = "INSERT INTO posts (user_id, title, slug, image, body, published, created_at, updated_at) VALUES($user_id, '$title', '$post_slug', '$featured_image', '$body', $published, now(), now())";
			if(mysqli_query($conn, $query)){ // se post criado com sucesso
				$inserted_post_id = mysqli_insert_id($conn);
				// cria relacionamento entre post e topic
				$sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
				mysqli_query($conn, $sql);

				$_SESSION['message'] = "Post criado com sucesso";
				header('location: posts.php');
				exit(0);
			}
		}
	}

	/* * * * * * * * * * * * * * * * * * * * *
* - assume o id do post como parâmetro
* - Obtém o post do banco de dados
* - define campos de postagem no formulário para edição
	* * * * * * * * * * * * * * * * * * * * * */
	function editPost($role_id)
	{
		global $conn, $title, $post_slug, $body, $published, $isEditingPost, $post_id;
		$sql = "SELECT * FROM posts WHERE id=$role_id LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$post = mysqli_fetch_assoc($result);
// definir valores de formulário no formulário a ser atualizado
		$title = $post['title'];
		$body = $post['body'];
		$published = $post['published'];
	}

	function updatePost($request_values)
	{
		global $conn, $errors, $post_id, $title, $featured_image, $topic_id, $body, $published;

		$title = esc($request_values['title']);
		$body = esc($request_values['body']);
		$post_id = esc($request_values['post_id']);
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
		}
// create slug: se title for "The Storm Is Over", retorne "the-storm-over" como slug
		$post_slug = makeSlug($title);

		if (empty($title)) { array_push($errors, "O título da postagem é obrigatório "); }
		if (empty($body)) { array_push($errors, "Post body é obrigatório"); }
// se nova imagem em destaque tiver sido fornecida
		if (isset($_POST['featured_image'])) {
// Obter nome da imagem
		  	$featured_image = $_FILES['featured_image']['name'];
// diretório do arquivo de imagem
		  	$target = "../static/images/" . basename($featured_image);
		  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
		  		array_push($errors, "Não foi possível fazer o upload da imagem. Por favor, verifique as configurações do arquivo para o seu servidor");
		  	}
		}

// registra o tópico se não houver erros no formulário
		if (count($errors) == 0) {
			$query = "UPDATE posts SET title='$title', slug='$post_slug', views=0, image='$featured_image', body='$body', published=$published, updated_at=now() WHERE id=$post_id";
			// Anexar tópico para postar na tabela post_topic
			if(mysqli_query($conn, $query)){ // se post criado com sucesso
				if (isset($topic_id)) {
					$inserted_post_id = mysqli_insert_id($conn);
					// criar relacionamento entre postagem e tópico
					$sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
					mysqli_query($conn, $sql);
					$_SESSION['message'] = "Post criado com sucesso";
					header('location: posts.php');
					exit(0);
				}
			}
			$_SESSION['message'] = "Post atualizado com sucesso";
			header('location: posts.php');
			exit(0);
		}
	}
// delete post do blog
	function deletePost($post_id)
	{
		global $conn;
		$sql = "DELETE FROM post_topic WHERE post_id=$post_id"; 
        $deletaPost = mysqli_query($conn,$sql);
		$slq = "DELETE FROM posts WHERE id=$post_id";
		if (mysqli_query($conn, $slq)) {
			$_SESSION['message'] = "Postar com sucesso excluído";
			header("location: posts.php");
			exit(0);
		}
	}
	
	function createVideo($request_values)
	{
        global $conn, $errors, $user_id, $title, $featured_image, $topic_id, $body, $published;
        $user_id = esc($request_values['user_id']);
		$title = esc($request_values['title']);
		$body = htmlentities(esc($request_values['body']));
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
        }
		if (isset($request_values['publish'])) {
			$published = esc($request_values['publish']);
		}
		// create slug: if title is "The Storm Is Over", return "the-storm-is-over" as slug
		$post_slug = makeSlug($title);
// validar formulário
		if (empty($title)) { array_push($errors, "O título da postagem é obrigatório"); }
		if (empty($body)) { array_push($errors, "Post body é obrigatório"); }
		if (empty($topic_id)) { array_push($errors, "Postar tópico é obrigatório"); }
		// Obter nome da imagem
	  	$featured_image = $_FILES['featured_image']['name'];
	  	if (empty($featured_image)) { array_push($errors, "Imagem em destaque é necessária"); }
	  	// diretório do arquivo de imagem
	  	$target = "../static/videos/" . basename($featured_image);
	  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
	  		array_push($errors, "Não foi possível fazer o upload da imagem. Por favor, verifique as configurações do arquivo para o seu servidor ");
	  	}
// Assegure-se de que nenhuma postagem seja salva duas vezes. 
		$post_check_query = "SELECT * FROM posts_video WHERE slug='$post_slug' LIMIT 1";
		$result = mysqli_query($conn, $post_check_query);

		if (mysqli_num_rows($result) > 0) { // Se existir postagem
			array_push($errors, "Uma postagem já existe com esse título.");
		}
// criar post se não houver erros no formulário
		if (count($errors) == 0) {
			$query = "INSERT INTO posts_video (user_id, title, slug, video, body, published, created_at, updated_at) VALUES($user_id, '$title', '$post_slug', '$featured_image', '$body', $published, now(), now())";
			if(mysqli_query($conn, $query)){ // se post criado com sucesso
				$inserted_post_id = mysqli_insert_id($conn);
				// cria relacionamento entre post e topic
				$sql = "INSERT INTO post_video_topic_video (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
				mysqli_query($conn, $sql);

				$_SESSION['message'] = "Post criado com sucesso";
				header('location: videos.php');
				exit(0);
			}
		}
	}

	/* * * * * * * * * * * * * * * * * * * * *
* - assume o id do post como parâmetro
* - Obtém o post do banco de dados
* - define campos de postagem no formulário para edição
	* * * * * * * * * * * * * * * * * * * * * */
	function editVideo($role_id)
	{
		global $conn, $title, $post_slug, $body, $published, $isEditingPost, $post_id;
		$sql = "SELECT * FROM posts_video WHERE id=$role_id LIMIT 1";
		$result = mysqli_query($conn, $sql);
		$post = mysqli_fetch_assoc($result);
// definir valores de formulário no formulário a ser atualizado
		$title = $post['title'];
		$body = $post['body'];
		$published = $post['published'];
	}

	function updateVideo($request_values)
	{
		global $conn, $errors, $post_id, $title, $featured_image, $topic_id, $body, $published;

		$title = esc($request_values['title']);
		$body = esc($request_values['body']);
		$post_id = esc($request_values['post_id']);
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
		}
// create slug: se title for "The Storm Is Over", retorne "the-storm-over" como slug
		$post_slug = makeSlug($title);

		if (empty($title)) { array_push($errors, "O título da postagem é obrigatório "); }
		if (empty($body)) { array_push($errors, "Post body é obrigatório"); }
// se nova imagem em destaque tiver sido fornecida
		if (isset($_POST['featured_image'])) {
// Obter nome da imagem
		  	$featured_image = $_FILES['featured_image']['name'];
// diretório do arquivo de imagem
		  	$target = "../static/images/" . basename($featured_image);
		  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
		  		array_push($errors, "Não foi possível fazer o upload da imagem. Por favor, verifique as configurações do arquivo para o seu servidor");
		  	}
		}

// registra o tópico se não houver erros no formulário
		if (count($errors) == 0) {
			$query = "UPDATE posts_video SET title='$title', slug='$post_slug', views=0, image='$featured_image', body='$body', published=$published, updated_at=now() WHERE id=$post_id";
			// Anexar tópico para postar na tabela post_topic
			if(mysqli_query($conn, $query)){ // se post criado com sucesso
				if (isset($topic_id)) {
					$inserted_post_id = mysqli_insert_id($conn);
					// criar relacionamento entre postagem e tópico
					$sql = "INSERT INTO post_topic (post_id, topic_id) VALUES($inserted_post_id, $topic_id)";
					mysqli_query($conn, $sql);
					$_SESSION['message'] = "Post criado com sucesso";
					header('location: posts.php');
					exit(0);
				}
			}
			$_SESSION['message'] = "Post atualizado com sucesso";
			header('location: posts.php');
			exit(0);
		}
	}
// delete post do blog
	function deleteVideo($post_id)
	{
		global $conn;
		$sql = "DELETE FROM post_topic WHERE post_id=$post_id"; 
        $deletaPost = mysqli_query($conn,$sql);
		$slq = "DELETE FROM posts WHERE id=$post_id";
		if (mysqli_query($conn, $slq)) {
			$_SESSION['message'] = "Postar com sucesso excluído";
			header("location: posts.php");
			exit(0);
		}
    }

	
// se o usuário clicar no botão publicar postagem
if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
	$message = "";
	if (isset($_GET['publish'])) {
		$message = "Post publicado com sucesso";
		$post_id = $_GET['publish'];
		$sql = "UPDATE posts SET published=1 WHERE id=$post_id";
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = $message;
			header("location: posts.php");
			exit(0);
	}
	} else if (isset($_GET['unpublish'])) {
		$message = "Poste com sucesso não publicado";
		$post_id = $_GET['unpublish'];
		$sql = "UPDATE posts SET published=0 WHERE id=$post_id";
		if (mysqli_query($conn, $sql)) {
			$_SESSION['message'] = $message;
			header("location: posts.php");
			exit(0);
	}
}
}

?>