SHELL = /bin/bash
.SHELLFLAGS = -euo pipefail -c
SO := $(shell uname -s)

start:
	docker-compose up -d

reset-db: 
	docker-compose exec -T just-test_app_1 php artisan migrate:fresh --seed

build:
	docker-compose build --no-cache
	${MAKE} start
	docker-compose exec -T just-test_app_1 composer install
	docker-compose exec -T just-test_app_1 php artisan key:generate
	docker-compose exec -T just-test_app_1 php artisan config:clear
	${MAKE} reset-db
	docker-compose exec -T just-test_app_1 -c "chmod -R 777 storage"
	exit

setup-tests:
	docker-compose exec -T just-test_app_1 cp .env .env.bkp || :
	docker-compose exec -T just-test_app_1 cp .env.test .env
	${MAKE} reset-db

run-tests:
	docker-compose exec -T just-test_app_1 ./vendor/bin/phpunit

rollback-envs:
	docker-compose exec -T just-test_app_1 -c "rm .env"
	docker-compose exec -T just-test_app_1 -c "cp .env.bkp .env"
	docker-compose exec -T just-test_app_1 -c "rm .env.bkp"