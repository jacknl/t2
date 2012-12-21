<?php 
require_once 'youtube.php';

function pesquisa($pesquisa){
	$conteudo = array();
	$nome_video = '';
	$_SESSION['link'] = $_SERVER["REQUEST_URI"];
	
	//caso essa pesquisa ja foi feita, retorna os dados guardados no session
	if(isset($_SESSION['pesquisa']) && $_SESSION['pesquisa'] == $pesquisa) return $_SESSION['conteudo'];
	
	//guarda o nome da pesquisa
	$_SESSION['pesquisa'] = $pesquisa;
	
	$pesquisa = explode(', by', $pesquisa);
	//troca os espaços da pesquisa por +
	$pesquisa = str_replace(' ', '+', $pesquisa);
	
	$musica = $pesquisa[0];
	if(isset($pesquisa[1])) $banda = $pesquisa[1];
	else $banda = '';

	//########### VIDEO ############
	//pesquisa video
	$youtube = new youtube();
	$dados = $youtube->get('http://gdata.youtube.com/feeds/api/videos?q='.$banda.'+'.$musica.'+official+music+video&max-results=1&orderBy=viewCount\\');
	
	//retorna o video do youtube
	if($dados == null || !isset($dados->entry)){
		$dados = $youtube->get('http://gdata.youtube.com/feeds/api/videos?q='.$banda.'+'.$musica.'&max-results=1&orderBy=viewCount\\');
	}
	
	if($dados == null || !isset($dados->entry)) $conteudo['video'] = false;
	else{
		//nome do video
		$nome_video = $dados->entry[0]->title;
		$nome_video = str_replace('(Official Music Video)', '', $nome_video);
		$nome_video = str_replace('[Official Music Video]', '', $nome_video);
		$nome_video = explode('-', $nome_video);
		$nome_video = str_replace(' ', '+', $nome_video);
		
		//pega id do video
		$resultado = explode('/', $dados->entry[0]->id);
		$conteudo['video'] = $resultado[count($resultado) - 1];
	}
	
	//########### LETRA E TRADUCAO ############
	//pega a letra da musica e traducao(caso tiver)
	$conteudo['letra'] = getletra($banda, $musica);
	//caso nao tenha achado nenhuma letra, pesquisa pelo nome do video
	if(!$conteudo['letra'] && isset($nome_video[0]) && isset($nome_video[1])) $conteudo['letra'] = getletra($nome_video[0], $nome_video[1]);
	
	//########### INFORMACOES BANDA ############
	//pega informacoes do autor/banda
	$conteudo['info'] = getInfoBanda($banda);
	//caso nao tenha achado nenhuma informacao do autor/banda, pesquisa pelo nome do autor/banda do video
	if(!$conteudo['info']['sumario'] && !$conteudo['info']['biografia'] && isset($nome_video[0])) $conteudo['info'] = getInfoBanda($nome_video[0]);
	
	//guarda os dados da pesquisa
	$_SESSION['conteudo'] = $conteudo;
	return $conteudo;
}

function getInfoBanda($banda){
	//pega letra do site http://www.vagalume.com.br
	$curl = curl_init();
	
	//banda info
	curl_setopt($curl, CURLOPT_URL, 'http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist='.$banda.'&lang=pt&api_key=6707b9315037c559c639cbbf6fc83a82&format=json');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$dados = json_decode(curl_exec($curl));
	$Headers = curl_getinfo($curl);
	curl_close($curl);
	
	//erro na requisicao
	if($Headers['http_code'] != 200){
		$tmp['sumario'] = '';
		$tmp['biografia'] = '';
		$tmp['imagem'] = '';
	}
	else{
		if(!isset($dados->artist->bio->summary)) return null;
		//pega informacoes da banda
		$tmp['sumario'] = utf8_decode($dados->artist->bio->summary);
		//remove todas as tag da string, so deixa o strong
		$tmp['sumario'] = strip_tags($tmp['sumario'], '<strong>');
		
		$tmp['biografia'] = json_encode($dados->artist->bio->content);
		//remove aspas duplas do inicio e fim
		$tmp['biografia'] = substr($tmp['biografia'], 1, strlen($tmp['biografia']) - 2);
		//quebra por linha
		$tmp['biografia'] = explode('\n', $tmp['biografia']);
		//converte para ISO-8859-1
		foreach($tmp['biografia'] as $key=>$value){
			if($value){
				$tmp['biografia'][$key] = utf8_decode(json_decode('"'.$value.'"'));
				//remove todas as tag da string, so deixa o strong
				$tmp['biografia'][$key] = strip_tags($tmp['biografia'][$key], '<strong>');
			}
		}
		//retira a ultima posicao da array, que contem a seguinte informacao
		//'User-contributed text is available under the Creative Commons By-SA License and may also be available under the GNU FDL.'
		unset($tmp['biografia'][count($tmp['biografia']) - 1]);
		//pega a imagem
		foreach($dados->artist->image[3] as $value){
			$tmp['imagem'] = $value;
			break;
		}
		
		$tmp['nome'] = strtoupper(str_replace('+', ' ', $banda));
	}
	
	return $tmp;
}

function getletra($banda, $musica){
	//pega letra do site http://www.vagalume.com.br
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'http://www.vagalume.com.br/api/search.php?art='.$banda.'&mus='.$musica);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$dados = json_decode(curl_exec($curl));
	
	$Headers = curl_getinfo($curl);
	curl_close($curl);
	
	//erro na requisicao
	if ($Headers['http_code'] != 200){
		$retorno['letra'] = false;
	}
	else{
		//nao achou a letra da musica
		if($dados->type == 'notfound' || $dados->type == 'song_notfound'){
			$tmp = false;
		}
		else{
			//pega letra a musica
			$tmp['nome'] = $dados->art->name;
			$tmp['musica'] = $dados->mus[0]->name;
			$tmp['letra'] = json_encode($dados->mus[0]->text);
			//remove aspas duplas do inicio e fim
			$tmp['letra'] = substr($tmp['letra'], 1, strlen($tmp['letra']) - 2);
			//quebra por linha
			$tmp['letra'] = explode('\n', $tmp['letra']);
			//converte para ISO-8859-1
			foreach($tmp['letra'] as $key=>$value) if($value) $tmp['letra'][$key] = utf8_decode(json_decode('"'.$value.'"'));
			
			//pega traducao da musica, caso tiver
			if(isset($dados->mus[0]->translate[0]->text)){
				
				/* Objetivo: pegar cada linha da letra e gravar em uma pposicao da array
				 * 
				 * Problema com a acentuacao
				 * o caracter com acento vem do json em unicode
				 * e converte normalmente para UTF-8
				 * so que quando vou quebrar a string para separar cada linha, pelo entre(\n)
				 * ele nao reconhece nenhum enter na string, provavelmente converteu o \n para algum 
				 * caracter que nao conheco
				 * 
				 * Solucao: deixei a traducao em json
				 * quebrei pelo \n, converti de json para UTF-8
				 * e de UTF-8 para ISO-8859-1
				 */
				
				$tmp['traducao'] = json_encode($dados->mus[0]->translate[0]->text);
				//remove aspas duplas do inicio e fim
				$tmp['traducao'] = substr($tmp['traducao'], 1, strlen($tmp['traducao']) - 2);
				//quebra por linha
				$tmp['traducao'] = explode('\n', $tmp['traducao']);
				//converte para ISO-8859-1
				foreach($tmp['traducao'] as $key=>$value) if($value) $tmp['traducao'][$key] = utf8_decode(json_decode('"'.$value.'"'));
			}
		}
	}
	
	return $tmp;
}
?>