<?php
	function status($value){
		if($value == 200) return '<div class="sucesso">Cadastro realizado com sucesso.</div>';
		else if($value == 201) return '<div class="sucesso">Atualiza��o realizada com sucesso.</div>';
		else if($value == 400) return '<div class="erro">Senha n�o est� correta.</div>';
		else if($value == 401) return '<div class="erro">Ocorreu um erro na inser��o do cadastro.</div>';
		else if($value == 402) return '<div class="erro">Ocorreu um erro na conec��o com o Banco de Dados.</div>';
		else if($value == 403) return '<div class="erro">Ocorreu um erro na conec��o com a tabela do Banco de Dados.</div>';
		else if($value == 404) return '<div class="erro">Login e/ou senha incorretos.</div>';
		else if($value == 405) return '<div class="erro">Valores Captcha n�o conferem.</div>';
		else if($value == 406) return '<div class="erro">Cadastro de novos usu�rio n�o despon�vel.</div>';
	}
?>