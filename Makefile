# Definindo o 'init-script' para executar o script init-local.sh
USER := $(shell id -un)
UID := $(shell id -u)
GID := $(shell id -g)
PROJECT := "compose-project"
#ENV = "./app-symfony-my-test/.env"

init-script: #subir network
	@echo "Executando o script start..."
	@sh ./scripts/init-local.sh

up: init-script
	@echo "Iniciando o Docker Compose..."
	@docker compose up --force-recreate
#	@docker compose -p $(PROJECT) up --force-recreate
#	@docker compose -p $(PROJECT) up --force-recreate

down: init-script
	@echo "Parando os contêineres do Docker Compose..."
#	@docker compose -p $(PROJECT) down --remove-orphans
	@docker compose down --remove-orphans

up-d: init-script
	@echo "Iniciando o Docker Compose em modo detached..."
#	@docker compose -p $(PROJECT) up -d
	@docker compose up -d

up-build: init-script down
	@echo "Construindo as imagens do Docker Compose..."
	@echo "USER_ID: $(UID)"
	@echo "GROUP_ID: $(GID)"
	@echo "USER_NAME: $(USER)"
# @docker rm -f php-swoole-hyperf 2>/dev/null || true
	@docker compose build --build-arg UID=$(UID) --build-arg GID=$(GID) --build-arg USER=$(USER)
#	@docker compose -p $(PROJECT) up -d
#	@docker compose --env-file $(ENV) up -d
	@docker compose up -d
	@echo "Docker Compose em modo detached..."

#cmd:
#	@echo "Executando o comando dentro do container PHP..."
#	@docker compose exec create-project-hyperf $(c)

# Regra para criar um projeto Hyperf: make create-project-hyperf
create-project-hyperf:
	@if [ ! -d "./app-hyperf" ]; then \
		mkdir app-hyperf; \
	fi;
	@if [ -z "$$(ls -A ./app-hyperf)" ]; then \
		echo "A pasta 'app-hyperf' está vazia. Criando um novo projeto Hyperf..."; \
		make up-build; \
		docker compose exec php-cli-base composer create-project hyperf/hyperf-skeleton /var/www/html/app-hyperf;\
		echo "Projeto criado com sucesso!"; \
		docker restart php-swoole-hyperf; \
		echo "Container 'php-swoole-hyperf' reiniciado com sucesso!"; \
	else \
		echo "A pasta 'app-hyperf' já contém um projeto. Nenhuma ação realizada."; \
	fi;

# Regra para criar um projeto Symfony: make create-project-symfony-web
create-project-symfony-web:
	@if [ ! -d "./app-symfony-web" ]; then \
		mkdir app-symfony-web; \
	fi;
	@if [ -z "$$(ls -A ./app-symfony-web)" ]; then \
		echo "A pasta 'app-symfony-web' está vazia. Criando um novo projeto Symfony..."; \
		make up-build; \
		docker compose exec php-cli-base composer create-project symfony/skeleton /var/www/html/app-symfony-web &&\
		docker compose exec php-cli-base composer require webapp -d /var/www/html/app-symfony-web && \
		echo "Projeto Symfony criado com sucesso!"; \
		docker restart php-cli-base-symfony-web; \
        echo "Container 'php-cli-base-symfony-web' reiniciado com sucesso!"; \
	else \
		echo "A pasta 'app-symfony-web' já contém um projeto. Nenhuma ação realizada."; \
	fi;

# Regra para criar um projeto Symfony: make create-project-symfony-api
create-project-symfony-api:
	@if [ ! -d "./app-symfony-api" ]; then \
		mkdir app-symfony-api; \
	fi;
	@if [ -z "$$(ls -A ./app-symfony-api)" ]; then \
		echo "A pasta 'app-symfony-api' está vazia. Criando um novo projeto Symfony..."; \
		make up-build; \
		docker compose exec php-cli-base composer create-project symfony/skeleton /var/www/html/app-symfony-api &&\
		echo "Projeto Symfony criado com sucesso!"; \
		docker restart php-cli-base-symfony-api; \
        echo "Container 'php-cli-base-symfony-api' reiniciado com sucesso!"; \
	else \
		echo "A pasta 'app-symfony-api' já contém um projeto. Nenhuma ação realizada."; \
	fi;

# Regra para criar um projeto laravel: make create-project-laravel-api
create-project-laravel-api:
	@if [ ! -d "./app-laravel-api" ]; then \
		mkdir app-laravel-api; \
	fi;
	@if [ -z "$$(ls -A ./app-laravel-api)" ]; then \
		echo "A pasta 'app-laravel-api' está vazia. Criando um novo projeto laravel..."; \
		make up-build; \
		docker compose exec php-cli-base composer create-project laravel/laravel /var/www/html/app-laravel-api &&\
		echo "Projeto Laravel api criado com sucesso!"; \
		docker restart php-cli-base-laravel-api; \
        echo "Container 'php-cli-base-laravel-api' reiniciado com sucesso!"; \
	else \
		echo "A pasta 'app-symlaravelfony-api' já contém um projeto. Nenhuma ação realizada."; \
	fi;

# Comando para executar as filas do Laravel no container
run-queues:
	@echo "Iniciando as filas do Laravel..."
	@docker compose exec php-cli-base-laravel-api php artisan queue:work --queue=emails & \
	docker compose exec php-cli-base-laravel-api php artisan queue:work --queue=sms & \
	docker compose exec php-cli-base-laravel-api php artisan queue:retry all

# Comando para executar o PHPCS no container
run-phpcs:
	@echo "Executando PHPCS..."
	@docker compose exec php-cli-base-laravel-api vendor/bin/phpcs -q --standard=./phpcs.xml.dist

# Comando para executar testes do Laravel no container
run-tests:
	@echo "Executando testes do Laravel..."
	@docker compose exec php-cli-base-laravel-api php artisan test

# Correção do teste
run-tests-pp:
	@echo "Correção do teste..."
	@docker run -it --rm -v $(pwd):/project -w /project jakzal/phpqa phpmd Architecture text cleancode,codesize,controversial,design,naming,unusedcode