# FROM hyperf/hyperf:8.2-alpine-vedge-swoole-v5.0.3
FROM hyperf/hyperf:8.3-alpine-v3.19-swoole-slim

# Argumentos para o nome do usuário, UID e GID
ARG USER
ARG UID
ARG GID

# Adicionar o grupo e o usuário
RUN addgroup -g ${GID} ${USER} && \
    adduser -u ${UID} -G ${USER} -D -h /home/${USER} -s /bin/bash ${USER}

# Criar o diretório inicial e defina as permissões
RUN mkdir -p /home/${USER} && \
    chown -R ${USER}:${USER} /home/${USER}

# Criar o diretório raiz /data e o subdiretório /data/project
# RUN mkdir -p /data/project
# RUN chown -R ${USER}:${USER} /data/project
# RUN chown -R ${USER}:${USER} /opt/www

# Copia o script entrypoint.sh para dentro do container
# COPY .docker/php/hyperf/scripts/entrypoint-ini.sh /usr/local/bin/entrypoint-ini.sh
COPY .docker/php/hyperf/scripts/entrypoint-ini.sh /usr/local/bin/entrypoint-ini.sh
#COPY ./.docker/php/base-cli/scripts/entrypoint-ini.sh /usr/local/bin/entrypoint-ini.sh

# Torna o script executável
RUN chmod +x /usr/local/bin/entrypoint-ini.sh
# Dar permissões ao usuário para o executável Composer
RUN chown ${USER}:${USER} /usr/local/bin/composer

USER ${USER}
# WORKDIR "/data/project/"
WORKDIR "/opt/www/"
EXPOSE 9501

# ENTRYPOINT
ENTRYPOINT ["/usr/local/bin/entrypoint-ini.sh"]

