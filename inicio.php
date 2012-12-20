<?php 
	require_once 'pesquisa.php'; 
	session_start();
	//caso nao estiver logado, redimensiona para a index
	
	if(!isset($_SESSION['logado']) || $_SESSION['logado'] != 'ok') header('Location: index.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="css/inicio.css" type="text/css" media="screen" title="default">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/inicio.js" type="text/javascript"></script>
<title>Music Video Search</title>
</head>
<body>

<?php
//existe uma pesquisa
if(isset($_GET['pesquisa']) && $_GET['pesquisa']){
	//realiza a pesquisa
	$resultado = pesquisa($_GET['pesquisa']);
	
	//caso o nome seja muito grande, encurta ele
	if(isset($_SESSION['user']['nome']) && strlen($_SESSION['user']['nome']) > 15) $nome = substr($_SESSION['user']['nome'], 0, 15).'...';
	else $nome = @$_SESSION['user']['nome'];
	
	//parte inicial, titulo pesquisa
	echo'<div class="inicio">
			<p>Music Video Search</p>
			<div class="logado">
				<div class="exibe">
					<div class="nome">'.$nome.'</div>
					<div class="editar"><a href="editar.php">Editar</a></div>
					<div class="logout"><a href="logout.php">Logout</a></div>
				</div>
			</div>
		</div>
		<div class="content">
			<form method="get" action="inicio.php">
				<div class="campos_inicio">
					<div class="botao_menos_info">&lt;&lt; Menos</div>';
	
	//botao de ativar e desativar a traducao, quando tiver
	if(isset($_GET['traducao']) && $_GET['traducao'] && isset($resultado['letra']['traducao'])){
		echo 		'<div class="traducao_botao">Desativar Tradução</div>';
	}
	else if(isset($resultado['letra']['traducao'])){
		echo 		'<div class="traducao_botao">Tradução</div>';
	}
	
	//botao curtir, botao tweetar e campo de pesquisa
	echo 		    '<div class="curtir">
						<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fjacknl.my.phpcloud.com%2Ft2%2F&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;font&amp;colorscheme=dark&amp;action=like&amp;height=21" style="border:none; overflow:hidden; width:80px; height:21px;"></iframe>
					</div>
					<div class="tweetar">
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="jacknl.my.phpcloud.com/t2/" data-text="Pesquise qualquer música, e veja a letra, tradução, vídeo, informações da banda e muito mais. ==>> http://migre.me/csTNg " data-lang="pt" data-hashtags="MusicVideoSearch">Tweetar</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>
					<input class="pesquisar_botao" type="submit" value="Pesquisar">
					<input class="pesquisar" type="text" name="pesquisa" placeholder="EX: One, by Metallica" value="'.@$_GET['pesquisa'].'">
				</div>
			</form>';
	
	
	//mostra as informacoes da banda
	echo '<div class="informacoes">';
	if(isset($resultado['info']['biografia'])){
		echo '<div>'.$resultado['info']['nome'].'</div><img src="'.$resultado['info']['imagem'].'" alt="Imagem da banda">';
		
		foreach($resultado['info']['biografia'] as $value){
			if($value) echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value.'</p>';
			else echo '<p>&nbsp;</p>';
		}
	}
	else{
		echo '<div class="nada">Nenhuma Informação Encontrada</div>';
	}
	echo '</div>';
	
	if(isset($resultado['letra']) && $resultado['letra']){
		echo '<div class="letra"><p>['.$resultado['letra']['musica'].']</p><p>&nbsp;</p>';
		//mostra a letra
		$i = 1;
		if(isset($resultado['letra']['letra'])){
			foreach($resultado['letra']['letra'] as $value){
				if($value) echo '<p>'.$value.'</p>';
				else echo '<p>&nbsp;</p>';
				$i++;
			}
		}
		echo '</div>';
		
		//coloca a traducao, caso tiver
		if(isset($resultado['letra']['traducao'])){
			echo'<div class="traducao">';
			
			//mostra a traducao da letra
			foreach($resultado['letra']['traducao'] as $key=>$value){
				if($key == 1 && $value){
					echo '<p>&nbsp;</p>';
					$i--;
				}
				if($value) echo '<p>'.$value.'</p>';
				else echo '<p>&nbsp;</p>';
				if(!$i) break;
				$i--;
			}
			echo '</div>';
		}
	}
	else{
		echo '<div class="letra"><p>Letra não encontrada</p></div>';
	}
	
	//exibe o video
	echo'<div class="video">
			<iframe width="480" height="300" src="http://www.youtube.com/embed/'.$resultado['video'].'/?autoplay=0">
			</iframe>
		</div>
		<div class="info">'.
			$resultado['info']['sumario'].'
			<div id="mais_informacao">Mais &gt;&gt;</div>
		</div>
	</div>';
	
	
	
	
	/*
	//tela com traducao
	if(isset($_GET['traducao']) && $_GET['traducao'] && isset($resultado['letra']['traducao'])){
		echo '<div class="letra_r"><p>['.$resultado['letra']['musica'].']</p><p>&nbsp;</p>';
		
		$i = 1;
		//mostra a letra original
		foreach($resultado['letra']['letra'] as $value){
			if($value) echo '<p>'.$value.'</p>';
			else echo '<p>&nbsp;</p>';
			$i++;
		}
		
		echo'</div><div class="traducao">';
		
		//mostra a traducao da letra
		foreach($resultado['letra']['traducao'] as $key=>$value){
			if($key == 1 && $value){
				echo '<p>&nbsp;</p>';
				$i--;
			}
			if($value) echo '<p>'.$value.'</p>';
			else echo '<p>&nbsp;</p>';
			if(!$i) break;
			$i--;
		}
		
		echo '</div>';
	}
	else{ //tela sem traducao
		echo '<div class="letra_l"><p>['.$resultado['letra']['musica'].']</p><p>&nbsp;</p>';
		
		//mostra a letra
		if(isset($resultado['letra']['letra'])){
			foreach($resultado['letra']['letra'] as $value){
				if($value) echo '<p>'.$value.'</p>';
				else echo '<p>&nbsp;</p>';
			}
		}
		
		//exibe o video
		echo'</div>
			<div class="video">
				<iframe width="480" height="300" src="http://www.youtube.com/embed/'.$resultado['video'].'/?autoplay=0&enablejsapi=1&playerapiid=video"">
				</iframe>
			</div>
			<div class="info">'.
				$resultado['info']['sumario'].'
				<div>Mais >></div>
			</div>';
	}	
	*/
}
else{ //primeira tela de pesquisa
?>

	<p>Music Video Search</p>
	<form method="get" action="inicio.php">
	<div class="pesquisa">
	<input type="text" name="pesquisa" placeholder="Digite o nome da musica e banda, separados por ', by'. EX: One, by Metallica">
	<input class="pesquisa_button" type="submit" value="Pesquisar">
	</div>
	</form>
<?php } ?>

</body>
</html>