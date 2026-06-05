# Proyecto Final — OdooTech S.A.S
## Manual de instalación y uso

Este manual explica paso a paso cómo instalar, configurar y usar toda la infraestructura del proyecto desde cero.

IMPORTANTE: cada comando que aparece en un recuadro gris es UN solo comando. Cópialos y ejecútalos de UNO EN UNO, presionando Enter después de cada uno. No copies varios comandos juntos porque la terminal dará error.

---

## Parte 0 — Requisitos previos

Antes de comenzar necesitas tener instalado en tu computador WSL2, Docker Desktop y Git. A continuación se explica cómo verificar si ya los tienes y cómo instalarlos en caso de que falten.

### Paso 0.1 — Abrir PowerShell

PowerShell es la terminal de Windows. La usarás para verificar e instalar los programas.

1. Presiona la tecla Windows (la que tiene el logo de Windows en el teclado).
2. Escribe la palabra `powershell`.
3. En los resultados aparecerá "Windows PowerShell". Haz clic sobre él.
4. Se abrirá una ventana de fondo azul oscuro o negro. Esa es la terminal.

### Paso 0.2 — Verificar qué tienes instalado

En la ventana de PowerShell escribe estos comandos uno por uno, presionando Enter después de cada uno:

```
wsl --version
```

```
docker --version
```

```
git --version
```

Si alguno responde con un número de versión, ya lo tienes instalado. Si responde con un error tipo "no se reconoce el comando", debes instalarlo siguiendo las instrucciones de abajo.

### Paso 0.3 — Instalar WSL2

WSL2 (Windows Subsystem for Linux) permite ejecutar Linux dentro de Windows.

1. Cierra la ventana de PowerShell actual.
2. Presiona la tecla Windows y escribe `powershell` de nuevo.
3. Esta vez NO hagas clic normal. Haz clic derecho sobre "Windows PowerShell" y elige la opción "Ejecutar como administrador".
4. Si aparece una ventana preguntando si permites cambios, haz clic en Sí.
5. En la ventana de administrador escribe este comando y presiona Enter:

```
wsl --install
```

Esto instala WSL2 junto con Ubuntu automáticamente. El proceso descarga varios archivos, puede tardar varios minutos.

6. Cuando termine, reinicia el computador.
7. Al volver a encender, se abrirá automáticamente una ventana de Ubuntu que te pedirá crear un nombre de usuario y una contraseña. Escríbelos y ANÓTALOS en algún lugar, porque los necesitarás más adelante. Nota: al escribir la contraseña no se ve nada en pantalla, es normal, sigue escribiendo y presiona Enter.

Para verificar que quedó bien instalado, abre PowerShell de nuevo y ejecuta:

```
wsl --version
```

### Paso 0.4 — Instalar Docker Desktop

Docker Desktop es el programa que ejecuta los contenedores del proyecto.

1. Abre tu navegador y entra a la página oficial: https://www.docker.com/products/docker-desktop
2. Haz clic en el botón de descarga para Windows (Download for Windows).
3. Cuando termine la descarga, ejecuta el archivo instalador (se llama algo como "Docker Desktop Installer.exe").
4. Durante la instalación, asegúrate de dejar marcada la casilla que dice "Use WSL 2 instead of Hyper-V".
5. Haz clic en Ok o Install y espera a que termine.
6. Reinicia el computador cuando lo pida.
7. Después de reiniciar, abre Docker Desktop (búscalo presionando la tecla Windows y escribiendo "docker").
8. Espera a que el ícono de la ballena en la barra de tareas (abajo a la derecha, cerca del reloj) deje de moverse o cambiar de color. Cuando está quieto, significa que Docker ya está listo.

Para verificar que quedó bien instalado, abre PowerShell y ejecuta:

```
docker --version
```

IMPORTANTE: Docker Desktop debe estar ABIERTO y corriendo siempre que uses el proyecto. Si lo cierras, los contenedores se detienen y nada funcionará.

### Paso 0.5 — Instalar Git

Git se usa para descargar (clonar) el repositorio del proyecto desde GitHub.

