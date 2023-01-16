build:
	docker build --tag php:morphos tests/

test:
	docker run --rm --interactive --tty --volume $(PWD):/app -w /app -e XDEBUG_MODE=coverage --add-host=host.docker.internal:host-gateway php:morphos ./vendor/bin/phpunit --coverage-text

run:
	docker run --rm --interactive --tty --volume $(PWD):/app -w /app --add-host=host.docker.internal:host-gateway php:morphos bash

php:
	docker run --rm --interactive --tty --volume $(PWD):/app -w /app --add-host=host.docker.internal:host-gateway php:morphos php -a
