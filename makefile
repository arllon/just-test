SHELL = /bin/bash
.SHELLFLAGS = -euo pipefail -c
SO := $(shell uname -s)

start:
	${MAKE} build
	docker-compose up -d

reset-db:
	docker-compose exec -T app php artisan migrate:fresh --seed || :
	exit || :

build:
	docker-compose build
	docker-compose exec -T app composer install	
	${MAKE} reset-db
	docker-compose exec -T app chmod -R 777 storage
	exit

setup-tests:
	${MAKE} start
	docker-compose exec -T app cp .env .env.bkp || :
	docker-compose exec -T app cp .env.test .env || :
	${MAKE} reset-db

run-tests:
	docker-compose exec -T app ./vendor/bin/phpunit

rollback-envs:
	docker-compose exec -T app rm .env
	docker-compose exec -T app cp .env.bkp .env
	docker-compose exec -T app rm .env.bkp