## Installation

Install docker on your PC and follow next steps:

- clone project from repository
- cd /{app_directory}
- cp .env.example .env
- Configure .env file (DB_HOST=db)
- run <code>docker-compose build app</code>
- start docker app <code>docker-compose up -d</code>
- run composer <code>docker-compose exec app composer install</code>
- run  <code>docker-compose exec app php artisan key:generate</code>
- run <code>docker-compose exec app php artisan migrate</code>
- run <code>docker-compose exec app db:seed</code>

## Success

application available on url [http://localhost:8000] 
