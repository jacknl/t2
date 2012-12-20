<?php 
	require_once 'db.php';
	require_once 'recaptcha-php-1.11/recaptchalib.php';
	require_once 'formulario_funcoes.php';
	session_start();
	
	if(!isset($_POST["recaptcha_response_field"])){
		pegaValores();
		header('Location: cadastro.php?status=405');
	}

	//$privatekey = '6Lchf9oSAAAAALHO7I8EE_o--8rP_ZeXA9D8DGFI'; //localhost
	$privatekey = '6LdMmNoSAAAAAD3_oqd6HVQbeeXQmmwUXX2hpUV7'; //jacknl.my.phpcloud.com
	$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
	
	if(!$resp->is_valid){
		pegaValores();
		header('Location: cadastro.php?status=405');
	}
	else{
		if($_POST['senha1'] == $_POST['senha2'] && strlen($_POST['senha1']) >= 6 && strlen($_POST['senha1']) <= 32){
			if(isName($_POST['nome']) && 
			   	isLogin($_POST['login']) && 
				isEmail($_POST['email']) &&
				strlen($_POST['nome']) <= 64 && strlen($_POST['nome']) >= 6 &&
				strlen($_POST['login']) <= 32 && strlen($_POST['login']) >= 4 &&
				strlen($_POST['email']) >= 10 && strlen($_POST['email']) <= 64
			){
				$nome = htmlentities($_POST['nome']);
				$login = htmlentities($_POST['login']);
				$senha = md5($_POST['senha1']).md5('HB9hhf87fgsaf87gfk');
				$email = htmlentities($_POST['email']);
				
				$con = db::connect();
				if(is_int($con)) header('Location: cadastro.php?status='.$con);
				else{
					if(!(mysql_query("INSERT INTO `usuarios` (`id`, `nome`, `login`, `senha`, `email`) VALUES (NULL, '$nome', '$login', '$senha', '$email')"))){
						mysql_close($con);
						pegaValores();
						header('Location: cadastro.php?status=401');
					}
					mysql_close($con);
					session_destroy();
					header('Location: cadastro.php?status=200');
				}
				
			}
			else{
				pegaValores();
				header('Location: cadastro.php?status=400');
			}
		}
		else{
			pegaValores();
			header('Location: cadastro.php?status=400');
		}
	}
?>
