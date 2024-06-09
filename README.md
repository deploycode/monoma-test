## Instalación vía Laravel Sail (Requiere docker)

```text
git clone git@github.com:deploycode/monoma-test.git
```
```text
cd monoma-test/
```
```text
cp .env.example .env
```
```text
docker compose up -d
```
```text
docker exec -it monoma-test-laravel.test-1 bash
```
```text
composer install
```
```text
php artisan key:generate
```
```text
php artisan jwt:secret
```
```text
php artisan migrate
```
```text
php artisan db:seed
```

## Instalación vía composer
#### Requiere php >= 8.1, composer, mysql y redis

***
## Documentación APIS
### A partir de la API #2 Requiere remplazar el Bearer XXXXX

### 1. GENERAR TOKEN 
```text
curl --location --request POST 'http://0.0.0.0/api/auth' \
--form 'username="manager"' \
--form 'password="PASSWORD"'
```

```text
curl --location --request POST 'http://0.0.0.0/api/auth' \
--form 'username="agent1"' \
--form 'password="PASSWORD"'
```

***
### 2. CREAR CANDIDATO

```text
curl --location --request POST 'http://0.0.0.0/api/lead' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer XXXXX' \
--data '{
    "name": "Mr Robot",
    "source": "US",
    "owner": 1
}'
```

***
### 3. DETALLE CANDIDATO
```text
curl --location --request GET 'http://0.0.0.0/api/lead/1' \
--header 'Authorization: Bearer XXXXXX'
```
***
### 4. LISTAR CANDIDATOS

```text
curl --location --request GET 'http://0.0.0.0/api/lead' \
--header 'Authorization: Bearer XXXXX'
```
## TEST
Ingresar al contenedor laravel
```text
docker exec -it monoma-test-laravel.test-1 bash
```
```text
php artisan test --coverage
```
### Generar informe completo en HTML en directorio reports
```text
vendor/bin/phpunit --coverage-html reports/
```
