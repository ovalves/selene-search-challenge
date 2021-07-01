# Desafio de Search utilizando o selene framework

- [Introdução](#Introdução)
- [Conceitos](#Conceitos)
- [Instalação](#Instalação)
    - [Pré-requisitos.](#Pré-requisitos.)
    - [Clonando o projeto](#Clonando-o-projeto)
- [Configurando o nginx](#Configurando-o-nginx)
- [Executanto a aplicação](#Executanto-a-aplicação)
- [Usando o makefile](#Usando-o-makefile)
    - [Exemplos](#Exemplos)
- [Usando os comandos do docker](#Usando-os-comandos-do-docker)
- [Instalando pacotes com composer](#Instalando-pacotes-com-composer)
- [Atualizando dependências PHP com composer](#Atualizando-dependências-PHP-com-composer)
- [Gerando documentações com PHPDOC](#Gerando-documentações-com-PHPDOC)
- [Testando a aplicação com o phpunit](#Testando-a-aplicação-com-o-phpunit)
- [Ajustando o código-fonte com o padrão da PSR2](#Ajustando-o-código-fonte-com-o-padrão-da-PSR2)
- [Ajustando o código-fonte com o padrão da PSR2](#Ajustando-o-código-fonte-com-o-padrão-da-PSR2)
- [Analisando o código-fonte com PHPCS](#Analisando-o-código-fonte-com-PHPCS)
- [Analisando o código-fonte com PHPMD](#Analisando-o-código-fonte-com-PHPMD)
- [Verificando as extensões do PHP instaladas](#Verificando-as-extensões-do-PHP-instaladas)
- [Manipulando o banco de dados](#Manipulando-o-banco-de-dados)
    - [Acesso ao MySQL](#Acesso-ao-MySQL)
    - [Criando um backup de todos os bancos de dados](#Criando-um-backup-de-todos-os-bancos-de-dados)
    - [Restaurando um backup de todos os bancos de dados](#Restaurando-um-backup-de-todos-os-bancos-de-dados)
    - [Criando um backup de um único banco de dados](#Criando-um-backup-de-um-único-banco-de-dados)
    - [Restaurando um backup de um único banco de dados](#Restaurando-um-backup-de-um-único-banco-de-dados)




## Introdução

A users API exposing endpoints to search for users based on its name and username. Some users have higher priority over others; therefore, to identify those users and prioritize them, we also consider two "relevance" lists during the search, which will affect the final result.

## Conceitos

### Estrutura do projeto

```sh
.
├── Makefile
├── README.md
├── data
│   └── db
│       ├── dumps
│       └── mysql
├── doc
├── docker-compose.yml
├── etc
│   ├── nginx
│   │   ├── default.conf
│   │   └── default.template.conf
│   ├── php
│   │   └── php.ini
│   └── ssl
└── web
    ├── app
    │   ├── composer.json.dist
    │   ├── phpunit.xml.dist
    │   ├── src
    │   │   └── Foo.php
    │   └── test
    │       ├── FooTest.php
    │       └── bootstrap.php
    └── public
        └── index.php
```

## Instalação

Before installing project make sure the following Pré-requisitos. have been met.

### Pré-requisitos.
To run the docker commands without using **sudo** you must add the **docker** group to **your-user**:

```
sudo usermod -aG docker your-user
```

For now, this project has been mainly created for Unix `(Linux/MacOS)`. Perhaps it could work on Windows.

All requisites should be available for your distribution. The most important are :

* [Git](https://git-scm.com/downloads)
* [Docker](https://docs.docker.com/engine/installation/)
* [Docker Compose](https://docs.docker.com/compose/install/)

Check if `docker-compose` is already installed by entering the following command :

```sh
which docker-compose
```

Check Docker Compose compatibility :

* [Compose file version 3 reference](https://docs.docker.com/compose/compose-file/)

The following is optional but makes life more enjoyable :

```sh
which make
```

On Ubuntu and Debian these are available in the meta-package build-essential. On other distributions, you may need to install the GNU C++ compiler separately.

```sh
sudo apt install build-essential
```

### Images to use

* [Nginx](https://hub.docker.com/_/nginx/)
* [MySQL](https://hub.docker.com/_/mysql/)
* [PHP-FPM](https://hub.docker.com/r/nanoninja/php-fpm/)
* [Composer](https://hub.docker.com/_/composer/)
* [PHPMyAdmin](https://hub.docker.com/r/phpmyadmin/phpmyadmin/)

You should be careful when installing third party web servers such as MySQL or Nginx.

This project use the following ports :

| Server     | Port |
|------------|------|
| MySQL      | 8989 |
| PHPMyAdmin | 8080 |
| Nginx      | 8000 |
| Nginx SSL  | 3000 |

___

### Clonando o projeto

We’ll download the code from its repository on GitHub.

To install [Git](http://git-scm.com/book/en/v2/Getting-Started-Installing-Git), download it and install following the instructions :

```bash
git clone git@github.com:ovalves/selene-project-a.git
```

Go to the project directory :

```sh
cd docker-nginx-php-mysql
```

___


## Configurando o nginx

Do not modify the `etc/nginx/default.conf` file, it is overwritten by  `etc/nginx/default.template.conf`

Edit nginx file `etc/nginx/default.template.conf` and uncomment the SSL server section :

```sh
# server {
#     server_name ${NGINX_HOST};
#
#     listen 443 ssl;
#     fastcgi_param HTTPS on;
#     ...
# }
```

___


## Executanto a aplicação

1. Copying the composer configuration file :

    ```sh
    cp web/app/composer.json.dist web/app/composer.json
    ```

2. Start the application :

    ```sh
    docker-compose up -d
    ```

    **Please wait this might take a several minutes...**

    ```sh
    docker-compose logs -f # Follow log output
    ```

3. Open your favorite browser :

    * [http://localhost:8000](http://localhost:8000/)
    * [https://localhost:3000](https://localhost:3000/)
    * [http://localhost:8080](http://localhost:8080/) PHPMyAdmin (username: dev, password: dev)

4. Stop and clear services

    ```sh
    docker-compose down -v
    ```

___


## Usando o makefile

When developing, you can use [Makefile](https://en.wikipedia.org/wiki/Make_(software)) for doing the following operations :

| Name          | Description                                  |
|---------------|----------------------------------------------|
| apidoc        | Generate documentation of API                |
| clean         | Clean directories for reset                  |
| code-sniff    | Check the API with PHP Code Sniffer (`PSR2`) |
| composer-up   | Update PHP dependencies with composer        |
| docker-start  | Create and start containers                  |
| docker-stop   | Stop and clear all services                  |
| logs          | Follow log output                            |
| mysql-dump    | Create backup of all databases               |
| mysql-restore | Restore backup of all databases              |
| phpmd         | Analyse the API with PHP Mess Detector       |
| test          | Test application with phpunit                |

### Exemplos

Start the application :

```sh
make docker-start
```

Show help :

```sh
make help
```

___


## Usando os comandos do docker

### Instalando pacotes com composer

```sh
docker run --rm -v $(pwd)/web/app:/app composer require symfony/yaml
```

### Atualizando dependências PHP com composer

```sh
docker run --rm -v $(pwd)/web/app:/app composer update
```

### Gerando documentações com PHPDOC

```sh
docker run --rm -v $(pwd):/data phpdoc/phpdoc -i=vendor/ -d /data/web/app/src -t /data/web/app/doc
```

### Testando a aplicação com o phpunit

```sh
docker-compose exec -T php ./app/vendor/bin/phpunit --colors=always --configuration ./app
```

### Ajustando o código-fonte com o padrão da PSR2

* [PSR2](http://www.php-fig.org/psr/psr-2/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpcbf -v --standard=PSR2 ./app/src
```

### Analisando o código-fonte com PHPCS

* [PSR2](http://www.php-fig.org/psr/psr-2/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpcs -v --standard=PSR2 ./app/src
```

### Analisando o código-fonte com PHPMD

* [PHP Mess Detector](https://phpmd.org/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpmd ./app/src text cleancode,codesize,controversial,design,naming,unusedcode
```

### Verificando as extensões do PHP instaladas

```sh
docker-compose exec php php -m
```

## Manipulando o banco de dados

### Acesso ao MySQL

```sh
docker exec -it mysql bash
```

e

```sh
mysql -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD"
```

#### Criando um backup de todos os bancos de dados

```sh
mkdir -p data/db/dumps
```

```sh
source .env && docker exec $(docker-compose ps -q mysqldb) mysqldump --all-databases -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" > "data/db/dumps/db.sql"
```

#### Restaurando um backup de todos os bancos de dados

```sh
source .env && docker exec -i $(docker-compose ps -q mysqldb) mysql -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" < "data/db/dumps/db.sql"
```

#### Criando um backup de um único banco de dados

**`Notice:`** Replace "YOUR_DB_NAME" by your custom name.

```sh
source .env && docker exec $(docker-compose ps -q mysqldb) mysqldump -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" --databases YOUR_DB_NAME > "data/db/dumps/YOUR_DB_NAME_dump.sql"
```

#### Restaurando um backup de um único banco de dados

```sh
source .env && docker exec -i $(docker-compose ps -q mysqldb) mysql -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" < "data/db/dumps/YOUR_DB_NAME_dump.sql"
```
