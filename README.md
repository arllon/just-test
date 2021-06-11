# API
## Just Test
### Código para avaliação de conhecimento

* [Instalação](#instalacao)
* [Testes](#testes)
### Instalação
#### Pré Requisitos
Antes de começar, você precisa ter o docker instalado em sua máquina, sugestão para instalação é seguir os passos desse link da [Digital Ocean.](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04-pt)

Caso não possua o docker é necessário ter instalado na máquina:
PHP >= 7.3
MySQL >= 5.4

### 🎲 Rodando o Back End (servidor) com Docker
```bash
# Acesse a pasta do projeto no terminal/cmd
$ cp .env.example .env

$ make build
# Caso você já tenha executado o make build em algum momento ou seu ambiente já estava rodando com o docker
# apenas execute o seguinte comando
$ make start
# Se precisar baixar os containers basta executar o seguinte comando
$ make destroy-api
# Ao final do processo o projeto estará rodando na porta 80 - acesse <http://localhost:80>
```

### 🎲 Rodando o Back End (servidor) SEM Docker
```bash
# Acesse a pasta do projeto no terminal/cmd
$ cp .env.example .env
# Execute os seguintes comandos
$ composer install
$ php artisan key:generate
$ php artisan config:clear
$ chmod -R 777 storage
$ php artisan migrate:fresh --seed$ 
$ php -S localhost:8000 -t public
# Ao final do processo o projeto estará rodando na porta 8000 - acesse <http://localhost:8000>
```


### Testes
### ✅ Rodando Testes em ambiente local com docker

```bash
# Para executar os testes basta rodar
$ make setup-tests
$ make run-tests
# Após finalizado os testes rodar os seguintes comando:
$ make rollback-envs
```

### ✅ Rodando Testes em ambiente local SEM docker

```bash
# Necessário rodar todos os passos do tópico "Rodando o Back End (servidor) SEM Docker" desconsiderando o último (php -S localhost:8000 -t public)
# Para executar os testes basta certificar que a .env está apontando para o ambiente local ou de testes e rodar
$ php artisan migrate:fresh --seed
$ ./vendor/bin/phpunit