Lo más fácil es instalarlo dentro de WSL. Primero entra a WSL (esto se explica con más detalle en el Paso 0.6 de abajo). Una vez dentro de WSL, ejecuta estos dos comandos uno por uno:

```
sudo apt update
```

Nota: al ejecutar comandos con `sudo` te pedirá la contraseña que creaste para Ubuntu. Escríbela (no se verá en pantalla) y presiona Enter.

```
sudo apt install git -y
```

Para verificar que quedó bien instalado, ejecuta:

```
git --version
```

### Paso 0.6 — Cómo entrar a WSL (Ubuntu)

Cada vez que el manual diga "entra a WSL" o "abre WSL", haz lo siguiente:

1. Presiona la tecla Windows.
2. Escribe `powershell` y presiona Enter para abrir PowerShell.
3. Dentro de PowerShell escribe este comando y presiona Enter:

```
wsl
```

4. Notarás que el texto del comienzo de la línea cambia. Antes decía algo como `PS C:\Users\...` y ahora dirá algo como `usuario@PC:~$`. 
Eso significa que ya estás dentro de Linux (Ubuntu).

Otra forma más directa: presiona la tecla Windows, escribe `ubuntu` y haz clic en la aplicación Ubuntu que aparece. Esto te lleva directo al entorno Linux.

### Resumen de verificación rápida

| Requisito      | Cómo verificar     | Cómo instalar si falta                  |
|----------------|--------------------|-----------------------------------------|
| Windows 10/11  | Ya lo tienes       |-----------------------------------------|
| WSL2           | `wsl --version`    | `wsl --install` como administrador      |
| Docker Desktop | `docker --version` | Descargar de docker.com                 |
| Git            | `git --version`    | `sudo apt install git -y` dentro de WSL |

---

## Parte 1 — Preparar la carpeta y clonar el proyecto
(Obligatorio: primera vez y PC nueva)

### Paso 1.1 — Entrar a WSL

Sigue lo explicado en el Paso 0.6: abre PowerShell, escribe `wsl` y presiona Enter. Debes ver que la línea cambia a algo como `usuario@PC:~$`.

### Paso 1.2 — Crear la carpeta del proyecto

Ahora vas a ir a la carpeta /home, crear ahí una carpeta para el proyecto y entrar a ella. 
Ejecuta estos comandos uno por uno, presionando Enter después de cada uno.

Comando 1 — ir a la carpeta home:
```
cd /home
```

Comando 2 — crear la carpeta del proyecto:
```
mkdir Odoo-Docker
```

Comando 3 — entrar a la carpeta que acabas de crear:
```
cd Odoo-Docker
```

### Paso 1.3 — Clonar el repositorio dentro de la carpeta

Para confirmar que estás dentro de la carpeta correcta, ejecuta este comando (presiona Enter después):

```
pwd
```

Debe mostrar: /home/Odoo-Docker

Ahora clona el contenido del repositorio dentro de esta carpeta. El punto al final es importante, indica que clone aquí mismo (presiona Enter después):

```
git clone https://github.com/JuanRestCor/Proyecto-Final-Odoo.git .
```

NOTA: el punto al final del comando NO es un error. Significa "clonar dentro de la carpeta actual" en vez de crear una subcarpeta nueva.

Para confirmar que se descargó todo, ejecuta este comando que lista los archivos:

```
ls
```

Debes ver: docker-compose.yml, odoo.conf, README.md, y las carpetas web, ldap y docs.

### Paso 1.4 — Verificar que Docker está funcionando

Asegúrate de que Docker Desktop está abierto. Luego ejecuta este comando primero (presiona Enter después):

```
docker --version
```

Luego ejecuta este otro comando (presiona Enter después):

```
docker compose version
```

Debe mostrar algo como:
```
Docker version 24.x.x
Docker Compose version v2.x.x
```

---

## Parte 2 — Levantar los contenedores
(Obligatorio: primera vez, PC nueva y cada vez que reinicias)

### Paso 2.1 — Construir e iniciar todos los servicios

Asegúrate de estar dentro de la carpeta del proyecto. Ejecuta este comando primero (presiona Enter después):

