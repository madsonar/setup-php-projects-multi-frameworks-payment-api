#!/bin/sh

# Define COMPOSER_INSTALL como true por padrão se não estiver definido
: ${COMPOSER_INSTALL:=true}

# Executa composer install se COMPOSER_INSTALL for true
if [ "$COMPOSER_INSTALL" = "true" ]; then
    echo ">>> Running composer install"
    composer install
else
    echo ">>> Skipping composer install"
fi

# Caso contrário, execute o comando 'php bin/hyperf.php start'
echo "bin/hyperf.php start"
php bin/hyperf.php start

