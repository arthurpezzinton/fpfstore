# fpfstore
Modelo base de loja virtual em php, javascript, sql, html, css e bootstrap 5 que permita manipulação por um superadmin do sistema

O sistema foi desenvolvido usando php com auxílio de javascript para manipular os arquivos html e jquery para acessar as funções em php. Foi utilizado bootstrap 5 como framework, e também foram adicionaos alguns scripts externos somente para formatar a aparência da aplicação. Como se trata de um sistema para avaliação de conhecimento, foi evitada a inclusão de apis já prontas, priorizando a construção própria do código.

O arquivo de conexão com o banco de dados simulado é o chamado conexao.php e os códigos de criação do banco e das tabelas estão no arquivo phpMyAdmin.txt;

O arquivo das funções de manipulação da database e de funções bases do sistema é o chamado crud.php;

Todos os demais arquivos são páginas ou funções do sistema.

Inicialmente, a loja é iniciada sem produtos nem usuários cadastrados. O superadmin deve fazer login no sistema e será redirecionado para a página de gerenciamento dos produtos, categorias e compras da loja.
Nesta página, é possível adicionar novos produtos, excluir produtos, bloquear e desbloquear produtos, adicionar categorias, excluir categorias, alterar categorias e atualizar os códigos de rastreios das compras realizadas.

Para adicionar um novo produto, o suepradmin deve clicar em _Adicionar_ na aba _Produtos_, que irá redirecioná-lo para a página de edição de produtos. Nesta, devem ser preenchidos os campos das informações do produto e então deve-se clicar no botão _Salvar_. Quando um produto é criado, o sistema escreve os dados deste em uma tabela e cria uma pasta no servidor com o código deste produto para organizar as fotos do mesmo. O campo _Desconto_ na criação do produto é em porcentagem e é utilizado para reforçar a queda de preço nos cards da página principal. Todos os campos do produto são editáveis posteriormente.

Depois de salvo, o produto recebe a possibilidade de ter adicionadas fotos, clicando no botão _Editar_ e depois em _Galeria_. No botão _Escolher arquivos_ são escolhidas as imagens relativas a este produto (lembrando que a imagem principal do produto que aparece nos cards da loja é a primeira a ser enviada) e então deve-se clicar em _Enviar Foto(s)_. Depois do envio finalizado, na página de gerenciamento, o produto já aparecerá com a imagem principal escolhida. 

O ato de _Bloquear_ um produto apenas faz com que este não seja acessível aos clientes hipotéticos, não exclui o mesmo do sistema. _Desbloquear_ torna o produto acessível novamente.

Para excluir um produto, o superadmin deve clicar em _Excluir_ e depois em confirmar exclusão para finalizar o processo.

Para adicionar uma nova categoria, o superadmin deve ir à tabela _Categorias_, preencher o campo notado como _Nova categoria_ e clicar em _Adicionar_ e,assim, a nova categoria será incluída automaticamente na lista de categorias. Ao criar uma categoria, o sistema insere o nome desta em uma tabla que será acessada pelos produtos. Para alterar o nome da categoria, basta alterá-lo na tabela e clicar em _Salvar_. Os mesmos processos para bloqueio, desbloqueio e exclusão dos produtos valem para as categorias.

Na tabela de _Compras_, é possível visualizar todo o histórico de compras da loja e atualizar os campos de código de rastreio de cada compra, inserindo os valores e clicando em _Enviar_.

Os clientes podem navegar pelo site, simular compras e se cadastrar para poderem salvar produtos em sua lista de preferência, preencher alguns campos com seus dados automaticamente e visualizar seu histórico de compras.


*Para o desenvolvimento, foi usada a plataforma xampp para executar o server e neste foram feitas as configurações para envio automático de emails. O sistema envia automaticamente emails para os endereços escolhidos quando uma nova compra é realizada ou quando uma há requisição de redefinição de senha de usuário cliente.


Para facilitar o entendimento, o sistema foi colocado online em um servidor gratuito (alguns atrasos de resposta do banco causam bugs de interpretação de erro, mas as funções são executadas corretamente apesar dos warnings. As única função desabilitada propositalmente para este simulador do serviço é a de envio automático de emails, que é inacessível pela gratuidade da conta deste servidor), acessado através do endereço https://fpfstore.000webhostapp.com/

O endereço e senha do superadmin serão passados através de outro meio de comunicação.
