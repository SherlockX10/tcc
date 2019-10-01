<?php
// Variáveis ​​do usuário administrador
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$rolee = "";
$email = "";
// general variables
$errors = [];

/* - - - - - - - - - - 
- Ações dos usuários administradores
- - - - - - - - - - -*/
//se o usuário clicar no botão create admin
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}
// se o usuário clicar no botão Editar admin
if (isset($_GET['edit-admin'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-admin'];
	editAdmin($admin_id);
}
//se o usuário clicar no botão de atualização do administrador
if (isset($_POST['update_admin'])) {
	updateAdmin($_POST);
}
// se o usuário clicar no botão Excluir admin
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	deleteAdmin($admin_id);
}

/* - - - - - - - - - - - -
-  Funções dos usuários administradores
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Recebe novos dados de administrador do formulário
* - Criar novo usuário admin
* - Retorna todos os usuários administradores com suas funções
* * * * * * * * * * * * * * * * * * * * * * */
function createAdmin($request_values)
{
	global $conn, $errors, $role, $username, $email, $rolee;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	if (isset($request_values['role'])) {
		$role = esc($request_values['role']);
	}

	if (isset($request_values['escola'])) {
		$rolee = esc($request_values['escola']);
	}
	// validação de formulário: verifique se o formulário está preenchido corretamente
	if (empty($username)) {
		array_push($errors, "Uhmm ... Nós vamos precisar do nome de usuário");
	}
	if (empty($email)) {
		array_push($errors, "Ops .. E-mail está faltando");
	}
	if (empty($role)) {
		array_push($errors, "A função é necessária para usuários administradores");
	}
	if (empty($password)) {
		array_push($errors, "uh-oh você esqueceu a senha");
	}
	if ($password != $passwordConfirmation) {
		array_push($errors, "As duas senhas não combinam");
	}
	// Assegure-se de que nenhum usuário seja registrado duas vezes.
	// o email e os nomes de usuários devem ser únicos
	$user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	if ($user) { // se o usuário existe
		if ($user['username'] === $username) {
			array_push($errors, "O nome de usuário já existe");
		}

		if ($user['email'] === $email) {
			array_push($errors, "e-mail já existe");
		}
	}
	// registrar usuário se não houver erros no formulário
	if (count($errors) == 0) {
		$password = md5($password); //criptografar a senha antes de salvar no banco de dados

		if ($rolee == "") {
			$query = "INSERT INTO users (username, email, idtipo_user, password, created_at, updated_at, idtipo_escola) 
			VALUES('$username', '$email', '$role', '$password', now(), now(), null)";
			mysqli_query($conn, $query);

			$_SESSION['message'] = "Cadastro realizado com sucesso";
			header('location: users.php');
			exit(0);
		} else {
			$query = "INSERT INTO users (username, email, idtipo_user, password, created_at, updated_at, idtipo_escola) 
				  VALUES('$username', '$email', '$role', '$password', now(), now(), '$rolee')";
			mysqli_query($conn, $query);

			$_SESSION['message'] = "Cadastro realizado com sucesso";
			header('location: users.php');
			exit(0);
		}
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - assume o ID do administrador como parâmetro
* - Busca o administrador do banco de dados
* - define campos de administração no formulário para edição
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $conn, $username, $role, $isEditingUser, $admin_id, $email;

	$sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// definir valores de formulário ($ username e $ email) no formulário a ser atualizado
	$username = $admin['username'];
	$email = $admin['email'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Recebe solicitação de administrador do formulário e atualiza no banco de dados
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values)
{
	global $conn, $errors, $role, $username, $isEditingUser, $admin_id, $email;
	// get id do administrador para ser atualizado
	$admin_id = $request_values['admin_id'];
	// define o estado de edição para falso
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if (isset($request_values['role'])) {
		$role = $request_values['role'];
	}
	// registrar usuário se não houver erros no formulário
	if (count($errors) == 0) {
		// criptografar a senha (fins de segurança)
		$password = md5($password);

		$query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$admin_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Usuário administrador atualizado com sucesso";
		header('location: users.php');
		exit(0);
	}
}
// delete admin user 
function deleteAdmin($admin_id)
{
	global $conn;
	$slq = "DELETE FROM users WHERE id=$admin_id";
	if (mysqli_query($conn, $slq)) {
		$_SESSION['message'] = "Usuário excluído com sucesso";
		header("location: users.php");
		exit(0);
	}
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Retorna todos os usuários administradores e suas funções correspondentes
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAdminUsers()
{
	global $conn;
	$sql = "SELECT * FROM users WHERE idtipo_user IS NOT NULL";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}

function getAdminTypes()
{
	global $conn;
	$query = mysqli_query($conn, "SELECT * FROM tipo_user");
	$queryy = mysqli_query($conn, "SELECT * FROM tipo_user WHERE idtipo_user = 1 or idtipo_user = 5 or idtipo_user = 6");

	return $query;
}

function getAdminTypes_escola()
{
	global $conn;
	$query = mysqli_query($conn, "SELECT * FROM tipo_escola");
	$queryy = mysqli_query($conn, "SELECT * FROM tipo_escola");

	return $query;
}

/* * * * * * * * * * * * * * * * * * * * *
* - Escapa ao formulário de valor enviado, portanto, impedindo a injeção de SQL
* * * * * * * * * * * * * * * * * * * * * */
function esc(String $value)
{
	// trazer o objeto de conexão global db para a função
	global $conn;
	// remover o espaço vazio
	$val = trim($value);
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}
// Recebe uma string como 'Some Sample String'
// e retorna 'some-sample-string'
function makeSlug(String $string)
{
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}
?>

<?php
// Variáveis ​​do usuário administrador
// ... variáveis ​​aqui ...

// Topics variables
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";

/* - - - - - - - - - - 
- Ações dos usuários administradores
- - - - - - - - - - -*/
// ... 

/* - - - - - - - - - - 
- Ações do tópico
- - - - - - - - - - -*/
// se o usuário clicar no botão Criar tópico
if (isset($_POST['create_topic'])) {
	createTopic($_POST);
}
// se o usuário clicar no botão Editar tópico
if (isset($_GET['edit-topic'])) {
	$isEditingTopic = true;
	$topic_id = $_GET['edit-topic'];
	editTopic($topic_id);
}
// se o usuário clicar no botão do tópico de atualização
if (isset($_POST['update_topic'])) {
	updateTopic($_POST);
}
// se o usuário clicar no botão Excluir tópico
if (isset($_GET['delete-topic'])) {
	$topic_id = $_GET['delete-topic'];
	deleteTopic($topic_id);
}


/* - - - - - - - - - - - -
- funções dos usuários Admin
- - - - - - - - - - - - -*/
// ...

/* - - - - - - - - - - 
- Funções de tópicos
- - - - - - - - - - -*/
// obtém todos os tópicos do DB
function getAllTopics()
{
	global $conn;
	$sql = "SELECT * FROM topics";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}
function createTopic($request_values)
{
	global $conn, $errors, $topic_name;
	$topic_name = esc($request_values['topic_name']);
	// create slug: se o tópico for "Life Advice", retorne "life-advice" como slug
	$topic_slug = makeSlug($topic_name);
	// validate form
	if (empty($topic_name)) {
		array_push($errors, "Topic name required");
	}
	// Assegure-se de que nenhum tópico seja salvo duas vezes.
	$topic_check_query = "SELECT * FROM topics WHERE slug='$topic_slug' LIMIT 1";
	$result = mysqli_query($conn, $topic_check_query);
	if (mysqli_num_rows($result) > 0) { // se o tópico existir
		array_push($errors, "Tópico já existe");
	}
	// registrar tópico se não houver erros no formulário
	if (count($errors) == 0) {
		$query = "INSERT INTO topics (name, slug) 
				  VALUES('$topic_name', '$topic_slug')";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Tópico criado com sucesso";
		header('location: topics.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - toma o id do tópico como parâmetro
* - Obtém o tópico do banco de dados
* - define campos de tópicos no formulário para edição
* * * * * * * * * * * * * * * * * * * * * */
function editTopic($topic_id)
{
	global $conn, $topic_name, $isEditingTopic, $topic_id;
	$sql = "SELECT * FROM topics WHERE id=$topic_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	// definir valores de formulário ($ topic_name) no formulário a ser atualizado
	$topic_name = $topic['name'];
}
function updateTopic($request_values)
{
	global $conn, $errors, $topic_name, $topic_id;
	$topic_name = esc($request_values['topic_name']);
	$topic_id = esc($request_values['topic_id']);
	// create slug: se o tópico for "Life Advice", retorne "life-advice" como slug
	$topic_slug = makeSlug($topic_name);
	// validar formulário
	if (empty($topic_name)) {
		array_push($errors, "Nome do Tópico Requerido");
	}
	// registra o tópico se não houver erros no formulário
	if (count($errors) == 0) {
		$query = "UPDATE topics SET name='$topic_name', slug='$topic_slug' WHERE id=$topic_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Tópico atualizado com sucesso";
		header('location: topics.php');
		exit(0);
	}
}
// delete topic
function deleteTopic($topic_id)
{
	global $conn;
	$sql = "DELETE FROM topics WHERE id=$topic_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Tópico excluído com sucesso";
		header("location: topics.php");
		exit(0);
	}
}

function getAllTopicsV()
{
	global $conn;
	$sql = "SELECT * FROM topics_video";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}
