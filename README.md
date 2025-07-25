# CBC_API_REST

Aplicação de gerenciamento de recursos financeiros. Api Rest criada para envios de informações para recebimentos em Json.

## Como usar

* Instalar o docker no seu sistema.
* Abra o docker, pois sem ele funcionando, você não irá conseguir utilizar os comandos abaixo.
* Se estiver utilizando o VS Code, utilize o atalho padrão, ao menos que você tenha mexido nas configurações de atalhos, mas o atalho é CTRL + SHIFT + ', com isto você irá ativar o terminal.
* Neste próximo passo você deve utilizar o terminal, veja se no canto está marcando bash, se estiver faça o comando, docker-compose up -d --build.
* Para que o sistema faça todas as funções, você deve instalar o MySql Workbanch e configurar o banco nele para manipulação, a configuração no Workbanch é:  
* -> clique no simbolo +.
* -> Em Connection Name, você pode colocar um nome para a sua conexão para que fique mais fácil, caso tenha várias configurações.
* -> Em Hostname: 127.0.0.1 e em Port: 3306.
* -> Em Username: admin .
* -> Em Password: e clique em Store in Vault.
* -> Vai abrir uma tela com um campo, digite 123, depois pressione o botão ok.
* -> Para confirmar que tudo está funcionando, vá no botão Test Connection, aparecendo sucesso, é só abrir.
  
* Neste próximo passo, depois de estar com o Workbanch configurado, você irá abrir a pasta do projeto, procurar uma pasta chamada SQL, e copiar todo o conteúdo do arquivo banco.sql, ou executa-lo no Workbanch, assim serão criadas todas as tabelas, com algum conteúdo de demonstração.
* Para que o sistema funcione, abra o navegador e digite localhost:8080, assim abrirá a tela do arquivo index.php.

## Cadastro de novos clube e novos recursos

Na tela index:

* Um botão sendo 'Clubes', ao clicar abrirá uma lista com todos os clubes.
* No segundo botão 'Recursos', ao clicar abrirá uma lista com todos os recursos.
* O terceiro botão Resultados em GET, apresentando um resultado em json.
* O quarto botão Resultados em Post, apresenta o resultado através do envio para um outro arquivo que comanda os envios, o resultado apresentado é em Json.
* O quinto botão 'Consumir recursos'
* Se quiser utilizar os valores passados pela URL e pode ser ativado direto pela URL.

Em cada lista existem quatro botões, um Deletar, um Editar, um Novo e um Recuperar:

* Novo -> Cadastra um novo recurso ou clube, dependendo de aonde clicou antes.
* Editar -> Edita o recurso ou clube, dependendo da lista que está.
* Deletar -> Excluí um recurso ou clube, dependendo da lista que está.
* Recuperar -> Recupera um recurso ou clube que foi deletado errado ou que foi deletado a muito tempo.

## 