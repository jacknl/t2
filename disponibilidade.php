<?php
	//verifica se o login esta dispon�vel para o cadastro
	//caso esteja, mostra 1
	//caso n�o, mostra 0
	
	require_once 'db.php';
	session_start();
	
	//valores est�o setado
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
	//conec��o falhou
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
			mysql_close($con); //fecha conec��o com o bando de dados
			if(mysql_fetch_row($result)){ //retornou algo do banco, ent�o login existe
				echo 0;
				return;
			}
			else{ //login n�o existe, est� dispon�vel
				echo 1;
				return;
			}
		}
	}
?>
