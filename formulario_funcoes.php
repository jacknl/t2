<?php 
	//pega valores para preencher os campos do cadastro quando algum campo esta errado
	function pegaValores(){
		if(isset($_POST['nome'])) $_SESSION['cadastro']['nome'] = $_POST['nome'];
		if(isset($_POST['login'])) $_SESSION['cadastro']['login'] = $_POST['login'];
		if(isset($_POST['email'])) $_SESSION['cadastro']['email'] = $_POST['email'];
	}
	
	function isName($nome){
		$pattern = '/^[ a-zA-ZáéíóúÁÉÍÓÚ]+$/';
		if(preg_match($pattern, $nome)){
			return true;
		}else{
			return false;
		}
	}
	
	function isLogin($login){
		$pattern = '/^[_a-zA-Z-0-9]+$/';
		if(preg_match($pattern, $login)){
			return true;
		}else{
			return false;
		}
	}
	
	function isEmail($email){
		$pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if(preg_match($pattern, $email)){
			return true;
		}else{
			return false;
		}
	}
?>
