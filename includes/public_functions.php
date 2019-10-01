<?php 
/* * * * * * * * * * * * * * *
* Retorna todas as postagens publicadas
* * * * * * * * * * * * * * */
function getPublishedPosts() {
	// usar objeto global $ conn na função
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true ORDER BY id DESC LIMIT 2, 9";
	$result = mysqli_query($conn, $sql);
	// buscar todos os posts como um array associativo chamado $ posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function getPublishedPostss() {
	// use global $conn objeto de função
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true ORDER BY id DESC LIMIT 2";
	$result = mysqli_query($conn, $sql);
	// buscar todos os posts como um array associativo chamado $ posts
	$postsc = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($postsc as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function getPublishedPostsss() {
	// usar objeto global $ conn na função
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	// buscar todos os posts como um array associativo chamado $ posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function getPublishedPostssss() {
	// usar objeto global $ conn na função
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true ORDER BY id DESC LIMIT  1, 4";
	$result = mysqli_query($conn, $sql);
	// buscar todos os posts como um array associativo chamado $ posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function getPublishedVideos() {
	// usar objeto global $ conn na função
	global $conn;
	$sql = "SELECT * FROM posts_video WHERE published=true ORDER BY id DESC LIMIT  1";
	$result = mysqli_query($conn, $sql);
	// buscar todos os posts como um array associativo chamado $ posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopicV($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * *
* Recebe um post id e
* Retorna o tópico da postagem
* * * * * * * * * * * * * * */
function getPostTopic($post_id){
	global $conn;
	$sql = "SELECT * FROM topics WHERE id=
			(SELECT topic_id FROM post_topic WHERE post_id=$post_id) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}

function getPostTopicV($post_id){
	global $conn;
	$sql = "SELECT * FROM topics_video WHERE id=
			(SELECT topic_id FROM post_video_topic_video WHERE post_id=$post_id) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}

/* * * * * * * * * * * * * * * *
* Retorna todos os posts em um tópico
* * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($topic_id) {
	global $conn;
	$sql = "SELECT * FROM posts ps 
			WHERE ps.id IN 
			(SELECT pt.post_id FROM post_topic pt 
				WHERE pt.topic_id=$topic_id GROUP BY pt.post_id 
				HAVING COUNT(1) = 1)";
	$result = mysqli_query($conn, $sql);
// buscar todas as postagens como uma matriz associativa chamada $ posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * * *
* Retorna o nome do tópico por ID do tópico
* * * * * * * * * * * * * * * * */
function getTopicNameById($id)
{
	global $conn;
	$sql = "SELECT name FROM topics WHERE id=$id";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic['name'];
}


/* * * * * * * * * * * * * * *
* Retorna um único post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $conn;	
// Obtém slug de post único
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
	$result = mysqli_query($conn, $sql);

// buscar resultados de consulta como matriz associativa.
	$post = mysqli_fetch_assoc($result);
	if ($post) {	
// pega o tópico ao qual este post pertence
		$post['topic'] = getPostTopic($post['id']);
	}
	
	return $post;
}
/* * * * * * * * * * * *
* Retorna todos os tópicos
* * * * * * * * * * * * */
function getAllTopics()
{
	global $conn;
	$sql = "SELECT * FROM topics";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}

?>

