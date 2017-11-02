# pfsense-voucher-generator
# tacio@multiti.com.br

Sistema de geração de Voucher para pfSense. Essse sistema é liberado sobre a licença MIT, e foi criado para simplificar a geração de vouchers para o pfSense sem a necessidade de outro software se não o próprio pfSense.

Para que esse script funcione você deverá copiar os 3 arquivos PHP para o servidor pfSense via SSH ou SFTP no diretório: /usr/local/www

Após isso, logue no seu pfSense com seu usuário, vá até o menu: Services => Captive Portal => Selecione opção "Edit zone" do Portal que deseja gerar o voucher. 

Navegue até a aba "Vouchers" e gere um voucher com o período de tempo desejado e por fim, baixe o arquivo CSV desse voucher.

Com o CSV gerado e baixado em seu computador, acesse a url: https://pfsense/voucher.php e faça o upload do CSV gerado anteriormente.

Ao enviar o CSV, será redirecionado para uma página onde mostrará que o upload foi executado com sucesso e pedindo para clicar no link para gerar o voucher.

Após clicar nesse link, você será redirecionado a página com os vouchers preenchidos, após isso é só imprimir ou gerar o PDF com alguma impressora PDF local.

Espero que façam um bom uso desse software.

Atenciosamente, Tácio Andrade. Consultor de TI na MultiTI.com.br.