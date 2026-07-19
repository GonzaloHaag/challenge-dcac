# Challenge DCAC — Gestión de Productos

API REST en PHP nativo (sin framework) para gestionar un catálogo de productos, con conversión automática de precios de Pesos Argentinos a Dólares usando una variable de entorno, más un frontend en HTML/CSS/JS puro que la consume.

## Stack

El backend es PHP 8.4 nativo, sin framework, servido con el servidor embebido de PHP. La base de datos es MySQL 8.4. El frontend es HTML/CSS/JS puro, sin frameworks ni build step, servido con Nginx. Todo se orquesta con Docker Compose, en tres servicios: app, db y frontend.

## Requisitos previos

Solo hace falta tener Docker y Docker Compose instalados (Docker Compose viene incluido en Docker Desktop, o como `docker compose`/`docker-compose` en Linux). No hace falta tener PHP, MySQL ni Node instalados localmente, todo corre en contenedores.

## 1. Configurar el entorno

El backend y la base de datos leen su configuración de backend/.env. Ese archivo no está en el repo porque está en .gitignore, así que primero hay que crearlo a partir del ejemplo:

```bash
cp backend/.env.example backend/.env
```

Y completarlo con estos valores:

```env
DB_HOST=db
DB_PORT=3306
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=challenge_dcac
MYSQL_USER=user_dcac
MYSQL_PASSWORD=root
PRECIO_USD=1500
```

DB_HOST es el host de MySQL dentro de la red de Docker: hay que dejarlo en db, que es el nombre del servicio en docker-compose.yml, salvo que lo renombres. DB_PORT es el puerto interno de MySQL, se deja en 3306. MYSQL_ROOT_PASSWORD es el password del usuario root que usa el contenedor de db para inicializarse. MYSQL_DATABASE es el nombre de la base que se crea automáticamente al levantar db. MYSQL_USER y MYSQL_PASSWORD son el usuario de aplicación que usa el backend para conectarse, que no es root.

PRECIO_USD es la variable clave del challenge: es la cotización del dólar en pesos argentinos (por ejemplo, 1500 significa que 1 USD equivale a 1500 ARS). La API la usa para calcular precio_usd = precio / PRECIO_USD en cada respuesta. Para actualizar la cotización hay que cambiar este valor y reiniciar el contenedor app.

Si PRECIO_USD queda vacío o en 0, la API responde 400 en todos los endpoints, porque la conversión no es válida con una cotización menor o igual a cero.

## 2. Levantar el proyecto

Desde la raíz del repo:

```bash
docker compose up --build
```

Esto levanta tres contenedores. El servicio app (contenedor dcac-php) expone la API en http://localhost:8080. El servicio frontend (contenedor dcac-frontend) expone la interfaz web en http://localhost:8081. El servicio db (contenedor dcac-mysql) expone MySQL en el puerto 3308 del host, y crea la tabla productos automáticamente en el primer arranque usando database/001_create_productos_table.sql.

Para correrlo en segundo plano se puede agregar -d: `docker compose up --build -d`. Para pararlo, `docker compose down` (agregando -v si además querés borrar los datos de MySQL que quedaron persistidos en el volumen mysql_data).

El backend monta ./backend como volumen dentro del contenedor, así que cualquier cambio en el código PHP se refleja al instante, sin rebuild. Lo mismo pasa con el frontend, porque Nginx sirve directo desde ./frontend.

## 3. Probar la interfaz web

Hay que abrir http://localhost:8081 en el navegador. Desde ahí se puede ver el listado de productos con precio en ARS y en USD, crear un producto nuevo, editar uno existente, y eliminarlo.

## 4. Probar la API directamente

La URL base es http://localhost:8080. Los endpoints disponibles son:

GET /productos lista todos los productos, mostrando precio en ARS y precio_usd calculado.

GET /productos/{id} devuelve el detalle de un producto puntual, o 404 si no existe.

POST /productos crea un producto nuevo. El body va en JSON con nombre, precio y opcionalmente descripcion; nombre y precio son obligatorios.

PUT /productos/{id} actualiza un producto existente, con el mismo formato de body que el POST. Devuelve 404 si el producto no existe.

DELETE /productos/{id} elimina un producto. Devuelve 404 si no existe.

Los errores de validación devuelven 400 con un JSON del tipo { "error": "mensaje" }, y los recursos inexistentes devuelven 404.

Algunos ejemplos con curl:

```bash
# Listar productos
curl http://localhost:8080/productos

# Crear un producto
curl -X POST http://localhost:8080/productos \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Mouse inalámbrico","descripcion":"Mouse óptico USB","precio":15000}'

# Ver un producto mediante su id
curl http://localhost:8080/productos/1

# Actualizar un producto mediante su id
curl -X PUT http://localhost:8080/productos/1 \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Mouse inalámbrico","descripcion":"Actualizado","precio":16000}'

# Eliminar un producto mediante su id
curl -X DELETE http://localhost:8080/productos/1
```


## CORS

El backend solo acepta requests desde http://localhost:3000 y http://localhost:8081 (el frontend servido por Docker). Esto se configura en backend/app/Core/Cors.php. Si servís el frontend desde otro puerto u otro host, hay que agregarlo a esa lista.
