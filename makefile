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
	docker-compose exec -T app php artisan key:generate
	docker-compose exec -T app php artisan config:clear
	${MAKE} reset-db
	docker-compose exec -T app -c "chmod -R 777 storage"
	exit

setup-tests:
	docker-compose exec -T app cp .env .env.bkp || :
	docker-compose exec -T app cp .env.test .env || :
	${MAKE} reset-db

run-tests:
	docker-compose exec -T app ./vendor/bin/phpunit

rollback-envs:
	docker-compose exec -T app rm .env
	docker-compose exec -T app cp .env.bkp .env
	docker-compose exec -T app rm .env.bkp