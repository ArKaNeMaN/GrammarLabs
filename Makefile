build:
	@docker build -t arkaneman/grammars -f docker/Dockerfile .

logs:
	@docker-compose logs

up:
	@docker-compose up -d

down:
	@docker-compose down

bash:
	@docker-compose exec web bash
