<?php
	require_once("config.php");
	/* teste inicial com um select simples apenas para verificação do funcionamento das classes */
	/*
	$sql = new Sql();
	$usuarios = $sql->select("SELECT * FROM tb_usuarios");
	echo json_encode($usuarios);
	*/
	/* sequencia da construção do código para análise mais apurada das classes porém ainda com a visão de seleção de apenas um usuário */
	$root = new Usuario();
	$root->loadById(3);
	echo $root;

	//Carrega uma lista de usuários
	echo "<br><br>";
	/* o getList foi chamado diretamente por ser um método static */
	$lista = Usuario::getList();
	echo json_encode($lista);

	/* Carrega uma lista de usuários buscando parte ou todo o login passado via parametro */
	echo "<br><br>";
	$search = Usuario::search("tes");
	echo json_encode($search);

	//Carrega um usuário usando login e a senha
	echo "<br><br>";
	$usuario = new Usuario();
	$usuario->login("teste2","teste2");
	echo $usuario;
?>