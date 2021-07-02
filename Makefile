init: up composer-install

up:
	docker-compose up -d

composer-install:
	docker-compose run --rm procurement-php-cli composer install

tests:
	docker-compose run --rm procurement-php-cli php bin/phpunit

check: code-check psalm

code-check:
	docker-compose run --rm procurement-php-cli composer cs-check

psalm:
	docker-compose run --rm procurement-php-cli composer psalm

code-fix:
	docker-compose run --rm procurement-php-cli composer cs-fix

cache-clear:
	docker-compose run --rm procurement-php-cli php bin/console cache:clear

migrate:
	docker-compose run --rm procurement-php-cli php bin/console doctrine:migrations:migrate --no-interaction

migrate-rollback:
	docker-compose run --rm procurement-php-cli php bin/console doctrine:migrations:migrate prev

db-diff:
	docker-compose run --rm procurement-php-cli php bin/console doctrine:migrations:diff