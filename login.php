<?php
	session_start();
	require_once 'db.php';
	
	if(!isset($_POST['login']) || !isset($_POST['senha'])){
		header('Location: index.php');
		return;
	}
	
	$login = htmlentities($_POST['login']);
	$senha = md5($_POST['senha']).md5('HB9hhf87fgsaf87gfk');
	$con = db::connect();
	
	if(is_int($con)){
		$_SESSION['logado'] = 'erro';
		$_SESSION['user'] = '';
		header('Location: index.php?status='.$con);
	}
	else{
		$user = mysql_query('SELECT `usuarios`.* FROM `usuarios` WHERE `login` = \''.$login.'\' AND `senha` = \''.$senha.'\'');
		$user = mysql_fetch_assoc($user);
		
		if($user){
			$_SESSION['logado'] = 'ok';
			$_SESSION['user'] = $user;
			mysql_close($con);
			header('Location: inicio.php');
		}
		else{
			$_SESSION['logado'] = 'erro';
			$_SESSION['user'] = '';
			mysql_close($con);
			header('Location: index.php?status=404');
		}
	}
?>