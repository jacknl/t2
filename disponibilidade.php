<?php
	//verifica se o login esta disponível para o cadastro
	//caso esteja, mostra 1
	//caso não, mostra 0
	
	require_once 'db.php';
	session_start();
	
	//valores estão setado
	if(!isset($_GET['login']) || !$_GET['login']){
		echo 0;
		return;
	}
	
	if(isset($_SESSION['logado']) && $_SESSION['logado'] == 'ok'){
		if($_SESSION['user']['login'] == $_GET['login']){
			echo 1;
			return;
		}	
	}
	
	//connecta com o banco de dados
	$con = db::connect();
	//conecção falhou
	if(is_int($con)){
		echo 0;
		return;
	}
	else{//pesquisa no banco
		$result = (mysql_query("SELECT `usuarios`.`login` FROM `usuarios` WHERE `login` = '".htmlentities($_GET['login'])."'"));
		if(!$result){//erro na consulta
			mysql_close($con);
			echo 0;
			return;
		}
		else{
			mysql_close($con); //fecha conecção com o bando de dados
			if(mysql_fetch_row($result)){ //retornou algo do banco, então login existe
				echo 0;
				return;
			}
			else{ //login não existe, está disponível
				echo 1;
				return;
			}
		}
	}
?>
