<?php
	class Usuario{
		private $idusuario;
		private $deslogin;
		private $dessenha;
		private $dtcadastro;

		public function getIdusuario(){
			return $this->idusuario;
		}
		public function setIdusuario($value){
		 	$this->idusuario = $value;
		}

		public function getDeslogin(){
			return $this->deslogin;
		}
		public function setDeslogin($value){
		 	$this->deslogin = $value;
		}

		public function getDessenha(){
			return $this->dessenha;
		}
		public function setDessenha($value){
		 	$this->dessenha = $value;
		}

		public function getDtcadastro(){
			return $this->dtcadastro;
		}
		public function setDtcadastro($value){
		 	$this->dtcadastro = $value;
		}

		public function loadById($id){
			$sql = new Sql();
			$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));
			if (count ($results) > 0){
				$this->setData($results[0]);
				
				/* 

				trecho abaixo foi substuído pela função e por consequencia, linha acima 

				$row = $results[0];
				$this->setIdusuario($row['idusuario']);
				$this->setDeslogin($row['deslogin']);
				$this->setDessenha($row['dessenha']);
				$this->setDtcadastro(new DateTime($row['dtcadastro']));
				*/
			}
		}

		/*como não se usa a palavra this no método getList, ele pode ser static e portanto não é necessário instanciar o objeto na chamada do método. Quando existe o this dentro do método isso significa que existe atribuição de valores ou chamada de outros métodos, ou seja, essa classe fica mais complexa*/
		public static function getList(){
			$sql = new Sql();
			return $sql->select ("SELECT * FROM tb_usuarios ORDER BY deslogin;");
		}

		public static function search($login){
			$sql = new Sql();
			return $sql->select ("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin;",array(
				':SEARCH'=>"%" . $login . "%"
			));
		}

		public function login($login,$password){
			$sql = new Sql();
			$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
				":LOGIN"=>$login,
				":PASSWORD"=>$password
			));
			if (count ($results) > 0){
				$this->setData($results[0]);			
			} else {
				throw new Exception("Login e/ou senha inválidos.");
			}

		}

		public function setData($data){
			$this->setIdusuario($data['idusuario']);
			$this->setDeslogin($data['deslogin']);
			$this->setDessenha($data['dessenha']);
			$this->setDtcadastro(new DateTime($data['dtcadastro']));
		}

		public function insert(){
			$sql = new Sql();
			//Funcção com story procedure
			$results = $sql->select("CALL sp_usuarios_insert(:LOGIN,:PASSWORD)",array(
				':LOGIN'=>$this->getDeslogin(),
				':PASSWORD'=>$this->getDessenha()
			));
			if(count($results) > 0){
				$this->setData($results[0]);
			}
		}

		public function update($login,$password){
			$this->setDeslogin($login);
			$this->setDessenha($password);

			$sql = new Sql();
			$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID;", array(
				':LOGIN'=>$this->getDeslogin(),
				':PASSWORD'=>$this->getDessenha(),
				':ID'=>$this->getIdusuario()
			));
		}

		public function delete(){
			$sql = new Sql();
			$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
				':ID'=>$this->getIdusuario()
			));
			$this->setIdusuario(0);
			$this->setDeslogin("");
			$this->setDessenha("");
			$this->setDtcadastro(new DateTime());
		}

		//No metodo construtor, quando se coloca a variável = "", significa que, caso algum metodo de outra classe chame o construtor e não passe os parametros de usuário e senha, o sistema não dará erro como se as informações fossem obrigatórias. Dessa forma, o código utiliza a mesma classe para ambas as funcionalidades. */
		public function __construct($login = "",$password = ""){
			$this->setDeslogin($login);
			$this->setDessenha($password);
		}

		public function __toString(){
			return json_encode(array(
				"idusuario"=>$this->getIdusuario(),
				"deslogin"=>$this->getDeslogin(),
				"dessenha"=>$this->getDessenha(),
				"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
			));
		}
	}
?>