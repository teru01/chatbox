FROM nginx:1.13.12-alpine
RUN set -x &&\
    apk --update add openssl &&\
    mkdir -p /var/www/html &&\
    openssl genrsa 2048 > server_private.key &&\
    openssl req -new -key server_private.key -subj \
        "/C=JP/ST=Hokkaido/L=Sapporo/O=HITSUJI INC./OU=web/CN=localhost" > server.csr &&\
    openssl x509 -in server.csr -days 3650 -req -signkey server_private.key >server.crt &&\
    cp server.crt /etc/nginx/server.crt &&\
    cp server_private.key /etc/nginx/server_private.key &&\
    chmod 755 -R /var/www/html &&\
    chmod 400  /etc/nginx/server_private.key

