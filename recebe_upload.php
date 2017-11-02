<?php

/*
Sistema desenvolvido por Tácio Andrade (tacio@multiti.com.br) e liberado sobre licença MIT.
Para mais informações visite meu site www.multiti.com.br ou meu GitHub https://github.com/Tacioandrade/
*/

require_once("guiconfig.inc");
require_once("functions.inc");
require_once("filter.inc");
require_once("shaper.inc");

include("head.inc");

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '/tmp/';
 
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
 
// Array com as extensões permitidas
$_UP['extensoes'] = array('csv', 'txt');
 
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;
 
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
 
// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
exit; // Para a execução do script
}
 
// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
 
// Faz a verificação da extensão do arquivo
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Por favor, envie arquivos com as seguintes extensões: csv ou txt";
}
 
// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}
 
// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
// Primeiro verifica se deve trocar o nome do arquivo
if ($_UP['renomeia'] == true) {
// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
$nome_final = 'voucher.csv';
} else {
// Mantém o nome original do arquivo
$nome_final = $_FILES['arquivo']['name'];
}
 
// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
echo "Upload efetuado com sucesso! <a href='/geravoucher.php'>Clique aqui para gerar o PDF!</a>";
} else {
// Não foi possível fazer o upload, provavelmente a pasta está incorreta
echo "Não foi possível enviar o arquivo, tente novamente";
}
 
}
print '<footer class="footer">
	<div class="container">
		<p class="text-muted">
			<a id="tpl" style="display: none;" href="#" title="Top of page"><i class="fa fa-caret-square-o-up pull-left"></i></a>
			Sistema de Voucher desenvolvido pela <a target="_blank" href="https://www.multiti.com.br">MultiTI</a> e liberado pela licença MIT e baixado no <a target="_blank" href="https://github.com/Tacioandrade/pfsense-voucher-generator">GitHub</a> 
			<a id="tpr" style="display: none;" href="#" title="Top of page"><i class="fa fa-caret-square-o-up pull-right"></i></a>
		</p>
	</div>
</footer>
</body>
</html>';
?>