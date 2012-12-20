$(document).ready(function(){
	nome = login = senha = email = false;
	
	//faz primeiramente uma checagem nos campos do cadastro
	$('input').each(function(){
		if($(this).val()){
			verificaCampos($(this).attr('name'), $(this).val(), $(this).parent().parent());
		}
	});
	
	if($('.login input').val()) verificaLogin($('.login input'));
	
	$("table input").keyup(function(){
		//verifica os campos, menos o login
		if($(this).attr('name') != 'login') verificaCampos($(this).attr('name'), $(this).val(), $(this).parent().parent());
		//quando todos os campos estiverem corretamente preenchidos, abilita o bot„o para cadastro
		isInput(nome, login, senha, email);
	});
	
	$('.disponibilidade div').click(function(){
		verificaLogin($('.login input'));
	});
	
});

function verificaLogin(ver_login){
	var val = ver_login.val();
	//verifica o tamanho do login e se ele È valido
	if(val.length <= 32 && val.length >= 4 && isLogin(val)){
		//consulta se o login ja esta em uso
		$.get('disponibilidade.php?login=' + val, function(data){
			if(data == 1){ //login esta disponivel
				login = true;
				ver_login.parent().parent().append('<div class="statusOK"></div>');
			}
			else{ //login esta em uso
				login = false;
				ver_login.parent().parent().append('<div class="statusERRO"></div>');
			}
			//quando todos os campos estiverem corretamente preenchidos, abilita o bot„o para cadastro
			isInput(nome, login, senha, email);
		});	
	}
	else{
		login = false;
		ver_login.parent().parent().append('<div class="statusERRO"></div>');
	}
	//quando todos os campos estiverem corretamente preenchidos, abilita o bot„o para cadastro
	isInput(nome, login, senha, email);
}

function verificaCampos(name, valor, campo){
	if(name == 'nome'){
		if(valor.length <= 64 && valor.length >= 6 && isName(valor)){
			nome = true;
			campo.append('<div class="statusOK"></div>');
		}
		else{
			nome = false;
			campo.append('<div class="statusERRO"></div>');
		}
	}
	else if(name == 'senha1'){
		if($('.senha2 input').val() == valor && valor.length >= 6 && valor.length <= 32){
			senha = true;
			$('.senha2 input').parent().parent().append('<div class="statusOK"></div>');
		}
		else{
			senha = false
			$('.senha2 input').parent().parent().append('<div class="statusERRO"></div>');
		}
	}
	else if(name == 'senha2'){
		if($('.senha1 input').val() == valor && valor.length >= 6 && valor.length <= 32){
			senha = true;
			campo.append('<div class="statusOK"></div>');
		}
		else{
			senha = false;
			campo.append('<div class="statusERRO"></div>');
		}
	}
	else if(name == 'email'){
		if(isEmail(valor) && valor.length >= 10 && valor.length <= 64){
			email = true;
			campo.append('<div class="statusOK"></div>');
		}
		else{
			email = false;
			campo.append('<div class="statusERRO"></div>');
		}
	}
}

function isInput(nome, login, senha, email){
	if(nome && login && senha && email){
		$('.ok_off').css({'display': 'none'});
		$('.ok').css({'display': 'block'});
	}
	else{
		$('.ok_off').css({'display': 'block'});
		$('.ok').css({'display': 'none'});
	}

}

function isName(nome){
	var pattern = /^[ a-zA-Z·ÈÌÛ˙¡…Õ”⁄]+$/;
	if(pattern.test(nome)) {
		return true;
	}else{
		return false;
	}
}

function isLogin(login){
	var pattern = /^[_a-zA-Z-0-9]+$/;
	if(pattern.test(login)) {
		return true;
	}else{
		return false;
	}
}

function isEmail(email){
   	var pattern = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/; 
   	if(pattern.test(email)) {
    	return true;
   	}else{
      	return false;
   	}
}
