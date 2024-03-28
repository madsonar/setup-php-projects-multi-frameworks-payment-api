# Arquitetura e Padrões de Design do Projeto PaymentPAY

### Introdução
Seja bem-vindo(a) ao projeto PaymentPAY, uma plataforma de processamento de pagamentos construída sobre os pilares da inovação e das melhores práticas de engenharia de software. Nosso objetivo é oferecer uma aplicação robusta, segura e escalável, incorporando metodologias e tecnologias de ponta.

### Arquitetura do Projeto
O PaymentPAY é fundamentado em uma arquitetura híbrida que combina os frameworks Laravel e Symfony. Aplicamos o Domain-Driven Design (DDD) para modelar complexidades do domínio de negócio, juntamente com a Clean Architecture e a Arquitetura Hexagonal, assegurando a separação entre a lógica de negócios e infraestrutura.

### Princípios e Padrões:
#### SOLID: 
Implementamos os princípios SOLID para promover um código mais sustentável e extensível.
#### Design Patterns: 
Utilizamos padrões de design reconhecidos que ajudam a resolver problemas comuns e melhorar a estrutura do código.
#### Inversão de Controle e Injeção de Dependência: 
Para promover um baixo acoplamento e alta coesão, empregamos técnicas de IoC e DI, que facilitam a gestão de dependências e a testabilidade do código.
#### Clean Code: 
A clareza e a simplicidade do código são prioridades, seguindo as diretrizes de Clean Code para facilitar a manutenção e evolução do projeto.
#### Qualidade de Código
Adotamos o PHPCS para linting, garantindo conformidade com os padrões de codificação do PHP e a manutenção de um alto padrão de qualidade no código-fonte. A adesão aos padrões da Doctrine e às PSRs do PHP é rigorosa, visando consistência e interoperabilidade.

### Infraestrutura e Operações
#### Docker: 
Utilizamos contêineres Docker para encapsular nosso ambiente de desenvolvimento e produção, garantindo consistência entre os ambientes.
#### Kubernetes: 
A escalabilidade e a gestão dos contêineres são realizadas com Kubernetes, proporcionando um deployment resiliente e gerenciável.
#### Makefile: 
Para facilitar a automação de tarefas, como subir e construir o projeto, empregamos um Makefile, que permite a execução de comandos complexos com simplicidade.

### Organização do Código
#### Services e Usecases: 
A lógica de negócios é encapsulada em serviços e casos de uso, definindo claramente as regras de negócio e suas interações.
#### Repositories: 
Os repositórios abstraem a camada de dados, permitindo uma maior flexibilidade e desacoplamento do ORM.
#### API REST: 
Expondo nossos serviços através de uma API REST, garantimos uma interface clara e padronizada para integrações externas.

## Domain-Driven Design (DDD):
É uma abordagem para desenvolvimento de software que enfatiza a modelagem com base no domínio de negócios, ou seja, nas regras e lógica de negócios. Um dos seus principais componentes é o conceito de Bounded Contexts, que são limites claros dentro dos quais um modelo de domínio específico é definido e aplicável.

Na estrutura de diretórios do projeto PaymentPAY, pode-se observar a aplicação dos conceitos de DDD e a organização em camadas, que são:

## CoreDomain: 
Representa o coração da lógica de negócio, onde os Bounded Contexts, como 'AI' e 'Payment', residem.

## BoundedContexts: 
Contêm as regras e lógica de negócio específicas para cada contexto do domínio, como 'Payment'. Isso ajuda a manter a modularidade e a clareza do código.

## Domain: 
A camada de domínio onde as Entidades (que representam conceitos do domínio e contêm a lógica de negócio essencial), ValueObjects (objetos imutáveis que representam descrições qualitativas ou quantitativas), Enums (para tipos enumerados com um conjunto limitado de constantes), Exceções (personalizadas para as regras de negócio) e Repositórios (interfaces para abstrair a camada de persistência de dados) estão definidos.

## Application: 
Contém os DTOs (Data Transfer Objects) para transferir dados entre processos, Services (onde a lógica de aplicação que opera sobre o domínio é definida) e UseCases (que expressam operações de negócio específicas).

## Infrastructure: 
Representa detalhes técnicos que suportam a aplicação, como Controllers HTTP (que manipulam as requisições e respostas HTTP), Models (que são geralmente mapeamentos ORM para a base de dados), Repositories concretos (implementações das interfaces definidas no domínio), e adaptadores para trabalhos de Jobs.

## Shared e SupportDomain: 
Contêm componentes compartilhados e suporte que podem ser usados por múltiplos Bounded Contexts, como contratos de requisição/resposta, exceções base, helpers e adaptadores de clientes HTTP.

## Esta estrutura promove uma série de benefícios no desenvolvimento, tais como:

## Isolamento de Contexto: 
Cada Bounded Context é independente e focado no seu próprio domínio.
## Manutenibilidade: 
A separação clara entre a lógica de negócios e a infraestrutura facilita a manutenção e a evolução do sistema.
## Testabilidade: 
A separação em camadas permite a implementação de testes específicos para cada parte do sistema, garantindo que a lógica de negócios e a infraestrutura possam ser testadas de forma independente.

Além disso, o uso de Docker e Kubernetes contribui para a escalabilidade e facilita o processo de CI/CD, enquanto que o Makefile oferece uma forma prática de automatizar comandos de build e setup, proporcionando um ambiente de desenvolvimento consistente e eficiente.

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

