# Proyecto Final — OdooTech S.A.S
# Manual de instalación y uso

Este manual explica paso a paso cómo instalar, configurar y usar toda la infraestructura del proyecto desde cero.

---

## Antes de empezar — ¿Qué necesito hacer?

Si es la primera vez que levantas el proyecto o lo descargaste en una PC nueva, sigue todo el manual desde el paso 1 hasta el paso 6.

Si solo quieres volver a levantarlo en la misma PC donde ya lo configuraste, ejecuta únicamente:


```
cd /home/Odoo-Docker
docker compose up -d
```´
### NOTA: Al copiar los comandos, omitir copiar las comillas ```

Luego abre `http://localhost:8069` y listo.

---

## Requisitos previos

Antes de comenzar necesitas tener instalado en tu computador:

| Requisito      | Cómo verificar |
|-----------     |----------------|
| Windows 10/11  | -                              |
| WSL2           | `wsl --version` en PowerShell  |
| Docker Desktop | `docker --version` en terminal |
| Git            | `git --version` en terminal    |

---

## Estructura del proyecto

```
Odoo-Docker/
├── docker-compose.yml      <- Archivo base donde se gestionan todo los servicios y la red interna
├── odoo.conf               <- Configuración de Odoo
├── README.md               <- Manual
├── web/
│   ├── Dockerfile          <- Construye el contenedor PHP
│   ├── config_ldap.php     <- Configuración de conexión LDAP
│   ├── index.html          <- Formulario de login
│   └── login.php           <- Lógica de autenticación
├── ldap/
│   ├── estructura_odoo.ldif  <- Crea las OUs (departamentos)
│   ├── grupos_odoo.ldif      <- Crea los grupos
│   ├── usuarios_odoo.ldif    <- Crea los usuarios
└── docs/                     <- documentación adicional
```


---

## Paso 1 — Preparar el entorno
*Obligatorio: primera vez y PC nueva*

### Paso 1.1 — Abrir WSL

1. Presiona `Windows + R`
2. Escribe `powershell` y presiona Enter
3. En PowerShell escribe:

```
wsl -d mi_proyecto
```

Si no tienes la distribución `mi_proyecto`, usa simplemente `wsl` para entrar a Ubuntu.

### Paso 1.2 — Clonar el repositorio

```
cd /home
git clone https://github.com/TU_USUARIO/proyecto-final-odoo.git Odoo-Docker
cd Odoo-Docker
```

### Paso 1.3 — Verificar que Docker está funcionando

```
docker --version
docker compose version
```

Debe mostrar algo como:
```
Docker version 24.x.x
Docker Compose version v2.x.x
```

---

## Paso 2 — Levantar los contenedores
*Obligatorio: primera vez, PC nueva y cada vez que reinicias*

### Paso 2.1 — Construir e iniciar todos los servicios

```
cd /home/Odoo-Docker
docker compose up -d --build
```

La primera vez tarda 3-5 minutos porque descarga todas las imágenes. Las siguientes veces tarda menos de 30 segundos.

### Paso 2.2 — Verificar que todos los contenedores están corriendo

```
docker ps
```

Debes ver 7 contenedores con estado `Up`:

```
CONTAINER ID   NAME            STATUS
xxxxxxxxxxxx   odoo_app        Up
xxxxxxxxxxxx   odoo_db         Up
xxxxxxxxxxxx   ldap_server     Up
xxxxxxxxxxxx   phpldapadmin    Up
xxxxxxxxxxxx   web_app         Up
xxxxxxxxxxxx   portainer       Up
xxxxxxxxxxxx   dozzle          Up
```

Si algún contenedor no aparece ejecuta `docker logs NOMBRE_CONTENEDOR` para ver qué pasó.

### Paso 2.3 — Verificar la red Docker

```
docker network ls
```

Debe aparecer `odoo-docker_odoo_network` con driver `bridge`.

```
docker network inspect odoo-docker_odoo_network
```

Este comando muestra todos los contenedores conectados a la red.

---

## Parte 3 — Servicios disponibles

