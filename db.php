<?php
class db{
	
	public static function connect(){ //connecta com o bd
		$host = 'jacknl-db.my.phpcloud.com:3306';
		$usuario = ''; //seu usuario
		$senha = ''; //sua senha
		$banco_dados = 'jacknl';
		
		if(!($db = mysql_connect($host,$usuario,$senha))){ //erro na coneccao com o bd
			return 402;
		}
		
		if(!(mysql_select_db($banco_dados, $db))){ //erro na coneccao com a tabela do bd
			return 403;
			mysql_close($db);
		}
		
		return $db;
	}
	
}
?>