# LEMP
Um fluxo de trabalho bastante simplificado com [Docker compose](https://docs.docker.com/compose/) para multisite LEMP

# Stacks
1) Linux Alpine (php:7.4-fpm-alpine)
    - Installed packages : `libpng-dev libzip-dev zlib-dev unzip zip git composer`
    - Installed php extensions : `gd pdo_mysql mysqli mbstring zip exif pcntl`
2) NGINX (nginx:alpine)
3) Mysql (mysql:latest)
4) phpMyAdmin (phpmyadmin/phpmyadmin)

# Configurando
1) Clone
```bash
$ git clone https://github.com/askaoru/LempFleet docker
```
2) Vá para o diretório e inicie os containers
```bash
$ cd docker/_server && docker-compose up -d
```
3) Pronto! Você deve ser capaz de ver se os containers estão sendo executados!

Para verificar se há serviços em execução, execute
```bash
$ docker-compose ps

    Name                  Command              State                    Ports
-----------------------------------------------------------------------------------------------
applications   docker-php-entrypoint php-fpm   Up      9000/tcp
database       docker-entrypoint.sh mysqld     Up      0.0.0.0:3306->3306/tcp, 33060/tcp
webserver      nginx -g daemon off;            Up      0.0.0.0:443->443/tcp, 0.0.0.0:80->80/tcp
phpmyadmin     /docker-entrypoint.sh apac ...  Up      0.0.0.0:8081->80/tcp
```

Para acessar o container, execute
```bash
$ docker exec -it applications /bin/sh
$ docker exec -it database /bin/sh
$ docker exec -it webserver /bin/sh
$ docker exec -it phpmyadmin /bin/sh
```

# Adicionando um projeto
É muito simples!
1) Adicione seu projeto na pasta do aplicativo
Exemplo
```
- _server
  - etc
    - nginx
    - php
  - mysql
  - docker-compose.yml
- www
  - seuprojeto1 <-- aqui
    - index.php
  - seuprojeto2 <-- e aqui
    - index.php

```
2) Crie um arquivo conf nginx para seus projetos
```
- _server
  - etc
    - nginx
      - project1.conf <-- aqui
      - project2.conf <-- e aqui
    - php
  - mysql
  - docker-compose.yml
- www
```
exemplo de conteúdo para cada um deles.
```Nginx
server {
  listen 80;
  index index.php index.html;
  error_log  /var/log/nginx/error.log;
  access_log /var/log/nginx/access.log;

  server_name seuprojeto1.dev;
  root /var/www/html/seuprojeto1;

  location ~ \.php$ {
    try_files $uri =404;
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass php:9000;
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_param PATH_INFO $fastcgi_path_info;
  }
  location / {
    try_files $uri $uri/ /index.php?$query_string;
    gzip_static on;
  }
}
```
3) Faca o apontamento do seu server name no seu hosts - No linux execute este comando:

```bash
sudo nano /etc/hosts
$ 127.0.0.1 seuprojeto1.dev
```

4) Pronto! Tudo que você precisa fazer agora é reiniciar os serviço
```bash
$ docker-compose down && docker-compose up -d
```
