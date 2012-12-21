$(document).ready(function(){
	
	//anima descida das opcoes
	$('.exibe').mouseover(function(){
		$(this).css({
			'height': '87px',
			'-webkit-transition':'0.2s',
			'-moz-transition': '0.2s',
			'-o-transition': '0.2s'
		});
	});
	
	//anima subida das opcoes
	$('.exibe').mouseleave(function(){
		$(this).css({
			'height': '30px',
			'-webkit-transition':'0.2s',
			'-moz-transition': '0.2s',
			'-o-transition': '0.2s'
		});
	});
	
	//mostra e tira a traducao
	$('.traducao_botao').click(function(){
		if($(this).html() == 'Desativar Tradução'){
			$(this).html('Tradução');
			//mostra as div que tem o video, letra e info
			$('.video').css({'display': 'block'});
			$('.info').css({'display': 'block'});
			$('.download').css({'display': 'block'});
			//esconde as div que tem a traducao e letra
			$('.traducao').css({'display': 'none'});
			$('.letra').css({
				'text-align': 'center',
				'width': '478px'
			});
		}
		else{
			$(this).html('Desativar Tradução');
			//mostra as div que tem o video, letra e info
			$('.video').css({'display': 'none'});
			$('.info').css({'display': 'none'});
			$('.download').css({'display': 'none'});
			//esconde as div que tem a traducao e letra
			$('.traducao').css({'display': 'block'});
			$('.letra').css({
				'text-align': 'right',
				'width': '430px'
			});
		}
	});
	
	//exibe mais informacoes
	$('#mais_informacao').click(function(){
		$('.traducao_botao').css({'display': 'none'});
		$('.video').css({'display': 'none'});
		$('.info').css({'display': 'none'});
		$('.letra').css({'display': 'none'});
		$('.download').css({'display': 'none'});
		$('.informacoes').css({'display': 'block'});
		$('.botao_menos_info').css({'display': 'block'});
	});
	
	//exibe a tela inicial
	$('.botao_menos_info').click(function(){
		$('.traducao_botao').css({'display': 'block'});
		$('.video').css({'display': 'block'});
		$('.info').css({'display': 'block'});
		$('.letra').css({'display': 'block'});
		$('.download').css({'display': 'block'});
		$('.informacoes').css({'display': 'none'});
		$('.botao_menos_info').css({'display': 'none'});
	});
	
});

