include .env
export

docker_compose := $(shell command -v docker-compose -f docker-compose.yml -p se 2> /dev/null)

# Поднимает докер
up:
	$(docker_compose) up -d

# Выключает докер
down:
	$(docker_compose) down

# Перезапускает докер
restart:
	$(docker_compose) down
	$(docker_compose) up -d

# composer install
install:
	./docker/cli/composer install

check-code:
	@./docker/cli/phpstan analyze -c phpstan.neon
	@./docker/cli/phpcs
	@./docker/cli/phpmd src,tests ansi phpmd-rulesets.xml
