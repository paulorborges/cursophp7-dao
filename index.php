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
?>