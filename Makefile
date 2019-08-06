.DEFAULT_GOAL := help

HOST ?= 0.0.0.0

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

##
## Setup
## -----
##

install: .env.local up update fixtures info ## Install and start development environment

start: .env.local up info ## Start development environment

.env.local: .env
	@if [ -f .env.local ]; then \
		echo '\033[1;41mYour .env.local file may be outdated because .env has changed.\033[0m';\
		echo '\033[1;41mCheck your .env.local file, or run this command again to ignore.\033[0m';\
		touch .env.local;\
		exit 1;\
	else\
		echo cp .env .env.local;\
		cp .env .env.local;\
	fi

update: up ## Update project after branche switch
	docker-compose run composer install
	docker-compose exec php bash -c "php bin/console doctrine:schema:update --force"

up: ## Run containers
	docker-compose up -d

.PHONY: fixtures
fixtures: ## Install fixtures
		docker-compose exec php bash -c "bin/console hautelook:fixtures:load --no-interaction"

##
## Tests
## -----
##

test: phpunit ## Run all tests stack

phpunit: ## Run unit tests
	docker-compose run composer ./vendor/bin/simple-phpunit

##
## Tools
## -----
##

cc: ## Clear cache
	docker-compose exec php bash -c "php bin/console cache:clear"

logs: ## Show logs
	docker-compose logs -ft

bash: ## Bash into php container
	docker-compose up -d php
	docker-compose exec php bash

node: ## Bash into node container
	docker-compose up -d node
	docker-compose exec node bash

info: ## Show useful urls
	@echo ""
	@echo "\033[92m[OK] Application running on http://$(HOST):8080\033[0m"
	@echo "\033[92m[OK] Database explorer running on http://$(HOST):8081/?server=mariadb&username=docker&db=docker (password: s3cr3t)\033[0m"
	@echo ""

##
