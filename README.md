## Arquitetura do Sistema de Pagamento - PaymentPAY

![Arquitetura do Sistema de Pagamento](/_docs/Images/arch-infra.png)

### Descrição:
Esta arquitetura representa um sistema modular de processamento de pagamentos integrado com notificações via SMS e e-mail. A interação começa com diferentes tipos de clientes (PF - Pessoa Física, PJ - Pessoa Jurídica, ADM - Administrador) acessando a API REST de Pagamento hospedada em um contêiner Docker. O banco de dados MySQL também está encapsulado em um Docker, garantindo a persistência dos dados e a escalabilidade do serviço.

O componente central é a API REST de Pagamento que gerencia a lógica de transações de pagamento. Esta API interage com o 'Payment Authorizer' para validar as transações. Se autorizado, a transação é executada e os detalhes são armazenados em 'Payment', 'Wallet' e 'Customer'. Se houver necessidade de reverter a transação, o serviço 'Transaction Revert' é acionado.

O sistema também possui filas para envio de SMS e e-mails através de serviços externos, também hospedados em contêineres Docker. O 'Queue Send SMS' e 'Queue Send Email' são acionados após o processamento da transação, para notificar o cliente sobre o status do pagamento.

Por fim, o 'Servidor REDIS', operando como uma estrutura de dados em memória, oferece serviços de fila e cache para otimizar a performance do sistema, reduzindo o tempo de acesso aos dados frequentemente requisitados e agilizando a entrega de mensagens através das filas de notificações.

## DER Banco de Dados - PaymentPAY

![DER Banco de Dados](/_docs/Images/DER-DB.png)

### Descrição:
Diagrama de Relacionamento de Entidade (DER) do Banco de Dados do PaymentPAY. O diagrama inclui três tabelas: customers, wallets e transactions, que estão inter-relacionadas. Aqui está uma descrição de cada tabela e seus relacionamentos:

### customers

id: Chave primária, do tipo bigint e unsigned.
first_name: Nome do cliente, do tipo varchar com 255 caracteres máximos.
last_name: Sobrenome do cliente, do tipo varchar com 255 caracteres máximos.
document: Documento de identificação do cliente, do tipo varchar com 255 caracteres máximos.
email: E-mail do cliente, do tipo varchar com 255 caracteres máximos.
password: Senha do cliente, do tipo varchar com 255 caracteres máximos.
user_type: Tipo do usuário, podendo ser 'common' ou 'shopkeeper', representado por um enum.
created_at: Timestamp de criação do registro.
updated_at: Timestamp da última atualização do registro.
is_active: Indica se o cliente está ativo, do tipo tinyint.
### wallets

id: Chave primária, bigint unsigned.
customer_id: Chave estrangeira referenciando id da tabela customers.
account_number: Número da conta, varchar com 255 caracteres.
current_balance: Saldo atual, decimal com 10 dígitos no total e 2 dígitos após a vírgula.
created_at: Timestamp de criação do registro.
updated_at: Timestamp da última atualização do registro.
Há uma relação de um-para-um entre customers e wallets, indicada pela seta verde, mostrando que cada cliente tem uma e apenas uma carteira associada.

### transactions

id: Chave primária, bigint unsigned.
transaction_key: Chave de transação, char de 36 caracteres.
payer_id: Chave estrangeira referenciando id da tabela customers para o pagador.
payee_id: Chave estrangeira referenciando id da tabela customers para o recebedor.
value: Valor da transação, decimal com 10 dígitos no total e 2 dígitos após a vírgula.
status: Estado da transação, enum com valores 'PENDING', 'COMPLETED', 'FAILED', 'REVERTED'.
reverted_transaction_id: Chave estrangeira opcional referenciando id da própria tabela transactions, indicando a transação original que foi revertida.
created_at: Timestamp de criação do registro.
updated_at: Timestamp da última atualização do registro.
A tabela transactions tem relações muitos-para-um com a tabela customers, indicando que um cliente pode realizar ou receber várias transações, mas cada transação está ligada a um único pagador e um único recebedor.

## REST API Endpoints Resquest|Response - PaymentePAY

### Customers | Create
![Customer Create](/_docs/Images/endpoints/customers-create.png)

### Customers | Wallet
![Customer Wallet](/_docs/Images/endpoints/customers-wallet.png)

### Payment | Transaction 
![Payment Transaction](/_docs/Images/endpoints/transaction-payment.png)

### Payment | Transaction not authorized
![Payment Transaction not authorized](/_docs/Images/endpoints/transaction-not-authorized.png)

### Payment | Transaction | Revert
![Payment Transaction Revert](/_docs/Images/endpoints/transaction-revert.png)

### Service External Payment Authorizer
![Service External Payment Authorizer](/_docs/Images/endpoints/external-payment-authorizer.png)

### Service External Send Email
![Service External Payment Authorizer](/_docs/Images/endpoints/external-send-email.png)

### Service External Send SMS Not Authorized
![Service External Send SMS Not Authorized](/_docs/Images/endpoints/external-send-sms-not-authorized.png)

## Sobre o Projeto

## Sobre o Projeto
   - Criar setup dokerizados para projects PHP multi-frameworks: Laravel, Symfony e Hyperf

## Requisitos
   - Git
   - Docker e compose
   - Makefile
   - Ambiente Linux, Mac ou Windows WSL



### Comandos Makefile
- Para criar um novo projeto com Framework Laravel | Endereço 'http://localhost:9020/')
```make
make create-project-laravel-api
```

- Para criar um novo projeto com Framework Hyperf | Endereço 'http://localhost:9501/')
```make
make create-project-hyperf
```

- Para buildar após ajustes: 
```make
make up-build
```

- Para parar o Docker Compose: 
```make
make down
```

- Para iniciar o Docker Compose: 
```make
make up
```

- Para iniciar o Docker Compose em modo detached: 
```make
make up-d
```


## Teste app no endereço no browser
- http://0.0.0.0:9501 - Hyperf


## Contato
- [LinkedIn](https://www.linkedin.com/in/madson-aguiar-rodrigues-5650472b/)
- [YouTube](https://www.youtube.com/@MadsonAguiarRodrigues)

## Conclusão