```
cd /home/Odoo-Docker
```

Luego ejecuta este comando para levantar todo (presiona Enter después):

```
docker compose up -d --build
```

La primera vez tarda 3 a 5 minutos porque descarga todas las imágenes. Las siguientes veces tarda menos de 30 segundos.

### Paso 2.2 — Verificar que todos los contenedores están corriendo

IMPORTANTE: este comando se escribe todo en minúsculas. Linux distingue entre mayúsculas y minúsculas, así que NO escribas "Docker PS", debe ser "docker ps". Ejecútalo y presiona Enter:

```
docker ps
```

Debes ver 7 contenedores con estado Up:

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

Si algún contenedor no aparece, ejecuta este comando reemplazando NOMBRE por el nombre del contenedor que falla:

```
docker logs NOMBRE
```

### Paso 2.3 — Verificar la red Docker

Ejecuta este comando (presiona Enter después):

```
docker network ls
```

Debe aparecer una red llamada `odoo-docker_odoo_network` con driver `bridge`.

Si quieres ver los contenedores conectados a esa red, ejecuta este comando:

```
docker network inspect odoo-docker_odoo_network
```

---

## Parte 3 — Servicios disponibles

Una vez que todo está corriendo, puedes acceder a estos servicios desde el navegador:

| Servicio      | URL                   | Usuario                  | Contraseña       |
|---------------|-----------------------|--------------------------|------------------|
| Odoo 17       | http://localhost:8069 | admin                    | admin            |
| App PHP Login | http://localhost:8083 | juan                     | juan123          |
| phpLDAPadmin  | http://localhost:8090 | cn=admin,dc=odoo,dc=odoo | admin123         |
| Portainer     | http://localhost:9000 | admin                    | (crear al entrar)|
| Dozzle        | http://localhost:8888 | sin login                |------------------|

---

## Parte 4 — Configurar LDAP
(Obligatorio solo la primera vez, en PC nueva, o si ejecutaste `docker compose down -v`)
(NO es necesario si solo reiniciaste o hiciste `docker compose down` sin la `-v`)

### Paso 4.1 — Copiar los archivos LDAP al contenedor

Asegúrate de estar en la carpeta del proyecto. Ejecuta este comando primero (presiona Enter después):

```
cd /home/Odoo-Docker
```

Ahora copia los tres archivos. Son TRES comandos separados, ejecútalos uno por uno presionando Enter después de cada uno:

Comando 1:
```
docker cp ldap/estructura_odoo.ldif ldap_server:/tmp/
```

Comando 2:
```
docker cp ldap/grupos_odoo.ldif ldap_server:/tmp/
```

Comando 3:
```
docker cp ldap/usuarios_odoo.ldif ldap_server:/tmp/
```

### Paso 4.2 — Cargar la estructura en LDAP

Son tres comandos. Cada comando es UNA SOLA LÍNEA. Ejecútalos uno por uno presionando Enter después de cada uno.

Primero las OUs o departamentos:
```
docker exec ldap_server ldapadd -x -D "cn=admin,dc=odoo,dc=odoo" -w admin123 -f /tmp/estructura_odoo.ldif
```

Luego los grupos:
```
docker exec ldap_server ldapadd -x -D "cn=admin,dc=odoo,dc=odoo" -w admin123 -f /tmp/grupos_odoo.ldif
```

Finalmente los usuarios:
```
docker exec ldap_server ldapadd -x -D "cn=admin,dc=odoo,dc=odoo" -w admin123 -f /tmp/usuarios_odoo.ldif
```

Cada comando debe responder con líneas como:
```
adding new entry "ou=Odoo,dc=odoo,dc=odoo"
```

### Paso 4.3 — Verificar que los usuarios se cargaron

Este es UN SOLO comando. Cópialo completo y presiona Enter:

```
docker exec ldap_server ldapsearch -x -D "cn=admin,dc=odoo,dc=odoo" -w admin123 -b "dc=odoo,dc=odoo" "(uid=*)" uid
```

Debe mostrar `uid: juan` y `uid: zora`.

