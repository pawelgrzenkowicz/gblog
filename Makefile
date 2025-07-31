.ONESHELL:
.PHONY:
.SILENT:

define COMPOSE
	docker compose --env-file=.env.local
endef

#define COMPOSE_EXEC
#	$(COMPOSE) exec --user=${LOCAL_UID}:${LOCAL_GID}
#endef

#-----------------------------------------------------------------------------------------------------------------------

build:
	$(COMPOSE) build

down:
	$(COMPOSE) down --remove-orphans

ps:
	$(COMPOSE) ps

purge:
	$(COMPOSE) down --remove-orphans --volumes

stop:
	$(COMPOSE) stop

up:
	$(COMPOSE) up --detach

#-----------------------------------------------------------------------------------------------------------------------

api-tests: up
	$(COMPOSE) exec php_server bash -c 'bin/api-tests'

functional-tests: up
	$(COMPOSE) exec php_server bash -c 'bin/functional-tests'

infection:
	$(COMPOSE) exec php_server bash -c 'bin/infection'

php: up
	$(COMPOSE) exec php_server bash

php-restart:
	$(COMPOSE) restart php_server

php-root: up
	$(COMPOSE) exec --user=0:0 php_server bash

phpunit: up
	$(COMPOSE) exec php_server bash -c 'bin/phpunit --no-coverage'

phpunit-coverage: up
	$(COMPOSE) exec php_server bash -c 'XDEBUG_MODE=coverage bin/phpunit'

#-----------------------------------------------------------------------------------------------------------------------


node:
	$(COMPOSE) exec node sh

node-root:
	$(COMPOSE) exec --user=0:0 node sh

node-logs:
	$(COMPOSE) logs --follow node

node-restart:
	$(COMPOSE) restart node

node-watch:
	#$(COMPOSE) exec node npm run watch
	$(COMPOSE) exec node npm run dev

#-----------------------------------------------------------------------------------------------------------------------

setup: up
	$(COMPOSE) exec php_server bash -c 'bin/setup'
