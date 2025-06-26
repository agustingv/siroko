Test carrito de la compra api-platform (Symfony) + nextjs.

## Descripción

El projecto está basado en api-platform en su versión Symfony para montar el api basado en entidades, el sistema genera automáticamente un crud con un apiResource indicado, además se han creado endpoints para añadir y eliminar products al carrito usando un patrón cqrs. Api-platform ya disponde de un pwa en nextjs integrado en el proyecto por lo que se ha aprovechado esa implementación para montar la pagína de producto y carrito de la compra que interactua con el api generado.

## Iniciar projecto

Todas las partes de la aplicación están montadas con docker compose por lo que es necesario disponer de esta herramienta para poder iniciar el project.
Se ha usado la versión v2.27.1 de docker compose en Linux. No se garantiza su correcto funcionamiento en otros SO

* Clona el projecto del repositorio
* Inicia el proyecto con docker compose: docker compose up -d
* Ejecuta el comando para importar los productos de testing: docker compose exec php bin/console import-products --csv=csv/test-products.csv

## Tests

* Crear la base de datos de pruebas: 
** docker compose exec php bin/console doctrine:database:create --env=test
** docker compose exec php bin/console doctrine:schema:create --env=test
* Ejecutar los test
** docker compose exec php bin/phpunit

## Urls

* http://localhost Pagina principal de la plataforma.
* http://localhost/docs Documentación del api.
* http://localhost/admin Administrador de entidades.
* http://localhost/products Pagina de testing del api del carrito de la compra