---

## Parte 5 — Probar el login LDAP (App PHP)

### Paso 5.1 — Abrir la aplicación web

Abre el navegador y entra a esta dirección:

```
http://localhost:8083
```

Verás el formulario de login con dos campos: usuario y contraseña.

NOTA IMPORTANTE: si el formulario aparece en blanco o no carga, verifica que los archivos web/login.php y web/index.html del repositorio tengan contenido. Si están vacíos, el formulario no funcionará. En ese caso revisa la sección de Solución de problemas al final de este manual.

### Paso 5.2 — Iniciar sesión

Prueba con estos usuarios:

| Usuario | Contraseña| Área esperada |
|---------|-----------|---------------|
| juan    | juan123   | Odoo          |
| zora    | zora123   | Odoo          |

### Paso 5.3 — Resultado esperado

Si el login es exitoso verás un mensaje similar a:
```
Bienvenido, juan
Área: Odoo
Autenticación exitosa · Dominio: dc=odoo,dc=odoo
```

---

## Parte 6 — Configurar Odoo 17
(Obligatorio solo la primera vez, en PC nueva, o si ejecutaste `docker compose down -v`)
(NO es necesario si solo reiniciaste, porque Odoo recuerda todo)

### Paso 6.1 — Crear la base de datos

Abre el navegador en esta dirección:

```
http://localhost:8069
```

Verás un formulario de creación de base de datos. Rellénalo así:

| Campo           | Valor                                           |
|-----------------|-------------------------------------------------|
| Master Password | el que genera Odoo o una que tu elijas, anótala |
| Database Name   | odoo                                            |
| Email           | tu correo electronico                           |
| Password        | admin                                           |
| Language        | Spanish (CO)                                    |
| Country         | Colombia                                        |
| Demo Data       | NO marcar                                       |

##NOTA: Cabe aclara que los datos de Master Passwor, Database Name y Password, son ejemplos y en realidad puedes usar los que quieras
Haz clic en el botón Create database y espera 2 a 3 minutos.

### Paso 6.2 — Inicializar módulos
(Obligatorio solo la primera vez. NO repitas este comando si ya lo hiciste antes, porque causa errores)

Este es UN SOLO comando. Cópialo completo y presiona Enter:

```
docker exec -it odoo_app odoo -d odoo -i base,web,mail,auth_ldap --stop-after-init
```

Cuando termine (verás el mensaje "Modules loaded"), ejecuta este otro comando para reiniciar Odoo:

```
docker restart odoo_app
```

Espera 30 segundos y recarga http://localhost:8069

### Paso 6.3 — Conectar Odoo con LDAP

1. Entra a http://localhost:8069 con usuario admin y contraseña admin
2. En la barra de direcciones del navegador, entra a esta URL para activar el modo desarrollador:

```
http://localhost:8069/web?debug=1
```

3. Ve al menú Ajustes, luego bajar hasta la seccion de Integraciones, selecionar la opcion de Autentificacion LDAPS
y luego en Servidor LDAP
4. Haz clic en el botón Crear y rellena los campos exactamente así:

| Campo                   | Valor                    |
|-------------------------|--------------------------|
| Dirección servidor LDAP | ldap                     |
| Puerto                  | 389                      |
| Usar TLS                | No marcar                |
| bindDN de LDAP          | cn=admin,dc=odoo,dc=odoo |
| Contraseña LDAP         | admin123                 |
| Base LDAP               | dc=odoo,dc=odoo          |
| Filtro LDAP             | (uid=%s)                 |
| Crear usuario           | Marcar Sí                |

5. Haz clic en el botón Guardar.

NOTA MUY IMPORTANTE: en el campo de dirección del servidor debes escribir la palabra `ldap`, NO escribas `127.0.0.1` ni `localhost`. 
En Docker cada contenedor es una máquina separada. Si usas 127.0.0.1, Odoo buscaría el servidor LDAP dentro de su propio contenedor, donde no existe. 
Por eso se usa el nombre del servicio `ldap`.

---

## Parte 7 — Gestión de base de datos Odoo

