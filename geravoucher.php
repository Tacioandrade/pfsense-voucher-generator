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
	<body>
	<?php 
		$array = array();
		$i = 0;
		$arquivo = fopen ('/tmp/voucher.csv', 'r');
		while(!feof($arquivo)){
			$linha = fgets($arquivo, 1024);
			$array[$i] = $linha;
			$i++;
		}
		fclose($arquivo);
		@unlink($arquivo);
		for ($i = 0; $i <= count($array)-10; $i++) {
		echo '<table style="display: inline-block; width: 250px; border: 1px solid #ccc; line-height: 110%; font-family: arial; font-size: 12px; margin: 1px;">
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
							<td style="color: #000; border: 1px #ccc solid;">'.str_replace(["\""," "], "", $array[$i+7]).'</td>
						</tr>
					</tbody>
				</table>
				</td>
				</tr>
				<tr>
			</tbody>
		</table>';
	}?>
	</body>
</html>