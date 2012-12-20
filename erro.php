<?php
	function status($value){
		if($value == 200) return '<div class="sucesso">Cadastro realizado com sucesso.</div>';
		else if($value == 201) return '<div class="sucesso">Atualização realizada com sucesso.</div>';
		else if($value == 400) return '<div class="erro">Senha não está correta.</div>';
		else if($value == 401) return '<div class="erro">Ocorreu um erro na inserção do cadastro.</div>';
		else if($value == 402) return '<div class="erro">Ocorreu um erro na conecção com o Banco de Dados.</div>';
		else if($value == 403) return '<div class="erro">Ocorreu um erro na conecção com a tabela do Banco de Dados.</div>';
		else if($value == 404) return '<div class="erro">Login e/ou senha incorretos.</div>';
		else if($value == 405) return '<div class="erro">Valores Captcha não conferem.</div>';
		else if($value == 406) return '<div class="erro">Cadastro de novos usuário não desponível.</div>';
	}
?>