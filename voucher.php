<?php

/*
Sistema desenvolvido por Tácio Andrade (tacio@multiti.com.br) e liberado sobre licença MIT.
Para mais informações visite meu site www.multiti.com.br ou meu GitHub https://github.com/Tacioandrade/
*/

require_once("guiconfig.inc");
require_once("functions.inc");
require_once("filter.inc");
require_once("shaper.inc");

?>

<html>
<head>
    <title>Gerador de Voucher</title>
</head>
<body>
<?php include("head.inc"); ?>

Faça o upload do arquivo CSV do qual deseja gerar os vouchers. Esse arquivo se encontra em: https://pfsense.local/services_captiveportal_vouchers.php?zone={zona}</br></br>
<form method="post" action="recebe_upload.php" enctype="multipart/form-data">
<label>Arquivo:</label>
<input type="file" name="arquivo" />
<input type="submit" value="Enviar" />
</form>
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