<?php
	error_reporting(1);
	if(!empty($_GET['codigo'])) {
		$codigo = (int) $_GET['codigo'];
		
		$arq = fopen("usuarios.txt", "r");
		$achou = false;
		//continuar
		while(!feof($arq)) {
			$linha = fgets($arq);
			$arr_linha = explode("#", $linha);
						
			if($codigo==$arr_linha[0]) {
				$achou = 1;
				
				$nome = $arr_linha[1];
				$senha = $arr_linha[2];
				$dt_nasc = $arr_linha[3];
				$cidade = $arr_linha[4];
				$cpf = $arr_linha[5];
				$nome_pai = $arr_linha[6];
				$nome_mae = $arr_linha[7];
				$observacoes = $arr_linha[8];
				
				break;
			}
		}
		//Se não achou mostra aviso
		if(!$achou) {
			alert("Código não encontrado!");
		}
	}

?>
<!doctype html>
<html>
    <head>
        <title>Cadastro usu&aacute;rio</title>
    	<script src="js/jquery-3.1.1.js"></script>
    	<script src="js/jquery.mask.js"></script>
        <link rel="stylesheet" type="text/css" href="css/css.css">
        <script>
			function testaCPF(strCPF) {
				var soma;
				var resto;
				soma = 0;
				
				strCPF = strCPF.replace("-", "");
				strCPF = strCPF.replace(".", "");
				strCPF = strCPF.replace(".", "");
				
				if(strCPF == "00000000000") return false;

				for(i=1; i<=9; i++) {
					soma = soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
				}
				resto = (soma * 10) % 11;

				if((resto == 10) || (resto == 11))  resto = 0;
				if(resto != parseInt(strCPF.substring(9, 10))) return false;

				soma = 0;
				for(i = 1; i <= 10; i++) {
					soma = soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
				}
				resto = (soma * 10) % 11;

				if((resto == 10) || (resto == 11))  resto = 0;
				if(resto != parseInt(strCPF.substring(10, 11))) return false;
				return true;
			}
			
			function validarCadastro() {
				if($('#nome').val()=='') {
					alert('Campo nome obrigatório!');
					return false;
				} else if($('#cpf').val()=='') {
					alert('Campo cpf obrigatório!');
					return false;
				} else if(!testaCPF($('#cpf').val())) {
					alert('a '+$('#cpf').val());
					alert('Informe um cpf válido!');
					return false;
				} else {
					return true;
				}
			}
		</script>
    </head>
    <body>
		<section>
			<fieldset>
				<legend>
					Cadastro
				</legend>
				<form action="cadastrar_pessoa.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" id="codigo_cadastro" name="codigo" value="<?php echo $codigo?>">
					<table width="80%" class="cadastro" cellspacing="4" cellspadding="0" align="center">
						<tr>
							<td width="130px">
								Nome*:
							</td>
							<td>
								<input type="text" id="nome" name="nome" value="<?php echo $nome?>">
							</td>
						</tr>
						<tr>
							<td>
								Senha:
							</td>
							<td>
								<input type="password" id="senha" name="senha" value="<?php echo $senha?>">
							</td>
						</tr>
						<tr>
							<td width="130px">
								Data nascimento:
							</td>
							<td>
								<input type="text" id="dt_nasc" name="dt_nasc" class="data" value="<?php echo $dt_nasc?>">
							</td>
						</tr>
						<tr>
							<td>
								CPF*:
							</td>
							<td>
								<input type="text" id="cpf" name="cpf" class="cpf" value="<?php echo $cpf?>">
							</td>
						</tr>
						<tr>
							<td>
								Cidade:
							</td>
							<td>
								<input type="text" id="cidade" name="cidade" value="<?php echo $cidade?>">
							</td>
						</tr>
						<tr>
							<td width="130px">
								Nome pai:
							</td>
							<td>
								<input type="text" id="nome_pai" name="nome_pai" value="<?php echo $nome_pai?>">
							</td>
						</tr>
						<tr>
							<td width="130px">
								Nome mãe:
							</td>
							<td>
								<input type="text" id="nome_mae" name="nome_mae" value="<?php echo $nome_mae?>">
							</td>
						</tr>
						<tr>
							<td width="130px" style="padding-top: 10px;" valign="top">
								Observações:
							</td>
							<td>
								<input type="text" id="observacoes" name="observacoes" value="<?php echo $observacoes?>">
							</td>
						</tr>
						<tr>
							<td valign="top">
								<input type="button" value="Cancelar" onClick="document.location.href='index.php'">
							</td>
							<td>
								<input type="submit" onClick="return validarCadastro()" value="Salvar">
							</td>
						</tr>
					</table>
				</form>
			</fildset>
		</section>
		<script>
			$(document).ready(function() {
				$('.data').mask('00/00/0000');
				$('.cpf').mask('000.000.000-00', {reverse: true, clearIfNotMatch: true});
			});
		</script>
	</body>
</html>