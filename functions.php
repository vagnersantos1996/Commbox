<?php
	function anti_injection($string) {
		//remove palavras que contenham sintaxe sql
		$string = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/","",$string);
		$string = trim($string);//limpa espaços vazio
		$string = strip_tags($string);//tira tags html e php
		$string = addslashes($string);//Adiciona barras invertidas a uma string
		return $string;
	}

	function validaData($data) {
		if(!empty($data)) {
			$data = explode("/", $data);
			//verifica se a data é válida: mes dia ano
			return checkdate($data[1], $data[0], $data[2]);
		} else {
			return false;
		}
	}

	function limparTexto($string) {
		$string = str_replace(array("<", ">", "\\", "/", "=", "'", "\"", "?"), "", $string);
		return $string;
	}
	
	function alert($string) {
		?>
			<script>
				alert('<?php echo $string?>');
			</script>
		<?php
	}

	function validaCPF($cpf) {

		// Verifica se um número foi informado
		if(empty($cpf)) {
			return false;
		}

		// Elimina possivel mascara
		$cpf = preg_replace("/[^0-9]/", "", $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

		// Verifica se o numero de digitos informados é igual a 11 
		if(strlen($cpf) != 11) {
			return false;
		} else if($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   

			for($t = 9; $t < 11; $t++) {

				for($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if($cpf{$c} != $d) {
					return false;
				}
			}

			return true;
		}
	}

	function validar_input_email($email, $strict = true) {
		$dot_string = $strict ?
			'(?:[A-Za-z0-9!#$%&*+=?^_`{|}~\'\\/-]|(?<!\\.|\\A)\\.(?!\\.|@))' :
			'(?:[A-Za-z0-9!#$%&*+=?^_`{|}~\'\\/.-])'
		;
		$quoted_string = '(?:\\\\\\\\|\\\\"|\\\\?[A-Za-z0-9!#$%&*+=?^_`{|}~()<>[\\]:;@,. \'\\/-])';
		$ipv4_part = '(?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])';
		$ipv6_part = '(?:[A-fa-f0-9]{1,4})';
		$fqdn_part = '(?:[A-Za-z](?:[A-Za-z0-9-]{0,61}?[A-Za-z0-9])?)';
		$ipv4 = "(?:(?:{$ipv4_part}\\.){3}{$ipv4_part})";
		$ipv6 = '(?:' .
			"(?:(?:{$ipv6_part}:){7}(?:{$ipv6_part}|:))" . '|' .
			"(?:(?:{$ipv6_part}:){6}(?::{$ipv6_part}|:{$ipv4}|:))" . '|' .
			"(?:(?:{$ipv6_part}:){5}(?:(?::{$ipv6_part}){1,2}|:{$ipv4}|:))" . '|' .
			"(?:(?:{$ipv6_part}:){4}(?:(?::{$ipv6_part}){1,3}|(?::{$ipv6_part})?:{$ipv4}|:))" . '|' .
			"(?:(?:{$ipv6_part}:){3}(?:(?::{$ipv6_part}){1,4}|(?::{$ipv6_part}){0,2}:{$ipv4}|:))" . '|' .
			"(?:(?:{$ipv6_part}:){2}(?:(?::{$ipv6_part}){1,5}|(?::{$ipv6_part}){0,3}:{$ipv4}|:))" . '|' .
			"(?:(?:{$ipv6_part}:){1}(?:(?::{$ipv6_part}){1,6}|(?::{$ipv6_part}){0,4}:{$ipv4}|:))" . '|' .
			"(?::(?:(?::{$ipv6_part}){1,7}|(?::{$ipv6_part}){0,5}:{$ipv4}|:))" .
		')';
		$fqdn = "(?:(?:{$fqdn_part}\\.)+?{$fqdn_part})";
		$local = "({$dot_string}++|(\"){$quoted_string}++\")";
		$domain = "({$fqdn}|\\[{$ipv4}]|\\[{$ipv6}]|\\[{$fqdn}])";
		$pattern = "/\\A{$local}@{$domain}\\z/";
		return preg_match($pattern, $email, $matches) &&
			(
				!empty($matches[2]) && !isset($matches[1][66]) && !isset($matches[0][256]) ||
				!isset($matches[1][64]) && !isset($matches[0][254])
			);
	}
	
	function replace($page) {
		?>
			<script>
				document.location.replace('<?php echo $page?>');
			</script>
		<?php
	}
	
	function href($page) {
		?>
			<script>
				document.location.href='<?php echo $page?>';
			</script>
		<?php
	}
	
	function erro($string, $page = NULL) {
		alert($string);
		if($page) {
			replace($page);
		} else {
			voltar();
		}
		exit();
	}
	
	function voltar() {
		?>
			<script>
				history.go(-1);
			</script>
		<?php
	}
?>