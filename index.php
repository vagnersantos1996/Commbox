<?php
	error_reporting(1);
	$arq = fopen("usuarios.txt", "r");
?>
<!doctype html>
<html>
    <head>
        <title>Cadastro usu&aacute;rio</title>
    	<script src="js/jquery-3.1.1.js"></script>
    	<script src="js/jquery.mask.js"></script>
        <link rel="stylesheet" type="text/css" href="css/css.css">
	</head>
	<body>
		<section>
			<!--div id="form_pesquisa">
				<h1>Pesquisar</h1>
				<div>
					<form action="admin.php?page=lista_produtos" method="POST" enctype="multipart/form-data">
						<table width="100%" class="cadastro" cellspacing="4" cellspadding="0" align="center">
							<tr>
								<td>
									Nome:
								</td>
								<td>
									<input type="text" name="nome" id="nome" value="<?php echo $_POST['nome']?>" required>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="submit" value="Pesquisar">
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div-->
			<table class="listagem" cellspacing="0" cellspadding="2" align="center" width="80%">
				<thead>
					<tr>
						<td>
							Nome
						</td>
						<td>
							CPF
						</td>
						<td align="center">
							A&ccedil;&otilde;es
						</td>
					</tr>
				</thead>
				<tbody>
					<?php
						if(filesize("usuarios.txt") > 0) {
							$x = 0;
							while(!feof($arq)) {
								$linha = fgets($arq);
								$linha = str_replace("\r\n", "", $linha);
								$arr_linha = explode("#", $linha);

								$codigo = $arr_linha[0];
								$nome = $arr_linha[1];
								$cpf = $arr_linha[5];
								?>
									<tr>
										<td>
											<?php echo $nome;?>
										</td>
										<td>
											<?php echo $cpf;?>
										</td>
										<td align="center">
											<a href="formulario_cadastro.php?codigo=<?php echo $codigo;?>">
												<img src="img/editar.png" title="Editar">
											</a>
											<a href="deletar.php?codigo=<?php echo $codigo;?>" onClick="if(!confirm('Deseja realmente excluir esta pessoa?')) { return false; }">
												<img src="img/deletar.png" title="Deletar">
											</a>
										</td>
									</tr>
								<?php
								$x++;
							}
							fclose($arq);
						} else {
							?>
								<tr>
									<td align="center" colspan="3">
										Nenhum registro encontrado!
									</td>
								</tr>
							<?php
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" align="center">
							<?php echo $x ? $x : "0"?> registro(s).
						</td>
					</tr>
				</tfoot>
			</table>
			<div class="botao_link">
				<input type="button" value="Cadastrar" onclick="document.location.href='formulario_cadastro.php'">
			</div>
		</section>
	</body>
</html>