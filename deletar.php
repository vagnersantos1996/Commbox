<?php
	error_reporting(1);
	include('functions.php');
	define("ARQUIVO", "usuarios.txt");

	if(!empty($_GET['codigo'])) {
		$codigo = (int) $_GET['codigo'];
		
		$abre = fopen(ARQUIVO,"r");
		$dados = fread($abre, filesize(ARQUIVO));
		fclose($abre);
		
		$linhas = explode("\r\n", $dados);
		unset($linhas[$codigo-1]);
		
		$x=0;
		foreach($linhas as $chave=>$valor) {
			$valor = explode("#", $valor);
			$valor[0] = $x+1;
			$valor = implode("#", $valor);
			
			$linhas[$chave] = $valor;
			$x++;
		}
		
		$linhas = implode("\r\n", $linhas);
		
		$arq = fopen(ARQUIVO, "w+");
		fwrite($arq, $linhas);
		fclose($arq);
		replace('index.php');
	} else {
		voltar();
	}
?>