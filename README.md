# Test - CodeIgniter 4 | MySQL | ^PHP 7.4 

## Examen técnico Desarrollador Backend:

1. API de Inicio se sesión
2. API de Creación de usuarios
3. API de Consulta de usuarios
4. API de Actualización de usuarios
5. API de Eliminación de usuarios
6. API para la descarga del listado de usuarios

## Descripciones
Se implemento una arquitectura limpia.  
No se hizo el modelado de carpetas de dominio, teniendo en cuenta que existe un solo domonio en el proyecto (**Domain Users**).

Para el manejo de la autenticacion y roles solo se utilizo un modelo usuario y un campo type (**string**) para modelar los roles.
Se pudo utilizar otra entidad Role y relacionarlas para manejar los roles de forma mas profesional, pero al ser un test case, se hizo de la forma mas simple.

Para manejar la cache se uso **Redis**, asi mantenemos un listado de usuarios mucho mas rapido y optimo.

## Instalación

1. Descargue o clone el repositorio.
2. Crear fichero de entorno (.env) a partir del fichero env en la raiz del proyecto.
3. Instalar dependencias `composer install`.
4. Correr migraciones `php spark migration`
5. Correr seeder `php spark db:seed UsersSeeder`

## Postman collection
La collection de postman se encuentra en la ruta raiz de la carpeta `resources` 
<h3>Endpoints Auth</h3>
<p style="color: lightgoldenrodyellow"><strong>POST</strong> auth/login</p>

<h3>Endpoints Users</h3>
<p style="color: darkseagreen"><strong>GET</strong> api/users</p>
<p style="color: darkseagreen"><strong>GET</strong> /api/users-download</p>
<p style="color: lightgoldenrodyellow"><strong>POST</strong> api/users</p>
<p style="color: dodgerblue"><strong>PUT</strong> api/users</p>
<p style="color: indianred"><strong>DELETE</strong> api/users</p>