| Servicio      | URL                   | Usuario                  | Contraseña        |
|---------------|-----------------------|--------------------------|------------------ |
| Odoo 17       | http://localhost:8069 | admin                    | admin             |
| App PHP Login | http://localhost:8083 | juan                     | juan123           |
| phpLDAPadmin  | http://localhost:8090 | cn=admin,dc=odoo,dc=odoo | admin123          |
| Portainer     | http://localhost:9000 | admin                    | (crear al entrar) |
| Dozzle        | http://localhost:8888 | sin login                | ------------------|

---

## Paso 4 — Configurar LDAP
*Obligatorio solo en estos casos: primera vez, PC nueva o si ejecutaste `docker compose down -v`.*
*No es necesario si solo reiniciaste o hiciste `docker compose down` sin `-v`.*

### Paso 4.1 — Copiar los archivos LDAP al contenedor

```
cd /home/Odoo-Docker

docker cp ldap/estructura_odoo.ldif ldap_server:/tmp/
docker cp ldap/grupos_odoo.ldif     ldap_server:/tmp/
docker cp ldap/usuarios_odoo.ldif   ldap_server:/tmp/
```

### Paso 4.2 — Cargar la estructura en este orden exacto

```
# 1. Primero las OUs (departamentos)
docker exec ldap_server ldapadd -x \
  -D "cn=admin,dc=odoo,dc=odoo" -w admin123 \
  -f /tmp/estructura_odoo.ldif

# 2. Luego los grupos
docker exec ldap_server ldapadd -x \
  -D "cn=admin,dc=odoo,dc=odoo" -w admin123 \
  -f /tmp/grupos_odoo.ldif

# 3. Finalmente los usuarios
docker exec ldap_server ldapadd -x \
  -D "cn=admin,dc=odoo,dc=odoo" -w admin123 \
  -f /tmp/usuarios_odoo.ldif
```

Cada comando debe responder con líneas como:
```
adding new entry "ou=Odoo,dc=odoo,dc=odoo"
adding new entry "ou=Calidad,dc=odoo,dc=odoo"
```

### Paso 4.3 — Verificar que los usuarios se cargaron

```
docker exec ldap_server ldapsearch -x \
  -D "cn=admin,dc=odoo,dc=odoo" -w admin123 \
  -b "dc=odoo,dc=odoo" "(uid=*)" uid
```

Debe mostrar `uid: juan` y `uid: zora`.

---

## Paso 5 — Probar el login LDAP (App PHP)

### Paso 5.1 — Abrir la aplicación web

Abre el navegador y ve a `http://localhost:8083`. Verás el formulario de login.

### Paso 5.2 — Iniciar sesión

Prueba con estos usuarios:

| Usuario | Contraseña | Area esperada |
|---------|------------|---------------|
| juan    | juan123    | Odoo          |
| zora    | zora123    | Odoo          |

### Paso 5.3 — Resultado esperado

Si el login es exitoso verás un mensaje similar a:
```
Bienvenido, juan
Area: Odoo
Autenticación exitosa · Dominio: dc=odoo,dc=odoo
```

---

## Paso 6 — Configurar Odoo 17
*Obligatorio solo en estos casos: primera vez, PC nueva o si ejecutaste `docker compose down -v`.*
*No es necesario si solo reiniciaste — Odoo recuerda todo.*

### Paso 6.1 — Crear la base de datos

Abre `http://localhost:8069`. Verás un formulario de creación de base de datos. Rellena así:

| Campo           | Valor |
|-----------------|---------------------------------------------------|
| Master Password | el que genera Odoo o tu propia contraseña, anotala|
| Database Name   | odoo                                              |
| Email           | tu correo                                         |
| Password        | admin                                             |
| Language        | Spanish (CO)                                      |
| Country         | Colombia                                          | 
| Demo Data       | NO marcar                                         |

## NOTA: Estos datos del formulario son basicos, puedes cambiarlos a tu gusto

Haz clic en Create database y espera 2-3 minutos.

### Paso 6.2 — Inicializar módulos
*Obligatorio solo la primera vez o tras `docker compose down -v`. No repetir si ya lo hiciste antes.*

