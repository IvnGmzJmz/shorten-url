# shorten-url

Esta aplicación permite al usuario acortar sus URLs y mantener un registro de ellas.
Esta formada por un frontend en VUE y un backend con Laravel, con base de dates MySQL.

La URL una vez ejecutado el docker es: localhost:8080

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

## Apartados de mejora

- Feedback en los formularios: Los formularios no retornan feedback, tendrían que ser capaces de marcar cual de los campos está mal y el motivo.
- Analítica del link: El número de visitas del link no se actualiza sólo, hace falta refrescar la página o realizar otra acción como editar o añadir un link para ver el cambio reflejado.
- Añadir test a VUE: Los test estan únicamente para la parte del backend, hubiese sido interesante poder hacerlos para la del frontend.
- Seguridad de la aplicación: La aplicación no contiene políticas de privacidad más allá de las relacionadas con la autentificación del usuario.

## Posibles futuros desarrollos
- Has olvidado la contraseña? Y autentificación en dos pasos.
- Posibilidad de ver el perfil, editarlo y ver estadísticas generales de tus links.
- Posibilidad de filtrar links, reordenar o destacar.
- Algún tipo de integración a la hora de compartir: poder compartir el link por Whatsapp, Facebook, Instagram ...
