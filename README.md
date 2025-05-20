## Modelo de Datos
Este proyecto define tres entidades principales:
- **users**: usuarios registrados en la plataforma.
- **categories**: agrupa productos por nombre y descripción.
- **products**: contiene los detalles de cada producto, como nombre, precio, stock, y su relación con una categoría.

### Justificación de Ampliaciones:

- Se añadió la relación `category_id` en productos con `foreign key` para garantizar la integridad referencial.
- Se establecieron defaults y restricciones como:
  - `description` puede ser nulo.
  - `price` se maneja como decimal con precisión de dos decimales.
  - `stock` es obligatorio y no permite valores negativos.
- Las relaciones entre modelos (`hasMany`, `belongsTo`) están definidas para facilitar consultas y controladores más limpios.
- La tabla usuarios se le añade el campo "enable" determinando si el usuario se encuentra activo o inactivo, esta validación se realiza al usar el servicio de iniciar sesión (login)
- El servicio de registro de usuarios realiza dos validaciones principales:
  - Si el usuario está autenticado y tiene el rol admin, podrá registrar usuarios con rol admin o user. ( es decir la autenticación es opcional)
  - Si el usuario tiene el rol user, solo podrá registrar usuarios con el rol user.
  - Si el usuario no está autenticado, el servicio asignará automáticamente el rol 'user' al nuevo registro, asi intente asignar el rol admin.
  - Si se ingresa un valor diferente a user o admin, se toma como rol tipo user.
- En Categorias, no se puede eliminar, si tiene productos asociados.

### Roles y permisos
- Se manejan dos tipos de roles para los usuarios, el rol 'user' y el rol 'admin', cuando uno usuario se registra por medio de la API automaticamente le añade el rol 'user', un usuario con el rol 'admin' puede crear usuarios con cualquiera de los dos roles.

### Validación de datos productos y categorias, editar y crear - Form Request Validation

Se implementaron reglas de validación en el controlador de Products, Categorys y Users bajo el enfoque de Form Request Validation, en donde se hace la separación de la lógica de validacion y autorización de la petición

Se aplica para los metodos de crear y editar de PRODUCTS y CATEGORIES, y al metodo de registrar en USERS, se definen las reglas de validación y para cada una se construye un mensaje que sea más claro en español, ya que por defecto los mensajes de validacón cargan en ingles.

- Explicar el cambio en el middleware autenticate y handler para errores de JSON con el token
- Dar el comando para crear productos y categorias de ejemplo
- revisar como hacer para crear un usuario admin 
- explicar los servicios que tienen paginacion como se accede a la segunda pagian

### Separación de responsabilidades

Se ha aplicado el principio de Separación de Responsabilidades para mantener un código limpio y modular. La validación y autorización de las peticiones se manejan en Form Requests, mientras que los middleware controlan el acceso basado en roles antes de llegar a los controladores. Esto permite que los controladores se enfoquen en la lógica de negocio y deleguen las responsabilidades adicionales a otras capas del sistema, haciendo el código más mantenible y escalable.

### Middleware personalizado (Chain of Responsibility)

Se usaron middleware personalizados para controlar el acceso a las rutas según el rol del usuario. Esta implementación aprovecha el patrón "Chain of Responsibility", permitiendo filtrar las peticiones antes de que lleguen al controlador. No se utilizó el enfoque de policies, ya que este está orientado a aplicaciones más complejas o escenarios donde se requieren validaciones específicas sobre recursos, basadas en las condiciones del modelo o del usuario.

## Colección de Postman
1. Ingresa al siguiente link
2. Acepta la invitación de ingreso y podrá observar y probar la colección configurada y publicada en Railway
https://app.getpostman.com/join-team?invite_code=be9b96a586d874bda20acb4e0e99fffd0b1db0999df3b0f2c58ec07c2c828203&target_code=86aced4236e018c3396446fce47cacd1

### Despliegue:
Se usa Railway para la publicación de la API, se encuentra conectada con Github
La URL pùblica de despliegue es la siguiente:
https://apismartprueba-production-12c9.up.railway.app
Para el uso de la API, por ejemplo la URL del login seria:
https://apismartprueba-production-12c9.up.railway.app/api/user/login
TIPO POST
JSON:
{
  "email": "admin@smart_talent.co",
  "password": "admin123"
}

- Se implementan Factories y Seeders para las tablas de products categories y users, con el objetivo de poblarlas con datos de prueba, para crearlos se usaron los siguientes comandos:
php artisan make:seeder DatabaseSeeder
php artisan make:seeder UserSeeder

Este comando creará 5 categorías y por cada categoría crea 3 productos.
Crea un usuario por defecto tipo admin con las siguientes credenciales:
  - Usuario:  admin@smart_talent.co,
  - Contraseña: admin123

## Pasos para desgpliegue local.
1. Clonar o descomprimir el proyecto
Git clone https://github.com/montesbetancurvladimir/API_SMART_PRUEBA.git

2.  Instalar dependencias con Composer 
composer install

3. Copiar el archivo .env del ejemplo
cp .env.example .env

4. Crear la base de datos (MySQL) crea una nueva base de datos con el nombre BD_API_SMART

5. Realizar la migración
php artisan key:generate
Php artisan migrate

6. Ejecutar el seeder
php artisan db:seed

7. Levantar el servidor local
php artisan serve

Variables de entorno:
Se puede usar el archivo .env por defecto que genera Laravel al crear un proyecto, para un despliegue local solo se debe modificar la sección de conexión a la base de datos.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=BD_API_SMART
DB_USERNAME=root
DB_PASSWORD=

El proyecto usa Sanctum como método de autenticación, se ejecutó el siguiente comando:
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
NOTA: No es necesario ejecutarlo de nuevo ya que los archivos de las migraciones ya se encuentran en la carpeta.




