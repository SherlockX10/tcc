<?php 
	// Declaração de variáveis
	$username = "";
	$email    = "";
	$errors = array(); 

	// REGISTRO DE USUÁRIO
	if (isset($_POST['reg_user'])) {	
// recebe todos os valores de entrada do formulário
		$username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$password_1 = esc($_POST['password_1']);
		$password_2 = esc($_POST['password_2']);
		$type_relation = esc($_POST['tipo']);
	
// validação de formulário: verifique se o formulário está preenchido corretamente
		if (empty($username)) {  array_push($errors, "Uhmm ... vamos precisar do seu nome de usuário"); }
		if (empty($email)) { array_push($errors, "Ops .. O email está em falta"); }
		if (empty($password_1)) { array_push($errors, "uh-oh você esqueceu a senha"); }
		if ($password_1 != $password_2) { array_push($errors, "As duas senhas não combinam");}

// Assegure-se de que nenhum usuário seja registrado duas vezes.
// o email e os nomes de usuários devem ser únicos
		$user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);

		if ($user) {// se o usuário existir
			if ($user['username'] === $username) {
			  array_push($errors, "O nome de usuário já existe");
			}
			if ($user['email'] === $email) {
			  array_push($errors, "E-mail já existe");
			}
		}
		// registrar usuário se não houver erros no formulário
		if (count($errors) == 0) {
			$password = md5($password_1);// criptografar a senha antes de salvar no banco de dados
			$query = "INSERT INTO users (username, email, idtipo_user, password, created_at, updated_at) 
					  VALUES('$username', '$email', '$type_relation', '$password', now(), now())";
			mysqli_query($conn, $query);

			// get id do usuário criado
			$reg_user_id = mysqli_insert_id($conn); 

			// coloca o usuário logado no array de sessão
			$_SESSION['user'] = getUserById($reg_user_id);

			// se o usuário for admin, redirecione para a área de administração
			if ( in_array($_SESSION['user']['idtipo_user'], ["1", "5"])) {
				$_SESSION['message'] = "Agora você está logado";
				// redirecionar para a área de administração
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['message'] = "Agora você está logado";
				// redirecionar para área pública
				header('location: index.php');				
				exit(0);
			}
		}
	}

	// LOG USER IN
	if (isset($_POST['login_btn'])) {
		$username = esc($_POST['username']);
		$password = esc($_POST['password']);

		if (empty($username)) { array_push($errors, "Nome requerido"); }
		if (empty($password)) { array_push($errors, "Senha requerida"); }
		if (empty($errors)) {
			$password = md5($password); // criptografar senha
			$sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// get id do usuário criado
				$reg_user_id = mysqli_fetch_assoc($result)['id']; 

				// coloca o usuário logado no array de sessão
				$_SESSION['user'] = getUserById($reg_user_id); 
				// se o usuário for admin, redirecione para a área de administração
				if ( in_array($_SESSION['user']['idtipo_user'], ["1", "5", "6"])) {
					$_SESSION['message'] = "Agora você está logado";
					// redirecionar para a área de administração
					header('location: ' . BASE_URL . '/admin/dashboard.php');
					exit(0);
				} else if ( in_array($_SESSION['user']['idtipo_user'], ["2"])) {
					$_SESSION['message'] = "Agora você está logado";
					// redirecionar para a área de administração
					header('location: ' . BASE_URL . '/users/admv/index.php');
					exit(0); }

					else if ( in_array($_SESSION['user']['idtipo_user'], ["3"])) {
						$_SESSION['message'] = "Agora você está logado";
						// redirecionar para a área de administração
						header('location: ' . BASE_URL . '/users/student/index.php');
						exit(0); }

						else if ( in_array($_SESSION['user']['idtipo_user'], ["4"])) {
							$_SESSION['message'] = "Agora você está logado";
							// redirecionar para a área de administração
							header('location: ' . BASE_URL . '/users/teacher/index.php');
							exit(0); }
				
				else {
					$_SESSION['message'] = "Agora você está logado";
					// redirecionar para área pública
					header('location: index.php');				
					exit(0);
				}
			} else {
				array_push($errors, 'Credenciais erradas');
			}
		}
	}
	// valor de escape do formulário
	function esc(String $value)
	{	
		// traz o objeto de conexão global db para a função
		global $conn;

		$val = trim($value); // remove o espaço vazio
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}
	// Obter informações do usuário a partir do ID do usuário
	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

// retorna o usuário em um formato de matriz:
// ['id' => 1 'username' => 'Awa', 'email' => 'a@a.com', 'password' => 'mypass']
		return $user; 
	}
?>