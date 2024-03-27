## Arquitetura do Sistema de Pagamento - PaymentPAY

![Arquitetura do Sistema de Pagamento](/_docs/Images/arch-infra.png)

### Descrição:
Esta arquitetura representa um sistema modular de processamento de pagamentos integrado com notificações via SMS e e-mail. A interação começa com diferentes tipos de clientes (PF - Pessoa Física, PJ - Pessoa Jurídica, ADM - Administrador) acessando a API REST de Pagamento hospedada em um contêiner Docker. O banco de dados MySQL também está encapsulado em um Docker, garantindo a persistência dos dados e a escalabilidade do serviço.

O componente central é a API REST de Pagamento que gerencia a lógica de transações de pagamento. Esta API interage com o 'Payment Authorizer' para validar as transações. Se autorizado, a transação é executada e os detalhes são armazenados em 'Payment', 'Wallet' e 'Customer'. Se houver necessidade de reverter a transação, o serviço 'Transaction Revert' é acionado.

O sistema também possui filas para envio de SMS e e-mails através de serviços externos, também hospedados em contêineres Docker. O 'Queue Send SMS' e 'Queue Send Email' são acionados após o processamento da transação, para notificar o cliente sobre o status do pagamento.

Por fim, o 'Servidor REDIS', operando como uma estrutura de dados em memória, oferece serviços de fila e cache para otimizar a performance do sistema, reduzindo o tempo de acesso aos dados frequentemente requisitados e agilizando a entrega de mensagens através das filas de notificações.

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
