PROJECT_NAME=billing-system

SAIL=./vendor/bin/sail

.PHONY: setup install up migrate seed build dev down restart logs

setup: install up key migrate seed build
	@echo "Application ready at http://localhost"

install:
	cp -n .env.example .env || true
	docker run --rm \
	-u "$(shell id -u):$(shell id -g)" \
	-v $(shell pwd):/var/www/html \
	-w /var/www/html \
	laravelsail/php84-composer:latest \
	composer install

up:
	$(SAIL) up -d

down:
	$(SAIL) down

restart:
	$(SAIL) down
	$(SAIL) up -d

key:
	$(SAIL) artisan key:generate

migrate:
	$(SAIL) artisan migrate --seed

migrate-fresh:
	$(SAIL) artisan migrate:fresh --seed

migrate-clean:
	$(SAIL) artisan migrate:fresh
	$(SAIL) artisan db:seed --class=BaseSeeder

seed:
	$(SAIL) artisan db:seed --class=ProductSeeder

build:
	$(SAIL) npm install
	$(SAIL) npm run build

dev:
	$(SAIL) npm run dev

logs:
	$(SAIL) logs -f
