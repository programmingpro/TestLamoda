.PHONY: up

up:
	cd localenv && sudo docker compose up -d --build && sudo docker exec localenv-app-1 php bin/console --no-interaction doctrine:migrations:migrate