Para administrar las bases de datos de Odoo, abre esta dirección en el navegador:

```
http://localhost:8069/web/database/manager
```

Desde ahí puedes hacer backup, restaurar o eliminar la base de datos. Te pedirá el Master Password que anotaste en el Paso 6.1.

---

## Parte 8 — Monitoreo con Portainer
(El primer acceso requiere crear un usuario. Tienes 5 minutos para hacerlo antes de que expire por seguridad)

1. Abre el navegador en http://localhost:9000
2. Crea el usuario administrador:
   - Username: admin
   - Password: admin123
3. Haz clic en Create user y luego en Get Started

Si la pantalla muestra un mensaje de timeout, ejecuta este comando en la terminal y vuelve a intentar:

```
docker restart portainer
```

Dentro de Portainer puedes ver los 7 contenedores corriendo, la red odoo_network, los volúmenes con los datos guardados y el consumo de CPU y memoria en tiempo real.

---

## Parte 9 — Ver logs con Dozzle

Abre el navegador en http://localhost:8888

No requiere login. Verás todos los contenedores listados y puedes hacer clic en cualquiera para ver sus registros (logs) en tiempo real. Es útil para diagnosticar errores sin usar la terminal.

---

## Parte 10 — phpLDAPadmin

1. Abre el navegador en http://localhost:8090
2. Haz clic en la palabra "login" que aparece en el panel izquierdo
3. En el campo Login DN escribe:

```
cn=admin,dc=odoo,dc=odoo
```

4. En el campo Password escribe:

```
admin123
```

5. Haz clic en el botón Authenticate

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

## Parte 11 — Comandos útiles

Cada uno de estos es un comando individual. Ejecútalos según lo que necesites:

Ver todos los contenedores:
```
docker ps
```

Ver los logs del contenedor de Odoo:
```
docker logs odoo_app
```

Ver los logs del servidor LDAP:
```
docker logs ldap_server
```

Reiniciar un contenedor (por ejemplo Odoo):
```
docker restart odoo_app
```

Detener todo SIN borrar los datos:
```
docker compose down
```

Levantar todo de nuevo SIN perder los datos:
```
docker compose up -d
```

Reset completo que BORRA TODOS LOS DATOS (después necesitas repetir las Partes 4 y 6):
```
docker compose down -v
```

---

## Arquitectura del sistema

```
[Navegador del usuario]
        |
        |--- :8069 --- [Odoo 17] --- [PostgreSQL :5432]
        |                   |
        |                   +--- [LDAP :389]
        |
        |--- :8083 --- [App PHP Apache] --- [LDAP :389]
        |
        |--- :8090 --- [phpLDAPadmin] --- [LDAP :389]
        |
        |--- :9000 --- [Portainer]
        |
        +--- :8888 --- [Dozzle]

Todos los servicios están en la misma red: odoo_network
Los contenedores se comunican por nombre de servicio, no por IP.
```

---

## Información del proyecto

- Empresa: OdooTech S.A.S
- Dominio LDAP: dc=odoo,dc=odoo
- Red Docker: odoo_network
- Repositorio: https://github.com/JuanRestCor/Proyecto-Final-Odoo
- Autores: Zorally Echavarría López y Juan Steban Restrepo Correa

---

## Parte 12 — Restaurar la copia de seguridad de Odoo

El proyecto incluye una copia de seguridad de la base de datos de Odoo en la carpeta `docs/`. 
Esta copia ya tiene cargados todos los productos del menú, las categorías, las configuraciones del punto de venta y los usuarios. 
Restaurarla te da acceco a un modulo de venta ya "funcional"

### Paso 12.1 — Ubicar el archivo de backup

El archivo de copia de seguridad se encuentra en la carpeta docs con este nombre:

```
docs/Odoo-Final-Cano_2026-06-05_22-29-55.zip
```
##Para mejores resultados, descarga el zip de la copia de seguridad en tu ordenador


### Paso 12.2 — Abrir el gestor de bases de datos

Asegúrate de que los contenedores estén corriendo. Si no lo están, ejecuta primero este comando (presiona Enter después):

