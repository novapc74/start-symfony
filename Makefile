init: docker-down \
	docker-pull docker-build docker-up \
	app-composer-install webpack-install yarn-install yarn-dev \
	echo-open-browser
up: docker-up
down: docker-down
restart: down up echo-open-browser
rebuild: down docker-build-no-pull docker-up echo-open-browser

webpack-install:
	docker-compose run --rm php-cli composer require symfony/webpack-encore-bundle

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-pull:
	docker-compose pull

docker-build-no-pull:
	docker-compose build

docker-build:
	docker-compose build --pull

app-php-cli-bash:
	docker-compose run --rm php-cli bash

app-composer-install:
	docker-compose run --rm php-cli composer install

app-migrations:
	docker-compose run --rm php-cli bin/console d:m:m --no-interaction

yarn-install:
	docker-compose run --rm node-cli yarn install

yarn-build:
	docker-compose run --rm node-cli yarn build

yarn-dev:
	docker-compose run --rm node-cli yarn dev

yarn-watch:
	docker-compose run --rm node-cli yarn watch

# make yarn-add PACK='svg-sprite-loader'
yarn-add:
	docker-compose run --rm node-cli yarn add ${PACK}

yarn-remove:
	docker-compose run --rm node-cli yarn remove ${PACK}

# TODO: указать путь до версии PHP на сервере
PROD_PHP = "/opt/php80/bin/php"
# запустить на сервере, чтобы всё обновилось
prod-build: prod-composer-install \
	prod-migrate \
 	prod-yarn-build

prod-composer-install:
	${PROD_PHP} composer.phar install

prod-migrate:
	${PROD_PHP} bin/console d:m:m --no-interaction
	${PROD_PHP} bin/console cache:clear

prod-yarn-build:
	yarn install
	yarn build


#echo-address:
#	echo -en "\n \033[37;1;41m marchellis.local \033[0m"

echo-open-browser:
	xdg-open http://localhost:8055/