```
docker exec -it odoo_app odoo \
  -d odoo \
  -i base,web,mail,auth_ldap \
  --stop-after-init

docker restart odoo_app
```

Espera 30 segundos y recarga `http://localhost:8069`.

### Paso 6.3 — Conectar Odoo con LDAP

1. Entra a `http://localhost:8069` con `admin` / `admin`
2. Ve a `http://localhost:8069/web?debug=1`
3. Ve a Ajustes → Técnico → Seguridad → Autenticación LDAP
4. Haz clic en Crear y rellena así:

| Campo                   | Valor                    |
|-------------------------|--------------------------|
| Dirección servidor LDAP | ldap                     |
| Puerto                  | 389                      |
| Usar TLS                | No Marcar                |
| bindDN de LDAP          | cn=admin,dc=odoo,dc=odoo |
| Contraseña LDAP         | admin123                 |
| Base LDAP               | dc=odoo,dc=odoo          |
| Filtro LDAP             | (uid=%s)                 |
| Crear usuario           | Si                       |

5. Haz clic en Guardar.

Nota importante: en el campo de dirección debes escribir `ldap` y no `127.0.0.1`. En Docker cada contenedor es una máquina independiente — si usas `127.0.0.1` Odoo buscaría el LDAP dentro de su propio contenedor donde no existe.

---

## Paso 7 — Gestión de base de datos Odoo

Puedes acceder al gestor de bases de datos en:

```
http://localhost:8069/web/database/manager
```

Desde ahí puedes hacer backup, restaurar o eliminar la base de datos.

---

## Paso 8 — Monitoreo con Portainer
*El primer acceso requiere crear un usuario. Tienes 5 minutos para hacerlo antes de que expire.*

1. Abre `http://localhost:9000`
2. Crea el usuario admin con la contraseña que prefieras
3. Haz clic en Create user y luego en Get Started

Si la pantalla muestra timeout, ejecuta `docker restart portainer` e intenta de nuevo.

Desde Portainer puedes ver los 7 contenedores corriendo, la red `odoo_network`, los volúmenes con los datos persistentes y el consumo de CPU y memoria en tiempo real.

---

## Paso 9 — Ver logs con Dozzle

Abre `http://localhost:8888`. No requiere login. Verás todos los contenedores listados y puedes hacer clic en cualquiera para ver sus logs en tiempo real.

---

## Paso 10 — phpLDAPadmin

1. Abre `http://localhost:8090`
2. Haz clic en login en el panel izquierdo
3. Escribe en Login DN: `cn=admin,dc=odoo,dc=odoo`
4. Escribe la contraseña: `admin123`
5. Haz clic en Authenticate

Verás la estructura LDAP en forma de árbol:
```
dc=odoo,dc=odoo
├── ou=Odoo
│   ├── cn=odoo_admins
│   ├── cn=odoo_users
│   ├── uid=juan
│   └── uid=zora
├── ou=Calidad
└── ou=Marketing
```

---

## Paso 11 — Comandos útiles

```
# Ver todos los contenedores
docker ps

# Ver logs de un contenedor
docker logs odoo_app
docker logs ldap_server
docker logs web_app

# Reiniciar un contenedor
docker restart odoo_app

# Detener todo sin borrar datos
docker compose down

# Levantar todo sin perder datos
docker compose up -d

# Reset completo — borra todos los datos
# Despues necesitas repetir las Partes 4 y 6
docker compose down -v
docker compose up -d --build
```

---

### Odoo (puerto 8069)
| Usuario | Contraseña| Rol           |
|---------|-----------|---------------|
| admin   | admin     | Administrador |

### phpLDAPadmin (puerto 8090)
| DN                       | Contraseña |
|--------------------------|------------|
| cn=admin,dc=odoo,dc=odoo | admin123   |

---


## Informacion del proyecto

- Empresa: OdooTech S.A.S
- Dominio LDAP: dc=odoo,dc=odoo
- Red Docker: odoo_network
- Autores: Juan Steban Restrepo Correa y Zorally Echavarria Lopez
