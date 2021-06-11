SHELL = /bin/bash
.SHELLFLAGS = -euo pipefail -c
SO := $(shell uname -s)

start:
	docker-compose up -d

reset-db: 
	docker-compose exec -T app php artisan migrate:fresh --seed

build:
	docker-compose build --no-cache
	${MAKE} start
	docker-compose exec -T app composer install	
	${MAKE} reset-db
	docker-compose exec -T app -c "chmod -R 777 storage"
	exit

setup-db-tests:
	docker-compose exec -T app php artisan migrate
	docker-compose exec -T app php artisan seed

setup-tests:
	${MAKE} build
	docker-compose exec -T app cp .env .env.bkp || :
	docker-compose exec -T app cp .env.test .env || :
	${MAKE} setup-db-tests

run-tests:
	docker-compose exec -T app ./vendor/bin/phpunit

rollback-envs:
	docker-compose exec -T app rm .env
	docker-compose exec -T app cp .env.bkp .env
	docker-compose exec -T app rm .env.bkp