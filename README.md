# Desafio de Busca utilizando o selene framework

- [Desafio de Busca utilizando o selene framework](#desafio-de-busca-utilizando-o-selene-framework)
  - [Introdução](#introdução)
  - [Conceitos](#conceitos)
  - [Instalação](#instalação)
    - [Pré-requisitos.](#pré-requisitos)
    - [Imagens utilizadas neste projeto](#imagens-utilizadas-neste-projeto)
    - [Clonando o projeto](#clonando-o-projeto)
    - [Estrutura do projeto](#estrutura-do-projeto)
  - [Comandos do make](#comandos-do-make)
  - [Executando a aplicação](#executando-a-aplicação)
  - [A API de busca](#a-api-de-busca)
    - [Endpoints](#endpoints)
    - [Parâmetros de URL](#parâmetros-de-url)
      - [Exemplo de requisição com parâmetros de URL](#exemplo-de-requisição-com-parâmetros-de-url)
  - [Comandos do docker](#comandos-do-docker)
    - [Instalando pacotes com composer](#instalando-pacotes-com-composer)
    - [Atualizando dependências PHP com composer](#atualizando-dependências-php-com-composer)
    - [Gerando documentações com PHPDOC](#gerando-documentações-com-phpdoc)
    - [Testando a aplicação com o phpunit](#testando-a-aplicação-com-o-phpunit)
    - [Ajustando o código-fonte com o padrão da PSR2](#ajustando-o-código-fonte-com-o-padrão-da-psr2)
    - [Analisando o código-fonte com PHPCS](#analisando-o-código-fonte-com-phpcs)
    - [Analisando o código-fonte com PHPMD](#analisando-o-código-fonte-com-phpmd)
    - [Verificando as extensões do PHP instaladas](#verificando-as-extensões-do-php-instaladas)
  - [Manipulando o banco de dados](#manipulando-o-banco-de-dados)
    - [Acesso ao MySQL](#acesso-ao-mysql)
      - [Criando um backup de todos os bancos de dados](#criando-um-backup-de-todos-os-bancos-de-dados)
      - [Restaurando um backup de todos os bancos de dados](#restaurando-um-backup-de-todos-os-bancos-de-dados)
      - [Criando um backup de um único banco de dados](#criando-um-backup-de-um-único-banco-de-dados)
      - [Restaurando um backup de um único banco de dados](#restaurando-um-backup-de-um-único-banco-de-dados)

___

## Introdução

Este repositório provê uma API para busca de usuário. Os endpoints definidos nesta API listam os dados de usuários com base em seu nome e em seu nome de usuário.
___

## Conceitos

Esta API utiliza como base a linguagem PHP e o [Selene](https://github.com/ovalves/selene) framework.

Como definição para a resolução do problema de busca de usuários. Temos:

* Alguns usuários possuem maior prioridade, portanto, primeiro devemos identificar esses usuários e então priorizá-los no retorno da API
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

### Estrutura do projeto

```sh
├── data
│   └── db
│       ├── dumps
│       └── mysql
├── etc
│   ├── nginx
│   │   ├── default.conf
│   │   └── default.template.conf
│   ├── php
│   │   └── php.ini
│   └── ssl
├── web
│   ├── app
│   │   ├── composer.json
│   │   ├── phpunit.xml
│   │   ├── .php-cs-fixer.php
│   │   ├── src
│   │   │   ├── Config
│   │   │   ├── Controllers
│   │   │   ├── Gateway
│   │   │   ├── Models
│   │   │   └── Storage
│   │   └── tests
│   │       └── Api
│   ├── conf
│   │   └── .env
│   └── public
│       ├── Views
│       └── index.php
├── docker-compose.yml
├── Makefile
└── README.md
```
___

## Comandos do make

Os seguintes comandos estão disponíveis através do `make`:

| Name          | Description                                                   |
|---------------|---------------------------------------------------------------|
| phpdoc        | Gerador de documentação de do código PHP                      |
| clean         | Rodar o Code Sniffer no código PHP (PSR2)                     |
| code-sniff    | Limpar os diretórios necessários para reiniciar os containers |
| composer-up   | Atualizar as dependências do PHP utilizando o composer        |
| start         | Iniciar todos os serviços                                     |
| stop          | Parar todos os serviços                                       |
| logs          | Visualizar os logs dos serviços                               |
| mysql-dump    | Criar backup de todos os bancos de dados                      |
| mysql-restore | Restaurar o backup de todos os bancos de dados                |
| phpmd         | Rodar o PHP Mess Detector no código PHP                       |
| test          | Rodar os testes da aplicação                                  |

___

## Executando a aplicação

Executando a aplicação com o banco de dados do desafio de busca:

    ```sh
    make start-with-db
    ```

1. Executando a aplicação:

    ```sh
    make start
    ```

2. Verificando os logs da aplicação:

    ```sh
    make logs
    ```

3. Acesse a aplicação em seu navegador:

    * [http://localhost:8000](http://localhost:8000/)
    * [https://localhost:3000](https://localhost:3000/)
    * [http://localhost:8080](http://localhost:8080/) PHPMyAdmin (username: dev, password: dev)

4. Parando a aplicação e limpando os serviços

    ```sh
    make stop # Talvez você tenha que rodar este comando usando o sudo
    ```
___

## A API de busca

### Endpoints

| URL                                | Serviço                                                     |
|------------------------------------|-------------------------------------------------------------|
| [/](/)                             | Página inicial com as diretrizes do projeto                 |
| [/users/name](/users/name)         | Retorna todos os usuários de acordo com seu nome completo   |
| [/users/username](/users/username) | Retorna todos os usuários de acordo com seu nome de usuário |


### Parâmetros de URL
| Parâmetro | Descrição                                                                                                       |
|-----------|-----------------------------------------------------------------------------------------------------------------|
| query     | Utilize este parâmetro para realizar uma busca nos endpoints                                                    |
| from      | Utilize este parâmetro para configurar o inicio da busca de usuários  (default: 1)                              |
| size      | Utilize este parâmetro para configurar a quantidade de usuários que devem ser retornados na busca (default: 15) |

#### Exemplo de requisição com parâmetros de URL

Buscando usuários por nome completo

```
GET /users/name?query=Edmundo&from=1&size=10
```

Buscando usuários por nome de usuário
```
GET /users/username?query=Edmundo&from=1&size=10
```
___

## Comandos do docker

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
