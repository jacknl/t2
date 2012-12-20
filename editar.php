<?php 
require_once 'erro.php'; 
require_once 'recaptcha-php-1.11/recaptchalib.php';
session_start();

if(!(isset($_SESSION['logado']) && $_SESSION['logado'] == 'ok')) header('Location: index.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="css/formulario.css" type="text/css" media="screen" title="default">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/formulario.js" type="text/javascript"></script>
<title>Music Video Search</title>
</head>
<body>
<p>Editar Cadastro</p>

<?php if(isset($_GET['status'])) echo status($_GET['status']); ?>

<form method="post" action="update.php">
	<div class="formulario editar">
		<table>
			<tr class="tr">
				<td>Nome: </td>
				<td><div class="nome"><input type="text" name="nome" placeholder="M�nimo 6 e M�ximo 64 caract�res" value="<?php echo @$_SESSION['user']['nome']?>"></div></td>
			</tr>
			<tr class="tr">
				<td>Login: </td>
				<td><div class="login"><input type="text" name="login" placeholder="M�n 4 e M�x 32 caract�res com/sem underscore _" value="<?php echo @$_SESSION['user']['login']?>"></div></td>
			</tr>
			<tr class="tr">
				<td></td>
				<td class="disponibilidade"><div>Verificar Disponibilidade</div></td>
			</tr>
			<tr class="tr">
				<td>Senha atual: </td>
				<td><div class="senha_atual"><input type="password" name="senha_atual" placeholder="M�nimo 6 e M�ximo 32 caract�res"></div></td>
			</tr>
			<tr class="tr">
				<td>Nova senha: </td>
				<td><div class="senha1"><input type="password" name="senha1" placeholder="M�nimo 6 e M�ximo 32 caract�res"></div></td>
			</tr>
			<tr class="tr">
				<td>Repita a nova senha: </td>
				<td><div class="senha2"><input type="password" name="senha2" placeholder="Senhas devem ser iguais"></div></td>
			</tr>
			<tr class="tr">
				<td>E-mail: </td>
				<td><div class="email"><input type="text" name="email" placeholder="M�nimo 10 e M�ximo 64 caract�res" value="<?php echo @$_SESSION['user']['email']?>"></div></td>
			</tr>
			<tr class="tr">
				<td>Captcha: </td>
				<td class="captcha">
					<?php
		          		//$publickey = "6Lchf9oSAAAAAMfUwhzVAYZdN5DNuyjzzohlz1qn"; //localhost
		          		$publickey = '6LdMmNoSAAAAALOmSmDMMpi34Mm2oTNvnCcX1CEv'; //jacknl.my.phpcloud.com
		          		echo recaptcha_get_html($publickey);
			        ?>
        		</td>
			</tr>
		</table>
		
		<input class="home" type="button" value="Voltar" onclick="window.location.href='<?php echo @$_SESSION['link']; ?>'">
		<div class="ok_off">Atualizar</div>
		<input class="ok" style="display: none;" type="submit" value="Atualizar">
	</div>
</form>
</body>
</html>