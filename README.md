# shorten-url

Esta aplicación permite al usuario acortar sus URLs y mantener un registro de ellas.

## Guía de instalación:

- Clonar del repositorio
- Completar el .env (para nuestro proposito vale con el mismo contenido que el .env.example)

Antes de levantar el contenedor hay que asegurarse que los puertos que va a utilizar estan disponibles (81 y 3306).

- `docker-compose build`
- `docker-compose up -d`

- `docker-compose exec app composer install`

El composer install ejecutará tambien todas las migraciones y todo lo necesario para iniciar la aplicación.

Si se requiere de ejecutar migraciones o cualquier interacción con el backend:

- `docker-compose exec app php artisan migrate`

Finalmente, para ejecutar los tests:

- `docker-compose exec app php artisan test`