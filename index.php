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

	//Inserir novo usuário passando parametros via construtor
	echo "<br><br>";
	$aluno = new Usuario("coborges","123456");
	$aluno->insert();
	echo $aluno;

	//Alteração de informações por código de usuário
	echo "<br><br>";
	$usuario2 = new Usuario();
	$usuario2->loadById(11);
	$usuario2->update("teste34","senhaProfessor");
	echo $usuario2;

	//Deletar usuário
	echo "<br><br>";
	$usuario3 = new Usuario();
	$usuario3->loadById(11);
	$usuario3->delete();
	echo $usuario3;
?>