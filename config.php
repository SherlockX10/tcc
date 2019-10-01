<?php 
	session_start();
	// conectar-se ao banco de dados
	$conn = mysqli_connect("localhost", "root", "", "tcc");

	if (!$conn) {
		die("Erro ao conectar-se ao banco de dados: " . mysqli_connect_error());
	}
    // definir constantes globais
	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost/tcc/');
?>