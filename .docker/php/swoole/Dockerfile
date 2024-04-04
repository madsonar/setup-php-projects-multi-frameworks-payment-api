#FROM openswoole/swoole:php8.2-dev
FROM openswoole/swoole:22.1.2-php8.1

# Argumentos para o nome do usuário, UID e GID
ARG USER
ARG UID
ARG GID

# Adicionar o grupo e o usuário
RUN groupadd -g ${GID} ${USER} && \
    useradd -u ${UID} -g ${USER} -m -s /bin/bash ${USER}

# Criar o diretório inicial e defina as permissões
RUN mkdir -p /home/${USER} && \
    chown -R ${USER}:${USER} /home/${USER}


ENTRYPOINT [ "php", "/var/www/index.php", "start" ]
USER ${USER}
EXPOSE 9977