## Tree project PaymentPAY
```make
├── CoreDomain
│   └── BoundedContexts
│       ├── Ai
│       └── Payment
│           ├── Application
│           │   ├── DTOs
│           │   └── Services
│           │       ├── Customer
│           │       │   └── CreateCustomerService.php
│           │       ├── Transaction
│           │       │   ├── ExecuteTransactionService.php
│           │       │   └── RevertTransactionService.php
│           │       └── Wallet
│           │           └── CheckBalanceWalletService.php
│           ├── Domain
│           │   ├── Entities
│           │   │   ├── Customer.php
│           │   │   ├── Transaction.php
│           │   │   └── Wallet.php
│           │   ├── Enums
│           │   │   ├── CustomerType.php
│           │   │   └── TransactionStatus.php
│           │   ├── Exceptions
│           │   │   ├── InsufficientFunds.php
│           │   │   ├── ShopkeeperCannotSend.php
│           │   │   └── TransactionNotAuthorized.php
│           │   ├── Repositories
│           │   │   ├── CustomerRepositoryContract.php
│           │   │   ├── TransactionRepositoryContract.php
│           │   │   └── WalletRepositoryContract.php
│           │   ├── Services
│           │   │   ├── ExternalPaymentAuthorizerService.php
│           │   │   ├── ExternalSendEmailService.php
│           │   │   ├── ExternalSendSmsService.php
│           │   │   └── Jobs
│           │   │       ├── SendEmailJobService.php
│           │   │       └── SendSmsJobService.php
│           │   ├── UseCases
│           │   │   ├── Customer
│           │   │   │   └── CreateCustomerUseCase.php
│           │   │   ├── Transaction
│           │   │   │   ├── ExecuteTransactionUseCase.php
│           │   │   │   └── RevertTransactionUseCase.php
│           │   │   └── Walet
│           │   │       └── CheckBalanceWalletUseCase.php
│           │   └── ValueObjects
│           ├── Infrastructure
│           │   ├── Customer
│           │   │   ├── Http
│           │   │   │   └── Controllers
│           │   │   │       └── CustomerController.php
│           │   │   ├── Models
│           │   │   │   └── Customer.php
│           │   │   ├── Repositories
│           │   │   │   └── CustomerRepository.php
│           │   │   ├── Requests
│           │   │   │   └── Customer
│           │   │   │       └── CreateCustomerRequest.php
│           │   │   └── Response
│           │   │       └── Customer
│           │   │           └── CreateCustomerResponse.php
│           │   └── Payment
│           │       ├── Http
│           │       │   └── Controllers
│           │       │       ├── TransactionController.php
│           │       │       └── WalletController.php
│           │       ├── Job
│           │       │   ├── SendEmailJobAdapter.php
│           │       │   └── SendSmsJobAdapter.php
│           │       ├── Models
│           │       │   ├── Transaction.php
│           │       │   └── Wallet.php
│           │       ├── Repositories
│           │       │   ├── TransactionRepository.php
│           │       │   └── WalletRepository.php
│           │       ├── Requests
│           │       │   ├── Transaction
│           │       │   │   ├── ExecuteTransactionRequest.php
│           │       │   │   └── RevertTransactionRequest.php
│           │       │   └── Wallet
│           │       │       └── CheckBalanceWalletRequest.php
│           │       └── Response
│           │           ├── Transaction
│           │           │   ├── ExecuteTransactionResponse.php
│           │           │   └── RevertTransactionResponse.php
│           │           └── Wallet
│           │               └── CheckBalanceWalletResponse.php
│           └── Tests
├── GenericDomain
├── Shared
│   ├── Application
│   │   └── Contracts
│   │       ├── Request
│   │       │   └── RequestContract.php
│   │       └── Response
│   │           ├── BaseResponse.php
│   │           └── ResponseContract.php
│   ├── Domain
│   │   ├── Contracts
│   │   │   ├── Exception
│   │   │   │   ├── BaseException.php
│   │   │   │   └── ExceptionContract.php
│   │   │   ├── HttpClient
│   │   │   │   └── HttpClientContract.php
│   │   │   └── Job
│   │   │       └── JobContract.php
│   │   └── Helpers
│   │       └── UuidHelper.php
│   └── Infrastructure
│       └── Adapters
│           └── Http
│               └── Client
│                   └── Laravel
│                       └── HttpClientLaravel.php
└── SupportDomain
```

#### Conclusão
O PaymentPAY representa a sinergia entre práticas modernas de desenvolvimento e operações, resultando em uma plataforma de pagamentos que não apenas atende aos requisitos técnicos e de negócios de hoje, mas também está preparada para as demandas do futuro.


## Criando estrutura Base com Frameworks
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

- Para criar um novo projeto com Framework Symfony API | Endereço 'http://localhost:9010/')
```make
make create-project-symfony-web
```

- Para criar um novo projeto com Framework Symfony Web | Endereço 'http://localhost:9011/')
```make
make create-project-symfony-api
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

- Rodar as filas: 
```make
make run-queues
```

- Rodar os testes: 
```make
make run-tests
```

- Rodar PHPCS: 
```make
run-phpcs
```

### Pronto de melhorias

Extra functions
	Colocar credito
	Ver histórico

Negocio 
	Um cliente pode ter varias wallters
	Dividir a transação em entrada e saída nas contas com positivo e negativo
	Validar cpf / cnpj com base no tipo do cliente
	Cadastro deve ter telefone

Arch
	Usar uuid nos id das tabelas do banco de dados
	Criar classe para representar os status code http no response
	Estrutura erros na resposta de validação, mostrar todos e por campo

## Contato
- [LinkedIn](https://www.linkedin.com/in/madson-aguiar-rodrigues-5650472b/)
- [YouTube](https://www.youtube.com/@MadsonAguiarRodrigues)

## Conclusão