```
cd /home/Odoo-Docker
```

Luego este (presiona Enter después):

```
docker compose up -d
```

Ahora abre el navegador en esta dirección:

```
http://localhost:8069/web/database/manager
```

### Paso 12.3 — Eliminar la base de datos vacía (si existe)

Si al entrar al gestor ya aparece una base de datos llamada "odoo" pero está vacía o no tiene los productos, elimínala primero:

1. Busca la base de datos "odoo" en la lista.
2. Haz clic en el botón Delete (eliminar) que aparece a su lado.
3. Te pedirá el Master Password. Escribe admin123 y confirma.

### Paso 12.4 — Restaurar la copia de seguridad

1. En el gestor de bases de datos, busca y haz clic en la opción Restore Database (restaurar base de datos).
2. Se abrirá un formulario. Rellénalo así:

| Campo | Valor |
|-------|-------|
| Master Password | admin123 |
| File | selecciona el archivo docs/Odoo-Final-Cano_2026-06-05_22-29-55.zip |
| Database Name | odoo |
| This database might have been moved or copied | selecciona "This database is a copy" |



3. Haz clic en el botón Continue o Restore.
4. Espera 1 a 2 minutos mientras se restaura.

### Paso 12.5 — Verificar la restauración

Cuando termine, abre el navegador en:

```
http://localhost:8069
```

Inicia sesión como administrador (usuario admin, contraseña admin) y verifica que aparezcan los productos del menú en el Punto de Venta. Si los ves, la restauración fue exitosa.

---

## Parte 13 — Iniciar sesión con el usuario del POS y hacer una venta

El sistema tiene un usuario cajero configurado con acceso al Punto de Venta. A continuación se explica cómo iniciar sesión con él y realizar una venta completa.

### Paso 13.1 — Iniciar sesión como cajero

1. Si tienes una sesión abierta como admin, ciérrala (haz clic en tu nombre arriba a la derecha y elige Cerrar sesión).
2. Abre el navegador en:

```
http://localhost:8069
```

3. Ingresa las credenciales del usuario cajero:
   - Email: jrcorrea@iegabo.edu.co
   - Contraseña: zora123
4. Haz clic en Iniciar sesión.

Como este usuario solo tiene permisos de Punto de Venta, al entrar verá únicamente ese módulo disponible.

### Paso 13.2 — Abrir la sesión de caja

1. Haz clic en el módulo Punto de Venta.
2. Verás el punto de venta configurado. Haz clic en Nueva sesión o en el botón para abrir.
3. Si pide un monto inicial de caja, puedes dejarlo en 0 o poner el efectivo con el que inicia la caja.
4. Haz clic en Abrir sesión de caja.
5. Se abrirá la interfaz de ventas.

### Paso 13.3 — Tomar un pedido

1. Si el sistema usa mesas, selecciona una mesa del plano.
2. Haz clic sobre los productos que el cliente pide. Cada clic los agrega al pedido. Por ejemplo: un Perro Avenida y una Gaseosa.
3. Verás el pedido y el total acumulado en el panel lateral.
4. Si necesitas quitar un producto, selecciónalo en el panel y usa la tecla de borrar (Backspace) o el botón de eliminar.

### Paso 13.4 — Cobrar y finalizar

1. Cuando el pedido esté completo, haz clic en el botón Pago.
2. Selecciona el método de pago, por ejemplo Efectivo.
3. Ingresa el monto que entrega el cliente. El sistema calcula el cambio automáticamente.
4. Haz clic en Validar.
5. Puedes imprimir el recibo o enviarlo, y luego hacer clic en Nueva orden para atender al siguiente cliente.

### Paso 13.5 — Cerrar la caja al terminar el turno

1. Haz clic en el menú (las tres líneas o el ícono de la esquina superior).
2. Selecciona Cambio de usuario y seleciona al administrador.
3. Repite el paso 1 y seleciona cerrar caja.
4. El sistema mostrara el resumen de las ventas y el total de la caja
5. cuadrar la caja y colocar el valor del efectivo, para despues cerrar caja y sistema, no sin antes descaragr el informe de ventas
