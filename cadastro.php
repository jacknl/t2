<?php 
require_once 'erro.php'; 
require_once 'recaptcha-php-1.11/recaptchalib.php';
session_start();
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
<p>Realizar Cadastro</p>

<?php if(isset($_GET['status'])) echo status($_GET['status']); ?>

<form method="post" action="cadastrar.php">
	<div class="formulario cadastro">
		<table>
			<tr class="tr">
				<td>Nome: </td>
				<td><div class="nome"><input type="text" name="nome" placeholder="Mínimo 6 e Máximo 64 caractéres" value="<?php echo @$_SESSION['cadastro']['nome']?>"></div></td>
			</tr>
			<tr class="tr">
				<td>Login: </td>
				<td><div class="login"><input type="text" name="login" placeholder="Mín 4 e Máx 32 caractéres com/sem underscore _" value="<?php echo @$_SESSION['cadastro']['login']?>"></div></td>
			</tr>
			<tr class="tr">
				<td></td>
				<td class="disponibilidade"><div>Verificar Disponibilidade</div></td>
			</tr>
			<tr class="tr">
				<td>Senha: </td>
				<td><div class="senha1"><input type="password" name="senha1" placeholder="Mínimo 6 e Máximo 32 caractéres"></div></td>
			</tr>
			<tr class="tr">
				<td>Repita a senha: </td>
				<td><div class="senha2"><input type="password" name="senha2" placeholder="Senhas devem ser iguais"></div></td>
			</tr>
			<tr class="tr">
				<td>E-mail: </td>
				<td><div class="email"><input type="text" name="email" placeholder="Mínimo 10 e Máximo 64 caractéres" value="<?php echo @$_SESSION['cadastro']['email']?>"></div></td>
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
		
		<input class="home" type="button" value="Home" onclick="window.location.href='index.php'">
		<div class="ok_off">Cadastrar</div>
		<input class="ok" style="display: none;" type="submit" value="Cadastrar">
	</div>
</form>
</body>
</html>