<html>
<head>
    <title>Gerador de Voucher</title>
    <meta charset="UTF-8">
	<meta name="description" content="PFSense voucher generator">
	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
	<meta name="author" content="Tácio Andrade <tacio@multiti.com.br>">
	<meta name="author" content="Lucas Rocha <www.lucascudo.com.br>">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <!-- /Bootstrap -->
</head>
<body>
<?php

	function handleCSV($messages) {
		$vouchers = [];
		// Pasta onde o arquivo vai ser salvo
		$_UP['pasta'] = '/tmp/'; 
		// Tamanho máximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
		// Array com as extensões permitidas
		$_UP['extensoes'] = array('csv', 'txt');
		// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
		$_UP['renomeia'] = true;
		// Array com os tipos de erros de upload do PHP
		$_UP['erros'] = [
			'Não houve erro',
			'O arquivo no upload é maior do que o limite do PHP',
			'O arquivo ultrapassa o limite de tamanho especifiado no HTML',
			'O upload do arquivo foi feito parcialmente',
			'Não foi feito o upload do arquivo',
	 	];
		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro e para o processo
		if ($_FILES['arquivo']['error'] != 0) {
			$messages['error'] = "Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']];
			return [ 'vouchers' => $vouchers, 'messages' => $messages ];
		}
		// Faz a verificação da extensão do arquivo
		$explodedFileName = explode('.', $_FILES['arquivo']['name']);
		$extensao = strtolower(end($explodedFileName));
		if (array_search($extensao, $_UP['extensoes']) === false)
			$messages['warnings'][] = "Por favor, envie arquivos com as seguintes extensões: csv ou txt";
		// Faz a verificação do tamanho do arquivo
		if ($_UP['tamanho'] < $_FILES['arquivo']['size'])
			$messages['warnings'][] = "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
		if (!empty($messages['warnings']))
			return [ 'vouchers' => $vouchers, 'messages' => $messages ];
		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
		// Primeiro verifica se deve trocar o nome do arquivo
		$nome_final = ($_UP['renomeia']) ? 'voucher.csv' : $_FILES['arquivo']['name'];
		// Depois verifica se é possível mover o arquivo para a pasta escolhida
		if (!move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
			// Não foi possível fazer o upload, provavelmente a pasta está incorreta
			$messages['error'] = "Não foi possível enviar o arquivo, tente novamente";
			return [ 'vouchers' => $vouchers, 'messages' => $messages ];
		}
		$arquivo = fopen ('/tmp/voucher.csv', 'r');
		while (!feof($arquivo)) {
			$linha = fgets($arquivo, 1024);
			$vouchers[] = $linha;
		}
		fclose($arquivo);
		@unlink($arquivo);
		return [ 'vouchers' => $vouchers, 'messages' => $messages ];
	}

	$messages = [
		'error' => "",
		'success' => "",
		'warnings' => [],
	];
	$includes = [
		"guiconfig.inc",
		"functions.inc",
		"filter.inc",
		"shaper.inc",
		"head.inc",
	];
	foreach ($includes as $include)
		include_once($include);

	if (!empty($_FILES['arquivo'])) {
		$resultado = handleCSV($messages);
		$messages = $resultado['messages'];
		$vouchers = $resultado['vouchers'];
	}
?>

<?php if (!empty($messages['success'])): ?>
	<div class="alert alert-success">
		<strong>Sucesso!</strong> <?= $messages['success']; ?>
	</div>
<?php endif; ?>
<?php if (!empty($messages['error'])): ?>
	<div class="alert alert-danger">
		<strong>Erro!</strong> <?= $messages['error']; ?>
	</div>
<?php endif; ?>
<?php if (!empty($messages['warnings'])): ?>
	<div class="alert alert-warning">
		<strong>Atenção!</strong>
		<ul>
			<?php foreach($messages['warnings'] as $warning)
				echo '<li>'. $warning . '</li>'; ?>
		</ul>
	</div>
<?php endif; ?>

<?php if (empty($vouchers)): ?>
	Faça o upload do arquivo CSV do qual deseja gerar os vouchers. Esse arquivo se encontra em: https://pfsense.local/services_captiveportal_vouchers.php?zone={zona}</br></br>
	<form method="post" action="#" enctype="multipart/form-data">
		<label>Arquivo:</label>
		<input type="file" name="arquivo" />
		<input type="submit" value="Enviar" />
	</form>
<?php else: foreach ($vouchers as $voucher): ?>
	<table style="display: inline-block; width: 250px; border: 1px solid #ccc; line-height: 110%; font-family: arial; font-size: 12px; margin: 1px;">
			<tbody>
				<tr>
					<td style="text-align: center; color: green; font-size: 13px; border-bottom: 1px #ccc solid;"><b>Rede Wifi<br> MultiTI Consultoria e Serviços em Tecnologia</b></td>
				</tr>
				<tr>
				<td>
				<table style=" text-align: center; width: 240px; background-color: #fff; line-height: 110%; font-size: 12px; border-top: 1px solid #ccc;">
					<tbody>
						<tr style="color: green; font-size: 11px;">
							<td style="width: 100%">Voucher</td>
						</tr>
							<tr style="background-color: #fff;">
							<td style="color: #000; border: 1px #ccc solid;">
							<?php echo str_replace(["\""," "], "", $voucher; ?> 
							</td>
						</tr>
					</tbody>
				</table>
				</td>
				</tr>
				<tr>
			</tbody>
		</table>
<?php endforeach; endif; ?>

	<footer class="footer">
		<div class="container">
			<p class="text-muted">
				<a id="tpl" style="display: none;" href="#" title="Top of page"><i class="fa fa-caret-square-o-up pull-left"></i></a>
				Sistema de Voucher desenvolvido pela <a target="_blank" href="https://www.multiti.com.br">MultiTI</a> e liberado pela licença MIT e baixado no <a target="_blank" href="https://github.com/Tacioandrade/pfsense-voucher-generator">GitHub</a>
				<a id="tpr" style="display: none;" href="#" title="Top of page"><i class="fa fa-caret-square-o-up pull-right"></i></a>
			</p>
		</div>
	</footer>
</body>
</html>
