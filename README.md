# MONOMA-TEST
- Laravel 10
- Laravel sail
- ./vendor/bin/sail up
- Redis

## Instalación
La prueba consiste en desarrollar una API Rest con 4 endpoints utilizando Laravel 9 o 10, MySQL para la base de datos y Redis para caché. JWT será usado para la autenticación.

## Configuración
La prueba consiste en desarrollar una API Rest con 4 endpoints utilizando Laravel 9 o 10, MySQL para la base de datos y Redis para caché. JWT será usado para la autenticación.

***
## Documentación APIS

### 1. /auth (Generar token)

**Body:**
```json
{
  "username": "tester",
  "password": "PASSWORD"
}
```
**200:**
```json
{
    "meta": { "success":
        true,"errors": []
    },
    "data": {
        "token": "TOOOOOKEN",
        "minutes_to_expire": 1440
    }
}
```
**401:**
```json
{
    "meta": { "success":
      false,"errors": [
        "Password incorrect for: tester"
      ]
    }
}
```
***
### 2. /lead (Crear candidato)
**Body:**
```json
{
    "name": "Mi candidato",
    "source": "Fotocasa",
    "owner": 2
}
```
**200:**
```json
{
    "meta": { "success": true, "errors": [] },
    "data": {
        "id": "1",
        "name": "Mi candidato",
        "source": "Fotocasa",
        "owner": 2,
        "created_at": "2020-09-01 16:16:16",
        "created_by": 1
    }
}
```
**401:**
```json
{
    "meta": { "success": false, "errors": ["Token expired"] }
}
```
***
### 3. /lead/{id} (Detalle candidato)
**200:**
```json
{
    "meta": { "success": true, "errors": [] },
    "data": {
        "id": "1",
        "name": "Mi candidato",
        "source": "Fotocasa",
        "owner": 2,
        "created_at": "2020-09-01 16:16:16",
        "created_by": 1
    }
}
```
**401:**
```json
{
    "meta": { "success": false, "errors": ["Token expired"] }
}
```
**404:**
```json
{
    "meta": { "success": false, "errors": ["No lead found"] }
}
```
***
### 4. /leads (Listar candidatos)
**200:**
```json
{
    "meta": { "success": true, "errors": [] },
    "data": [
        {
            "id": "1",
            "name": "Mi candidato",
            "source": "Fotocasa",
            "owner": 2,
            "created_at": "2020-09-01 16:16:16",
            "created_by": 1
        },
        {
            "id": "2",
            "name": "Mi candidato 2",
            "source": "Habitaclia",
            "owner": 2,
            "created_at": "2020-09-01 16:16:16",
            "created_by": 1
        }
    ]
}

```
**401:**
```json
{
    "meta": { "success": false, "errors": ["Token expired"] }
}
```

### Modelo de datos:
**Usuario:**
```json
{
    "id": "1",
    "username": "tester",
    "password": "PASSWORD",
    "last_login": "2020-09-01 16:16:16",
    "is_active": true,
    "role": "manager" //manager o agent
}
```
**Candidato:**
```json
{
"id": "1",
"name": "Mi candidato",
"source": "Fotocasa",
"owner": 2, //Id usuario responsable
"created_at": "2020-09-01 16:16:16",
"created_by": 1 //Id usuario que ha creado el candidato
}
```
