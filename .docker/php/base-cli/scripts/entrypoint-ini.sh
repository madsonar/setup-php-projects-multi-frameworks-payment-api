#!/bin/sh

# Verifica se /usr/local/etc/php/php.ini existe, se não, copia php.ini-development para php.ini
if [ ! -f /usr/local/etc/php/php.ini ]; then
    cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
fi

# Verifica se /usr/local/etc/php/conf.d/xdebug.ini existe, se não, copia xdebug.ini-base para conf.d/xdebug.ini
# if [ ! -f /usr/local/etc/php/conf.d/xdebug.ini ]; then
    #cp /usr/local/etc/php/xdebug.ini-base /usr/local/etc/php/conf.d/xdebug.ini
# fi

# Define COMPOSER_INSTALL como true por padrão se não estiver definido
: ${COMPOSER_INSTALL:=true}

# Executa composer install se COMPOSER_INSTALL for true
if [ "$COMPOSER_INSTALL" = "true" ]; then
    echo ">>> Running composer install"
    composer install
else
    echo ">>> Skipping composer install"
fi

# Executa o comando passado como argumento para este script
# exec "$@"

if [ "$TYPE_SERVE" = "laravel" ]; then
    # Comando para servidores Laravel (exemplo: serve Laravel)
    exec php artisan serve --host=0.0.0.0 --port=9009
elif [ "$TYPE_SERVE" = "symfony" ]; then
    # Comando para servidores Symfony (exemplo: serve Symfony) #versões anteriores
    exec php bin/console server:start 0.0.0.0:9009
elif [ "$TYPE_SERVE" = "hyperf" ]; then
    # Comando para servidores Hyperf (exemplo: serve Hyperf)
    exec php bin/hyperf.php start
elif [ "$TYPE_SERVE" = "php" ]; then
    exec php -S 0.0.0.0:9009 -t public
else
    exec php -S 0.0.0.0:9009 
    # exec "$@"
fi
