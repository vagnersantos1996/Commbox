<?php
	error_reporting(1);
	include('functions.php');
	define("ARQUIVO", "usuarios.txt");

	if($_POST) {
		$arq = fopen(ARQUIVO, "a");
		
		$linhas = 0;
		$arqL = fopen(ARQUIVO, 'r');
		while(!feof($arqL)) {
			fgets($arqL);
			$linhas++;
		}
		fclose($arqL);
		
		//echo $linhas;exit();
		
		$nome = $_POST['nome'];
		$senha = $_POST['senha'];
		$dt_nasc = $_POST['dt_nasc'];
		$cidade = $_POST['cidade'];
		$cpf = $_POST['cpf'];
		$nome_pai = $_POST['nome_pai'];
		$nome_mae = $_POST['nome_mae'];
		$observacoes = $_POST['observacoes'];
		
		$query_senha = NULL;
		
		$codigo = $_POST['codigo'];
		
		if(empty($nome)) {
			erro("Nome vazio!");
		} elseif(empty($cpf)) {
			erro("CPF vazio!");			
		} elseif(!validaCPF($cpf)) {
			erro("CPF inválido!");
		} elseif(!validaData($dt_nasc)) {
			erro("Data de nascimento inválida!");
		} else {
			if(empty($codigo)) {
				//novo
				$codigo = $linhas+1;
				
				fwrite($arq, (filesize(ARQUIVO) == 0 ? "1" : "\r\n".$codigo)."#".$nome."#".$senha."#".$dt_nasc."#".$cidade."#".$cpf."#".$nome_pai."#".$nome_mae."#".$observacoes."#");
				alert("Inserido com sucesso!");
				fclose($arq);
				replace('index.php');
			} else {
				//alteracao
				$abre = fopen(ARQUIVO,"r");
				$dados = fread($abre, filesize(ARQUIVO));
				
				fclose($abre);
				$linhas = explode("\r\n", $dados);
				
				unset($linhas[$codigo-1]);
				
				$linhas[$codigo-1] = $codigo."#".$nome."#".$senha."#".$dt_nasc."#".$cidade."#".$cpf."#".$nome_pai."#".$nome_mae."#".$observacoes."#";
				//print_r($linhas);exit();
				ksort($linhas);
				
				$linhas = implode("\r\n", $linhas);
				
				$arq = fopen(ARQUIVO, "w+");
				fwrite($arq, $linhas);
				fclose($arq);
				replace('index.php');
			}
			
		}
		
	} else {
		voltar();
	}
?>