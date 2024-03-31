#!/bin/sh

composer install

# Caso contrário, execute o comando 'php bin/hyperf.php start'
echo "bin/hyperf.php start"
# php bin/hyperf.php start
php bin/hyperf.php server:watch


