# Desafio de Busca utilizando o selene framework

- [Introdução](#Introdução)
- [Conceitos](#Conceitos)
- [Instalação](#Instalação)
    - [Pré-requisitos.](#Pré-requisitos.)
    - [Imagens utilizadas neste projeto](#Imagens-utilizadas-neste-projeto)
    - [Clonando o projeto](#Clonando-o-projeto)
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

___

## Introdução

Este repositório provê uma API para busca de usuário. Os endpoints definidos nesta API listam os dados de usuários com base em seu nome e em seu nome de usuário.
___

## Conceitos

Esta API utiliza como base a linguagem PHP e o [Selene](https://github.com/ovalves/selene) framework.

Como definição para a resolução do problema de busca de usuários. Temos:

* Alguns usuários possuem maior prioridade, portanto, primeiro devemos identificar esses usuários e então priorizá-los no retorno da API
___

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
___

## Instalação

Antes de instalar o projeto, certifique-se de possuir os seguintes pré-requisitos.

### Pré-requisitos.

Os seguintes requisitos devem estar instalados em sua máquina:

* [Git](https://git-scm.com/downloads)
* [Docker](https://docs.docker.com/engine/installation/)
* [Docker Compose](https://docs.docker.com/compose/install/)
___

### Imagens utilizadas neste projeto

* [Nginx](https://hub.docker.com/_/nginx/)
* [MySQL](https://hub.docker.com/_/mysql/)
* [PHP-FPM](https://hub.docker.com/r/nanoninja/php-fpm/)
* [Composer](https://hub.docker.com/_/composer/)
* [PHPMyAdmin](https://hub.docker.com/r/phpmyadmin/phpmyadmin/)

As seguintes portas são utilizadas neste projeto:

| Server     | Port |
|------------|------|
| MySQL      | 8989 |
| PHPMyAdmin | 8080 |
| Nginx      | 8000 |
| Nginx SSL  | 3000 |
___

### Clonando o projeto

O código do repositório será baixado do GitHub.

Acesse [Git](http://git-scm.com/book/en/v2/Getting-Started-Installing-Git), faça o download e instale seguindo as instruções:

```bash
git clone git@github.com:ovalves/selene-project-a.git
```

Acesse o diretório do projeto:

```sh
cd selene-project-a
```
___

## Executanto a aplicação

1. Executando a aplicação:

    ```sh
    docker-compose up -d
    ```

2. Verificando os logs da aplicação:

    ```sh
    docker-compose logs -f
    ```

3. Acesse o seguindo link em seu navegador:

    * [http://localhost:8000](http://localhost:8000/)
    * [https://localhost:3000](https://localhost:3000/)
    * [http://localhost:8080](http://localhost:8080/) PHPMyAdmin (username: dev, password: dev)

4. Parando o docker e limpando os serviços

    ```sh
    docker-compose down -v
    ```
___

## Usando o makefile

Os seguintes comandos estão disponíveis através do `make`:

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

Executando a aplicação:

```sh
make docker-start
```

Pedindo ajuda:

```sh
make help
```
___

## Usando os comandos do docker

### Instalando pacotes com composer

```sh
docker run --rm -v $(pwd)/web/app:/app composer require symfony/dotenv
```
___

### Atualizando dependências PHP com composer

```sh
docker run --rm -v $(pwd)/web/app:/app composer update
```
___

### Gerando documentações com PHPDOC

```sh
docker run --rm -v $(pwd):/data phpdoc/phpdoc -i=vendor/ -d /data/web/app/src -t /data/web/app/doc
```
___

### Testando a aplicação com o phpunit

```sh
docker-compose exec -T php ./app/vendor/bin/phpunit --colors=always --configuration ./app
```
___

### Ajustando o código-fonte com o padrão da PSR2

* [PSR2](http://www.php-fig.org/psr/psr-2/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpcbf -v --standard=PSR2 ./app/src
```
___

### Analisando o código-fonte com PHPCS

* [PSR2](http://www.php-fig.org/psr/psr-2/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpcs -v --standard=PSR2 ./app/src
```
___

### Analisando o código-fonte com PHPMD

* [PHP Mess Detector](https://phpmd.org/)

```sh
docker-compose exec -T php ./app/vendor/bin/phpmd ./app/src text cleancode,codesize,controversial,design,naming,unusedcode
```
___

### Verificando as extensões do PHP instaladas

```sh
docker-compose exec php php -m
```
___

## Manipulando o banco de dados

### Acesso ao MySQL

```sh
docker exec -it mysql bash
```

e

```sh
mysql -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD"
```
___

#### Criando um backup de todos os bancos de dados

```sh
mkdir -p data/db/dumps
```

```sh
source .env && docker exec $(docker-compose ps -q mysqldb) mysqldump --all-databases -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" > "data/db/dumps/db.sql"
```
___

#### Restaurando um backup de todos os bancos de dados

```sh
source .env && docker exec -i $(docker-compose ps -q mysqldb) mysql -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" < "data/db/dumps/db.sql"
```
___

#### Criando um backup de um único banco de dados

```sh
source .env && docker exec $(docker-compose ps -q mysqldb) mysqldump -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" --databases YOUR_DB_NAME > "data/db/dumps/YOUR_DB_NAME_dump.sql"
```
___

#### Restaurando um backup de um único banco de dados

```sh
source .env && docker exec -i $(docker-compose ps -q mysqldb) mysql -u "$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" < "data/db/dumps/YOUR_DB_NAME_dump.sql"
```
