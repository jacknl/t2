<?php 
require_once 'erro.php'; 
session_start();

if(isset($_SESSION['logado']) && $_SESSION['logado'] == 'ok') header('Location: inicio.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="css/index.css" type="text/css" media="screen" title="default">
<title>Music Video Search</title>
</head>
<body>
<p>Music Video Search</p>

<?php if(isset($_GET['status'])) echo status($_GET['status']); ?>

<form method="post" action="login.php">
	<div class="entrar">
		<div class="login">Login: <input type="text" name="login" placeholder="Login"></div>
		<div class="senha">Senha: <input type="password" name="senha" placeholder="Senha"></div>
		<a href="cadastro.php">Cadastrar-se</a>
		<input type="submit" value="Realizar Login">
	</div>
</form>
</body>
</html>
