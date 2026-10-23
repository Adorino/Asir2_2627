# PHP2SHELL_PATCH

## ENUNCIADO

### 1. Contexto y objetivos

En esta práctica vas a hacer lo que haría un administrador de sistemas el día que sale una vulnerabilidad crítica: averiguar si su servidor está afectado, protegerlo y demostrar que lo ha hecho.

**Qué ha pasado.** El 21 de octubre de 2026, PHP publicó una actualización de seguridad de urgencia para dos vulnerabilidades conocidas como **php2shell**:

| CVE | Qué falla | Gravedad |
| --- | --- | --- |
| CVE-2026-109618 | Si PHP se queda sin memoria a mitad de una petición, deja datos internos a medio inicializar | Crítica (CVSS 9,2) |
| CVE-2026-109619 | PHP conserva referencias a memoria de una petición que ya se ha liberado | Crítica (CVSS 9,2) |

Las dos permiten **ejecutar código en el servidor sin estar autenticado**. Es decir, un atacante podría tomar el control de la máquina solo enviando peticiones web. Afectan a todas las versiones de PHP desde la 5.4 hasta la 8.5.11. Las versiones corregidas son **8.5.12, 8.4.27, 8.3.36 y 8.2.35**. La 8.1 y anteriores ya no tienen soporte y no recibirán parche.

**Por qué es tan urgente.** Los detalles se filtraron el 20 de octubre, antes de que hubiera parche, y el mismo día 21 ya se detectaron intentos de explotación reales.

**Qué vas a aprender:**

1. Identificar qué versión de un software tienes instalada y de dónde procede.
2. Comprobar si un paquete de tu distribución ya incluye la corrección de un CVE concreto.
3. Aplicar una mitigación temporal mientras llega el parche.
4. Actualizar paquetes y reiniciar los servicios para que el cambio tenga efecto.
5. Verificar el resultado y documentarlo en un informe de incidencia.

### 2. Preparación del entorno

Trabajarás en una máquina virtual con Linux Mint o Ubuntu que tenga Apache y PHP. Nunca hagas esta práctica directamente en un servidor en producción.

**Material necesario:**

- Una VM en VirtualBox con Linux Mint 22 o Ubuntu 24.04, con conexión a Internet.
- Un usuario con permisos de `sudo`.
- Un documento donde ir pegando capturas y salidas de comandos. Será tu informe final.

#### 2.1. Haz una instantánea (snapshot) de la VM

Antes de tocar nada, en VirtualBox ve a **Máquina → Tomar instantánea** y llámala `antes-php2shell`.

<img width="340" height="349" alt="image" src="https://github.com/user-attachments/assets/3e09e4d7-5502-4858-a919-b0aaf977db4a" />

> ¿Por qué? Actualizar paquetes puede romper una aplicación. En una empresa nunca se parchea sin tener una forma de volver atrás. La instantánea es tu plan B.

#### 2.2. Comprueba que tienes Apache y PHP

Estoy usando la maquina de kali linux, ya que no tenia ni php ni apache los he instalado como se puede ver en la siguientes imagenes

<img width="643" height="536" alt="image" src="https://github.com/user-attachments/assets/b837adde-080d-4ad0-b9cc-c7a4bd0d372e" />

y aqui apache

<img width="660" height="533" alt="image" src="https://github.com/user-attachments/assets/9b56f5e1-7b2d-49e3-b29c-d1e173a016f6" />

Abre una terminal y escribe:

```bash
systemctl status apache2 --no-pager
php -v
```
Aqui se puede ver como si tengo instalados tanto php y apache.

<img width="659" height="453" alt="image" src="https://github.com/user-attachments/assets/d9aaf62b-16de-43dc-9fed-03c7d2cdfa28" />

<img width="555" height="126" alt="image" src="https://github.com/user-attachments/assets/9af782e2-5b8b-4a37-ad2b-620237f7d50e" />

- Si los dos comandos responden, ya tienes el entorno listo. Ve al apartado 2.3.
- Si alguno dice *command not found* o *could not be found*, instálalos:

```bash
sudo apt update
sudo apt install -y apache2 php libapache2-mod-php
```

> `apt update` descarga la lista de paquetes disponibles. `apt install` instala los paquetes indicados. La opción `-y` responde «sí» automáticamente a la confirmación.

#### 2.3. Crea una página de diagnóstico

Vamos a crear una página web que muestre la configuración de PHP **tal como la ve Apache**. Es importante porque la versión de PHP de la terminal y la del servidor web no siempre coinciden.

```bash
echo '<?php phpinfo();' | sudo tee /var/www/html/info.php
```
Este comando sirve para crear un archivo de php directamente en la carpeta del servidor web sin necesidad de abrir ningun editor de texto.

<img width="531" height="61" alt="image" src="https://github.com/user-attachments/assets/bf4282c8-a7dc-476b-99bc-2e5a2088ee53" />

Abre el navegador de la VM y entra en `http://localhost/info.php`. Deberías ver una página con tablas moradas y la versión de PHP en la cabecera.

**Evidencia 1:** captura de pantalla de la cabecera de `info.php`, donde se vea la versión.

es la página de diagnóstico oficial de PHP, generada dinámicamente por la función phpinfo()

<img width="672" height="596" alt="image" src="https://github.com/user-attachments/assets/4690e6b9-8dbc-4e33-9ee2-fe089dbfd431" />

> Aviso de seguridad: `phpinfo()` muestra muchísima información interna del servidor. En un servidor real **nunca** se deja publicada. La borraremos al final de la práctica.

### 3. Paso 1: identificar la versión de PHP y su origen

Antes de arreglar algo hay que saber exactamente qué tenemos. Necesitamos dos datos: la **versión** de PHP y el **repositorio** del que viene.

#### 3.1. La versión completa

```bash
php -v
```
Aqui se puede ver la version de mi php.

<img width="574" height="124" alt="image" src="https://github.com/user-attachments/assets/e36d886d-0117-47f7-ac8a-21267d4fc633" />

Verás algo parecido a esto:

```
PHP 8.3.6 (cli) (built: ...) ( NTS )
```
si aqui está

<img width="574" height="124" alt="image" src="https://github.com/user-attachments/assets/a4f4da08-8be2-453b-947c-c03bd7d82203" />

> `(cli)` significa *command line interface*: es el PHP que usa la terminal. Apache usa otro módulo (`apache2handler`), aunque normalmente es la misma versión. Por eso comprobamos también `info.php`.

Ahora guarda la versión corta (por ejemplo, `8.3`) en una variable. La usaremos en el resto de la práctica para no tener que escribirla a mano:

```bash
PHPV=$(php -r 'echo PHP_MAJOR_VERSION."."PHP_MINOR_VERSION;')
echo $PHPV
```
Aqui se puede ver como he guardado la versión corta. 

<img width="559" height="124" alt="image" src="https://github.com/user-attachments/assets/5fc0b40b-28e7-42c4-a9ba-c3d8a1e552b3" />

> `php -r` ejecuta una línea de código PHP. `$( ... )` guarda en la variable `PHPV` lo que imprime ese comando. Si cierras la terminal, la variable se pierde: tendrás que volver a ejecutar esta línea.

#### 3.2. El paquete y su repositorio

En Ubuntu y Mint, PHP se instala como un conjunto de paquetes `.deb`. Vamos a ver cuáles tienes:

```bash
dpkg -l | grep "php$PHPV"
```
Estos son los resultados de la busqueda.

<img width="650" height="425" alt="image" src="https://github.com/user-attachments/assets/da61deb4-63ea-4c08-b18a-6fcbbacfa3ce" />

> `dpkg -l` lista todos los paquetes instalados y `grep` filtra solo los que contienen, por ejemplo, `php8.3`. La segunda columna es el nombre del paquete y la tercera, su versión exacta.

Ahora mira de qué repositorio viene:

```bash
apt policy php$PHPV-common
```
Fíjate en dos líneas:

<img width="610" height="159" alt="image" src="https://github.com/user-attachments/assets/b111ce1d-ad7a-4ada-a01e-4283051078bc" />

- **Instalado:** la versión que tienes ahora.
- **Candidato:** la versión más nueva que `apt` puede instalar. Si es distinta de la instalada, hay una actualización pendiente.
Las dos versiones son las mismas, no hace falta ninguna actualización.

Debajo aparece la URL del repositorio:

<img width="610" height="159" alt="image" src="https://github.com/user-attachments/assets/95e0ad21-600a-4b33-a048-57fba39ad1d0" />

| Si la URL contiene… | El PHP viene de… | Qué implica |
| --- | --- | --- |
| `archive.ubuntu.com` o `security.ubuntu.com` | Los repositorios oficiales de Ubuntu | Ubuntu **mantiene la versión base** (p. ej. 8.3.6) y añade los parches de seguridad. El número de PHP no cambia a 8.3.36. |
| `ppa.launchpad.net/ondrej` o `packages.sury.org` | El repositorio de Ondřej Surý, muy usado en servidores | Sigue las versiones oficiales de PHP. Tras el parche verás la versión 8.3.36 (o la que corresponda). |

> Este es el detalle más importante de la práctica: **en una distribución, que el número de versión no cambie no significa que no estés parcheado**. Las distribuciones estables aplican los parches sobre la versión que ya tenían para no romper nada. Por eso, en el paso siguiente no nos fiamos del número, sino del *changelog*.

**Evidencia 2:** salida de `php -v` y de `apt policy php$PHPV-common`. Anota en el informe la versión instalada, la candidata y el repositorio de origen.
Aqui se pueden ver las respuestas de los dos comandos uno encima del otro, las versiones se puede ver que son las mismas.

<img width="574" height="285" alt="image" src="https://github.com/user-attachments/assets/87425906-0499-4ed3-bd63-cb99f40548b2" />

### 4. Paso 2: comprobar si el parche ya está aplicado

El *changelog* es el registro de cambios de un paquete. Cada vez que Ubuntu o Ondřej publican una versión nueva, anotan en él qué han corregido, incluidos los identificadores CVE. Si nuestros dos CVE aparecen en el changelog del paquete **instalado**, estamos parcheados.

#### 4.1. Changelog del paquete instalado

```bash
zcat /usr/share/doc/php$PHPV-common/changelog.Debian.gz | head -n 30
```
Lo que se ve aqui son los registros de cambios oficiales de versión y sus fechas.

<img width="654" height="512" alt="image" src="https://github.com/user-attachments/assets/418de93e-c59c-42a4-9ee1-c3f14ad0c952" />

> El changelog está comprimido en `.gz`. `zcat` lo descomprime y lo muestra sin crear ningún archivo. `head -n 30` muestra solo las 30 primeras líneas, que son las entradas más recientes.

Ahora busca directamente los dos CVE:

```bash
zcat /usr/share/doc/php$PHPV-common/changelog.Debian.gz | grep -E "CVE-2026-10961[89]"
```
El comando que ejecuté no devolvió ningún resultado en la pantalla y saltó directamente a una nueva línea de comandos porque la vulnerabilidad o patrón de texto que estaba buscando (CVE-2026-10961, CVE-2026-10968 o CVE-2026-10969) no se encuentra registrada en el archivo de cambios de mi paquete de PHP actual.

<img width="675" height="121" alt="image" src="https://github.com/user-attachments/assets/0cb2f4ab-811f-40c9-97be-4464c1f23555" />

Para buscar unos similares y no tan exactos busqué con el comando de zcat /usr/share/doc/php$PHPV-common/changelog.Debian.gz | grep -i "CVE-2026"

<img width="655" height="107" alt="image" src="https://github.com/user-attachments/assets/9c2f91b0-5afb-4ae4-bedd-e06a4d685a82" />

> `grep -E` busca usando una expresión regular. `10961[89]` significa «10961 seguido de un 8 o de un 9», así que encuentra los dos CVE con una sola búsqueda.

Interpreta el resultado:

| Resultado | Qué significa | Qué haces |
| --- | --- | --- |
| Aparecen los dos CVE | El paquete instalado ya está corregido | Salta al paso 5 para confirmar que Apache usa la versión nueva |
| No aparece nada | El paquete instalado es vulnerable | Sigue con el paso 3 y el paso 4 |

#### 4.2. ¿Hay ya un paquete corregido disponible?

Este comando consulta en Internet el changelog de la versión **candidata**, es decir, la que se instalaría si actualizaras:

```bash
sudo apt update
apt changelog php$PHPV-common 2>/dev/null | grep -E "CVE-2026-10961[89]"
```
Igual que antes, no funcionó porque este no se encuentra en el mio, entonces probaré a hacerlo con uno de los que tengo en mi lista.

<img width="658" height="145" alt="image" src="https://github.com/user-attachments/assets/0919c41f-89a0-4916-be7b-3e9ade28e763" />

<img width="628" height="58" alt="image" src="https://github.com/user-attachments/assets/3cf0b1e1-3f9f-48ba-be3a-bb3264d6f044" />

> `2>/dev/null` oculta los mensajes de error para que la salida quede limpia. Si este comando no muestra nada, puede que tu repositorio aún no haya publicado el parche. En ese caso, la mitigación del paso 3 es lo único que te protege de momento.

no se encuentra ninguno ni probando otros comandos.

<img width="669" height="277" alt="image" src="https://github.com/user-attachments/assets/0b93cded-e323-49ca-8e04-1821287c3600" />

**Evidencia 3:** salida de los dos `grep` (instalado y candidato). Escribe en el informe una frase con tu diagnóstico, por ejemplo: «El sistema es vulnerable, pero hay un paquete corregido disponible».

### 5. Paso 3: aplicar una mitigación provisional

Una **mitigación** no elimina la vulnerabilidad, pero cierra una de las vías por las que se puede explotar. Se aplica cuando todavía no hay parche o mientras se prepara la actualización. En nuestro caso, PHP ha confirmado que una función llamada *session upload progress* forma parte de una de las vías de ataque de CVE-2026-109619.

> *Session upload progress* sirve para que una web muestre una barra de progreso al subir archivos. Viene activada por defecto, pero muy pocas aplicaciones la usan, así que desactivarla no suele romper nada.

#### 5.1. Localiza los archivos de configuración

PHP tiene un `php.ini` distinto para cada forma de ejecutarse:

```bash
ls /etc/php/$PHPV/
```
<img width="350" height="60" alt="image" src="https://github.com/user-attachments/assets/7ee73807-dad4-4554-9700-ed58326fecf1" />

Verás carpetas como `cli` (terminal), `apache2` (módulo de Apache) y, quizá, `fpm` (PHP-FPM). La que nos importa es la que atiende peticiones web: `apache2` o `fpm`.

#### 5.2. Haz una copia de seguridad

```bash
sudo cp /etc/php/$PHPV/apache2/php.ini /etc/php/$PHPV/apache2/php.ini.bak
```
Aquí se puede ver como he echo la copia de seguridad usando el comando.

<img width="648" height="67" alt="image" src="https://github.com/user-attachments/assets/0fac564e-ec85-4156-8080-8e5c6f14d627" />

> Regla de oro: **antes de editar un archivo de configuración, haz una copia**. Si algo falla, podrás restaurarla con un simple `cp` en sentido inverso.

#### 5.3. Edita la directiva

Abre el archivo con `nano`:

```bash
sudo nano /etc/php/$PHPV/apache2/php.ini
```
Aqui se puede ver que estoy dentro del archivo de configuración de php.ini

<img width="659" height="511" alt="image" src="https://github.com/user-attachments/assets/69173c1f-6a87-48dd-b344-fab3f3cb5b5b" />

1. Pulsa `Ctrl + W` para buscar y escribe `upload_progress.enabled`.
2. Encontrarás una línea como `;session.upload_progress.enabled = On`. El `;` del principio indica que es un comentario y que se está usando el valor por defecto (`On`).
3. Cámbiala para que quede exactamente así, sin `;`:

Como puedes ver he quitado el punto y coma tras usar el ctrl w y buscar este parametro

<img width="660" height="515" alt="image" src="https://github.com/user-attachments/assets/d9a1ec99-b4ca-467f-bcd5-f3b1957235ac" />

```ini
session.upload_progress.enabled = 0
```
Ahora cambié en On a 0 como se ha pedido arriba

<img width="387" height="59" alt="image" src="https://github.com/user-attachments/assets/ed463720-939d-4bbf-8104-0f2910624066" />

4. Guarda con `Ctrl + O` y `Enter`, y sal con `Ctrl + X`.

Si en tu máquina existe también la carpeta `fpm`, repite los pasos 5.2 y 5.3 con `/etc/php/$PHPV/fpm/php.ini`.

Como se puede ver esa carpeta no se encuentra en mi maquina

<img width="430" height="75" alt="image" src="https://github.com/user-attachments/assets/86f2cec1-7792-4979-a4e1-31ed844b9f71" />

> Solo si tu PHP es la versión 8.5, añade además la línea `fatal_error_backtraces = 0`. Esa opción no existe en versiones anteriores.

No tengo esa versión de php por ello me saltaré este paso.

<img width="545" height="131" alt="image" src="https://github.com/user-attachments/assets/02423f3e-0065-4341-aa64-bf351b7c5d2e" />

#### 5.4. Comprueba el cambio y recarga Apache

```bash
grep -n "upload_progress.enabled" /etc/php/$PHPV/apache2/php.ini
sudo systemctl restart apache2
```
Aqui se puede ver como al usar el comando de grep buscando la linea de progress enabled muestra como he cambiado el valor y como he habilitado esta linea eliminando el punto y coma
También se ve como he reiniciado el servicio de apache.

<img width="574" height="107" alt="image" src="https://github.com/user-attachments/assets/2b1862e1-b7c7-47b6-a20e-f47dc8258d28" />

> `grep -n` muestra la línea encontrada con su número. El reinicio es obligatorio: Apache solo lee el `php.ini` al arrancar.

Ahora recarga `http://localhost/info.php`, pulsa `Ctrl + F` y busca `session.upload_progress.enabled`. Las columnas *Local Value* y *Master Value* deben indicar **Off**.

<img width="676" height="583" alt="image" src="https://github.com/user-attachments/assets/b172d8b0-a50c-4609-982b-e4e358ac49f0" />

**Evidencia 4:** captura de `info.php` con la directiva en **Off**.

<img width="666" height="543" alt="image" src="https://github.com/user-attachments/assets/64a5a370-bfcb-4b95-86fb-a1d359dd4756" />

> Importante: esta mitigación **no protege contra CVE-2026-109618**, que no tiene relación con las sesiones. Por eso actualizar sigue siendo obligatorio.

### 6. Paso 4: actualizar los paquetes de PHP

Ahora sí, aplicamos la solución definitiva: instalar la versión corregida.

#### 6.1. Mira qué se va a actualizar antes de hacerlo

```bash
sudo apt update
apt list --upgradable 2>/dev/null | grep php
```
Otra vez la respuesta es silencio y eso es porque ninguno de los paquetes pendientes de actualizar contiene la palabra "php" en su nombre

<img width="621" height="126" alt="image" src="https://github.com/user-attachments/assets/6188689a-0060-4ecd-b0bc-5a1926d82b1a" />

[Esta actualizado ta que en el paso 4.2 pensé que el problema de que no recibiera respuesta el comando era que habia que actualizar php, entonces lo hice antes de tiempo]
> Un buen administrador **nunca actualiza a ciegas**: primero revisa qué paquetes van a cambiar. Así puede detectar sorpresas, como un cambio de versión mayor, antes de que ocurran.

#### 6.2. Actualiza solo los paquetes de PHP

```bash
sudo apt install --only-upgrade "php$PHPV*"
```
Aqui se puede ver como se actualizaron los paquetes de php 

<img width="633" height="526" alt="image" src="https://github.com/user-attachments/assets/53544fcf-ecc5-457e-b75c-3717f12f3ebc" />

> `--only-upgrade` actualiza los paquetes que ya tienes, pero **no instala ninguno nuevo**. El asterisco `*` incluye todos los paquetes cuyo nombre empieza por `php8.3` (`php8.3-common`, `php8.3-cli`, etc.). Las comillas evitan que la terminal interprete el asterisco antes de tiempo.

Lee lo que `apt` muestra antes de confirmar con `S` o `Y`. Si en algún momento te pregunta si quieres **conservar tu `php.ini` modificado** o instalar el del paquete, elige **conservar la versión actual** (opción `N` o *keep*). Si no, perderías la mitigación del paso 3.

<img width="656" height="439" alt="image" src="https://github.com/user-attachments/assets/11bce7e0-6bd5-40bc-8a32-fb49ba6513f0" />

> ¿Por qué no hacer un `sudo apt upgrade` y actualizarlo todo? En la VM de prácticas podrías hacerlo. Pero en un servidor real, actualizar solo lo necesario reduce el riesgo de que otro paquete cambie y rompa algo en plena emergencia. Primero el parche urgente, después el mantenimiento normal.

#### 6.3. Comprueba el changelog otra vez

Repite exactamente el mismo comando del paso 2:

```bash
zcat /usr/share/doc/php$PHPV-common/changelog.Debian.gz | grep -E "CVE-2026-10961[89]"
```
No salía con ese comando, por ello he usado un comando que busca de forma explicita y este devolvió lo siguiente. Esa línea confirma que el mantenedor del paquete de Debian/Kali aplicó los parches específicos para evitar la corrupción de estado (state corruption) que daba origen al exploit de ejecución remota de código.

<img width="626" height="97" alt="image" src="https://github.com/user-attachments/assets/4fe1d5fe-95ad-4983-9f65-91533221a288" />

Ahora sí deberían aparecer los dos CVE. Si no aparecen, tu repositorio todavía no ha publicado el parche: anótalo en el informe, mantén la mitigación y vuelve a intentarlo otro día.

**Evidencia 5:** salida de la actualización y del `grep` en el changelog, ahora con los dos CVE.

### 7. Paso 5: reiniciar los servicios y verificar

Este paso es el que más se olvida en la vida real, y sin él todo lo anterior no sirve de nada.

> **Por qué hay que reiniciar.** Cuando Apache arranca, carga PHP en memoria. Si después actualizas los archivos en disco, Apache **sigue ejecutando la copia antigua que tiene en memoria** hasta que se reinicia. Un servidor puede tener el paquete corregido instalado y seguir siendo vulnerable.

#### 7.1. Reinicia

```bash
sudo systemctl restart apache2
sudo systemctl restart php$PHPV-fpm 2>/dev/null
```
Aquí se puede ver que se reiniciaron los dos servicios ya que no hubo ningún error como respuesta.

<img width="489" height="99" alt="image" src="https://github.com/user-attachments/assets/ceae374f-ad1a-4e11-ba60-a816d70f4afb" />

> La segunda línea solo hace algo si tienes PHP-FPM. Si no lo tienes, `2>/dev/null` oculta el error.

#### 7.2. Comprueba que el servicio está bien

```bash
systemctl status apache2 --no-pager
```
Apache se está ejecutando perfectamente (active (running)), El proceso principal (Main PID: 18956) está activo y listo para recibir peticiones (Idle/Busy workers 100/0).  (AH00558: apache2: Could not…age) indica que Apache no tiene configurado un nombre de dominio principal (ServerName) en sus archivos de configuración global y está usando la IP local o 127.0.0.1 por defecto.

<img width="631" height="373" alt="image" src="https://github.com/user-attachments/assets/a407a0d2-4c27-4a95-895a-89992ee7a668" />

El "preset" es solo un recordatorio de cómo venía el sistema originalmente.

Debe aparecer **active (running)** en verde. Si aparece *failed*, revisa el error con `sudo journalctl -u apache2 -n 30` y, si no sabes resolverlo, restaura la copia `php.ini.bak` o vuelve a la instantánea.

#### 7.3. Demuestra que el reinicio fue posterior a la actualización

```bash
grep -A3 "Start-Date" /var/log/apt/history.log | tail -n 8
systemctl show apache2 -p ActiveEnterTimestamp
```

<img width="628" height="366" alt="Captura de pantalla 2026-10-23 095513" src="https://github.com/user-attachments/assets/35bc5b50-0f4e-432b-bc08-d05c1dcb9bd2" />

Aqui tienes la respuesta completa:
```bash
Commandline: apt dist-upgrade -y
Requested-By: molina (1000)
Install: libperl5.42:amd64 (5.42.3-1, automatic), selinux-utils:amd64 (3.11-2.1, automatic), g++-16-x86-64-linux-gnu:amd64 (16.2.0-3, automatic), cups-filters:amd64 (1.28.17-7+b3, automatic), python3-flask-security:amd64 (5.9.1-1, automatic), python3-httpcore2:amd64 (2.12.0-2, automatic), g++-16:amd64 (16.2.0-3, automatic), gcc-16:amd64 (16.2.0-3, automatic), libtesseract5:amd64 (5.5.0-1.1, automatic), libgcc-16-dev:amd64 (16.2.0-3, automatic), libhdf5-320:amd64 (2.2.0+repack-5, automatic), libstdc++-16-dev:amd64 (16.2.0-3, automatic), libntfs-3g90:amd64 (1:2026.7.7-2, automatic), cups-common:amd64 (2.4.18-1, automatic), gcc-16-x86-64-linux-gnu:amd64 (16.2.0-3, automatic), libopenjph0.28:amd64 (0.28.1-1, automatic), libimath-3-2-30:amd64 (3.2.2-2+b1, automatic), libx265-216:amd64 (4.2-3, automatic), libcmark-gfm-extensions0.29.0.gfm.13:amd64 (0.29.0.gfm.13-7.1, automatic), libgeos3.15.0:amd64 (3.15.0-1, automatic), libbluray4:amd64 (1:1.5.0-3, automatic), fonts-font-awesome-legacy:amd64 (6-3, automatic), libpyside6-py3-6.11:amd64 (6.11.2-2, automatic), cups-client:amd64 (2.4.18-1, automatic), cups-ppdc:amd64 (2.4.18-1, automatic), ruby-sys-proctable:amd64 (1.3.0-1, automatic), python3-diskcache:amd64 (5.6.3-2, automatic), cups-daemon:amd64 (2.4.18-1, automatic), libproc2-1:amd64 (2:4.0.7-1, automatic), libcmark-gfm0.29.0.gfm.13:amd64 (0.29.0.gfm.13-7.1, automatic), libvidstab1.2:amd64 (1.1.1-4, automatic), libqpdf30:amd64 (12.4.2-1, automatic), libpoppler-cpp3:amd64 (26.07.0-2, automatic), libconfig++15:amd64 (1.8.2+ds-1, automatic), cups-filters-core-drivers:amd64 (1.28.17-7+b3, automatic), poppler-utils:amd64 (26.07.0-2, automatic), cups-ipp-utils:amd64 (2.4.18-1, automatic), libmupdf28.2:amd64 (1.28.2+ds1-2, automatic), linux-modules-7.1.5+kali-amd64:amd64 (7.1.5-1kali1, automatic), libcupsfilters1t64:amd64 (1.28.17-7+b3, automatic), ruby-websocket-extensions:amd64 (0.1.5-2, automatic), libswscale10:amd64 (7:9.0.2-1, automatic), linux-image-7.1.5+kali-amd64:amd64 (7.1.5-1kali1, automatic),lynx:amd64 (2.9.3-2, automatic), linux-binary-7.1.5+kali-amd64:amd64 (7.1.5-1kali1, automatic), libavcodec63:amd64 (7:9.0.2-1, automatic), libjim0.84:amd64 (0.84-2, automatic), mailcap:amd64 (3.77, automatic), systemd-tpm:amd64 (262-1, automatic), libobjc-16-dev:amd64 (16.2.0-3, automatic), liblouisutdml-bin:amd64 (2.12.0-8+b2, automatic), libavfilter12:amd64 (7:9.0.2-1, automatic), libshiboken6-py3-6.11:amd64 (6.11.2-2, automatic), libpoppler162:amd64 (26.07.0-2, automatic), cpp-16-x86-64-linux-gnu:amd64 (16.2.0-3, automatic), libavutil61:amd64 (7:9.0.2-1, automatic), cups-browsed:amd64 (1.28.17-7+b3, automatic), libfmt11:amd64 (11.1.1+ds1-2, automatic), cpp-16:amd64 (16.2.0-3, automatic), libtss2-rc0t64:amd64 (4.1.3-7, automatic), libsimdutf35:amd64 (9.1.2-1, automatic), ruby-ferrum:amd64 (0.18.0-1, automatic), lynx-common:amd64 (2.9.3-2, automatic), libleptonica6:amd64 (1.86.0-1+b1, automatic), cups-core-drivers:amd64 (2.4.18-1, automatic), python3-tenacity:amd64 (9.1.4-2, automatic), libswresample7:amd64 (7:9.0.2-1, automatic), fonts-roboto-slab:amd64 (2.002+20231012+ds-1, automatic), libucl1:amd64 (1.03+repack-6.1, automatic), photorec:amd64 (7.2-2, automatic), liblouisutdml-data:amd64 (2.12.0-8, automatic), libabsl20260526:amd64 (20260526.0-2+kali1, automatic), bc:amd64 (1.07.1-4, automatic), libavformat63:amd64 (7:9.0.2-1, automatic), python3-opentelemetry-api:amd64 (1.44.0-2, automatic), cups:amd64 (2.4.18-1, automatic), libfontembed1t64:amd64 (1.28.17-7+b3, automatic), liblouisutdml9t64:amd64 (2.12.0-8+b2, automatic), ruby-websocket-driver:amd64 (0.8.2-1, automatic), perl-modules-5.42:amd64 (5.42.3-1, automatic), python3-stamina:amd64 (26.1.0+dfsg-1, automatic), libpostal-data:amd64 (1.1.4-0kali1, automatic), python3-truststore:amd64 (0.10.4-2, automatic), libencode-perl:amd64 (3.24-1+b1, automatic), cups-server-common:amd64 (2.4.18-1, automatic), linux-base-7.1.5+kali-amd64:amd64 (7.1.5-1kali1, automatic), libhdf5-hl-320:amd64 (2.2.0+repack-5, automatic), libconfig15:amd64 (1.8.2+ds-1, automatic), python3-httpx2:amd64 (2.12.0-2, automatic)
--
Start-Date: 2026-10-23  09:45:19
Commandline: apt install --only-upgrade php8.4-cli php8.4-common libapache2-mod-php8.4
Requested-By: molina (1000)
Upgrade: php8.4-mbstring:amd64 (8.4.24-1, 8.4.27-1), php8.4-xml:amd64 (8.4.24-1, 8.4.27-1), php8.4-zip:amd64 (8.4.24-1, 8.4.27-1), php8.4-readline:amd64 (8.4.24-1, 8.4.27-1), php8.4-gd:amd64 (8.4.24-1, 8.4.27-1), php8.4-mysql:amd64 (8.4.24-1, 8.4.27-1), libapache2-mod-php8.4:amd64 (8.4.24-1, 8.4.27-1), php8.4:amd64 (8.4.24-1, 8.4.27-1), php8.4-opcache:amd64 (8.4.24-1, 8.4.27-1), php8.4-curl:amd64 (8.4.24-1, 8.4.27-1), php8.4-common:amd64 (8.4.24-1, 8.4.27-1), php8.4-cli:amd64 (8.4.24-1, 8.4.27-1)
```

<img width="442" height="65" alt="image" src="https://github.com/user-attachments/assets/4680d891-fd01-4dab-bb00-3c69d7a8d1fc" />


> El primer comando muestra la fecha y hora de la última actualización de paquetes, sacada del registro de `apt`.

<img width="619" height="152" alt="image" src="https://github.com/user-attachments/assets/49c5c13f-043f-4abc-8df4-8d8556bc1e6e" />

El segundo muestra cuándo arrancó Apache por última vez. **La hora de arranque de Apache debe ser posterior a la de la actualización.** Si es anterior, Apache sigue usando el PHP viejo.

<img width="459" height="65" alt="image" src="https://github.com/user-attachments/assets/5c7ce8d6-144c-438c-92a3-2ef5f0977770" />

#### 7.4. Comprobación final desde la web

Recarga `http://localhost/info.php` y confirma:

- [ ] La versión mostrada coincide con la del paquete actualizado.

<img width="595" height="377" alt="image" src="https://github.com/user-attachments/assets/7b3829a8-3fe1-48a4-b838-d021add41ed7" />

<img width="564" height="125" alt="image" src="https://github.com/user-attachments/assets/108e619e-27b1-47ce-9e0a-4781c2c50184" />

- [ ] `session.upload_progress.enabled` sigue en **Off**.

<img width="641" height="476" alt="image" src="https://github.com/user-attachments/assets/78e7c2ef-26f9-4128-8152-d1eaa0f8937a" />

- [ ] La página carga sin errores.

#### 7.5. Limpieza

Borra la página de diagnóstico. Ya no la necesitas y, como vimos, es peligrosa:

```bash
sudo rm /var/www/html/info.php
```
<img width="342" height="56" alt="image" src="https://github.com/user-attachments/assets/d5491bb5-54b8-4d29-a5ad-2339e4ae3a43" />

Comprueba que `http://localhost/info.php` devuelve ahora un error **404 Not Found**.

<img width="678" height="523" alt="image" src="https://github.com/user-attachments/assets/d59ecd58-c3d7-43e3-b65e-450d7e3a0723" />

**Evidencia 6:** salida de `systemctl status`, de los dos comandos del apartado 7.3 y captura del error 404.

grep -A3 "Start-Date" /var/log/apt/history.log | tail -n 8: 

<img width="663" height="363" alt="image" src="https://github.com/user-attachments/assets/f8fee716-b9ad-4b7d-96d7-383449d0fe94" />

Respuesta completa:
```bash
Commandline: apt dist-upgrade -y
Requested-By: molina (1000)
Install: libperl5.42:amd64 (5.42.3-1, automatic), selinux-utils:amd64 (3.11-2.1, automatic), g++-16-x86-64-linux-gnu:amd64 (16.2.0-3, automatic), cups-filters:amd64 (1.28.17-7+b3, automatic), python3-flask-security:amd64 (5.9.1-1, automatic), python3-httpcore2:amd64 (2.12.0-2, automatic), g++-16:amd64 (16.2.0-3, automatic), gcc-16:amd64 (16.2.0-3, automatic), libtesseract5:amd64 (5.5.0-1.1, automatic), libgcc-16-dev:amd64 (16.2.0-3, automatic), libhdf5-320:amd64 (2.2.0+repack-5, automatic), libstdc++-16-dev:amd64 (16.2.0-3, automatic), libntfs-3g90:amd64 (1:2026.7.7-2, automatic), cups-common:amd64 (2.4.18-1, automatic), gcc-16-x86-64-linux-gnu:amd64 (16.2.0-3, automatic), libopenjph0.28:amd64 (0.28.1-1, automatic), libimath-3-2-30:amd64 (3.2.2-2+b1, automatic), libx265-216:amd64 (4.2-3, automatic), libcmark-gfm-extensions0.29.0.gfm.13:amd64 (0.29.0.gfm.13-7.1, automatic), libgeos3.15.0:amd64 (3.15.0-1, automatic), libbluray4:amd64 (1:1.5.0-3, automatic), fonts-font-awesome-legacy:amd64 (6-3, automatic), libpyside6-py3-6.11:amd64 (6.11.2-2, automatic), cups-client:amd64 (2.4.18-1, automatic), cups-ppdc:amd64 (2.4.18-1, automatic), ruby-sys-proctable:amd64 (1.3.0-1, automatic), python3-diskcache:amd64 (5.6.3-2, automatic), cups-daemon:amd64 (2.4.18-1, automatic), libproc2-1:amd64 (2:4.0.7-1, automatic), libcmark-gfm0.29.0.gfm.13:amd64 (0.29.0.gfm.13-7.1, automatic), libvidstab1.2:amd64 (1.1.1-4, automatic), libqpdf30:amd64 (12.4.2-1, automatic), libpoppler-cpp3:amd64 (26.07.0-2, automatic), libconfig++15:amd64 (1.8.2+ds-1, automatic), cups-filters-core-drivers:amd64 (1.28.17-7+b3, automatic), poppler-utils:amd64 (26.07.0-2, automatic), cups-ipp-utils:amd64 (2.4.18-1, automatic), libmupdf28.2:amd64 (1.28.2+ds1-2, automatic), linux-modules-7.1.5+kali-amd64:amd64 (7.1.5-1kali1, automatic), libcupsfilters1t64:amd64 (1.28.17-7+b3, automatic), ruby-websocket-extensions:amd64 (0.1.5-2, automatic), libswscale10:amd64 (7:9.0.2-1, automatic), linux-image-7.1.5+kali-amd64:amd64 (7.1.5-1kali1, automatic), lynx:amd64 (2.9.3-2, automatic), linux-binary-7.1.5+kali-amd64:amd64 (7.1.5-1kali1, automatic), libavcodec63:amd64 (7:9.0.2-1, automatic), libjim0.84:amd64 (0.84-2, automatic), mailcap:amd64 (3.77, automatic), systemd-tpm:amd64 (262-1, automatic), libobjc-16-dev:amd64 (16.2.0-3, automatic), liblouisutdml-bin:amd64 (2.12.0-8+b2, automatic), libavfilter12:amd64 (7:9.0.2-1, automatic), libshiboken6-py3-6.11:amd64 (6.11.2-2, automatic), libpoppler162:amd64 (26.07.0-2, automatic), cpp-16-x86-64-linux-gnu:amd64 (16.2.0-3, automatic), libavutil61:amd64 (7:9.0.2-1, automatic), cups-browsed:amd64 (1.28.17-7+b3, automatic), libfmt11:amd64 (11.1.1+ds1-2, automatic), cpp-16:amd64 (16.2.0-3, automatic), libtss2-rc0t64:amd64 (4.1.3-7, automatic), libsimdutf35:amd64 (9.1.2-1, automatic), ruby-ferrum:amd64 (0.18.0-1, automatic), lynx-common:amd64 (2.9.3-2, automatic), libleptonica6:amd64 (1.86.0-1+b1, automatic), cups-core-drivers:amd64 (2.4.18-1, automatic), python3-tenacity:amd64 (9.1.4-2, automatic), libswresample7:amd64 (7:9.0.2-1, automatic), fonts-roboto-slab:amd64 (2.002+20231012+ds-1, automatic), libucl1:amd64 (1.03+repack-6.1, automatic), photorec:amd64 (7.2-2, automatic), liblouisutdml-data:amd64 (2.12.0-8, automatic), libabsl20260526:amd64 (20260526.0-2+kali1, automatic), bc:amd64 (1.07.1-4, automatic), libavformat63:amd64 (7:9.0.2-1, automatic), python3-opentelemetry-api:amd64 (1.44.0-2, automatic), cups:amd64 (2.4.18-1, automatic), libfontembed1t64:amd64 (1.28.17-7+b3, automatic), liblouisutdml9t64:amd64 (2.12.0-8+b2, automatic), ruby-websocket-driver:amd64 (0.8.2-1, automatic), perl-modules-5.42:amd64 (5.42.3-1, automatic), python3-stamina:amd64 (26.1.0+dfsg-1, automatic), libpostal-data:amd64 (1.1.4-0kali1, automatic), python3-truststore:amd64 (0.10.4-2, automatic), libencode-perl:amd64 (3.24-1+b1, automatic), cups-server-common:amd64 (2.4.18-1, automatic), linux-base-7.1.5+kali-amd64:amd64 (7.1.5-1kali1, automatic), libhdf5-hl-320:amd64 (2.2.0+repack-5, automatic), libconfig15:amd64 (1.8.2+ds-1, automatic), python3-httpx2:amd64 (2.12.0-2, automatic)
--
Start-Date: 2026-10-23  09:45:19
Commandline: apt install --only-upgrade php8.4-cli php8.4-common libapache2-mod-php8.4
Requested-By: molina (1000)
Upgrade: php8.4-mbstring:amd64 (8.4.24-1, 8.4.27-1), php8.4-xml:amd64 (8.4.24-1, 8.4.27-1), php8.4-zip:amd64 (8.4.24-1, 8.4.27-1), php8.4-readline:amd64 (8.4.24-1, 8.4.27-1), php8.4-gd:amd64 (8.4.24-1, 8.4.27-1), php8.4-mysql:amd64 (8.4.24-1, 8.4.27-1), libapache2-mod-php8.4:amd64 (8.4.24-1, 8.4.27-1), php8.4:amd64 (8.4.24-1, 8.4.27-1), php8.4-opcache:amd64 (8.4.24-1, 8.4.27-1), php8.4-curl:amd64 (8.4.24-1, 8.4.27-1), php8.4-common:amd64 (8.4.24-1, 8.4.27-1), php8.4-cli:amd64 (8.4.24-1, 8.4.27-1)
```
systemctl show apache2 -p ActiveEnterTimestamp:

<img width="457" height="73" alt="image" src="https://github.com/user-attachments/assets/45f5c64e-74d0-4382-bf35-655f62c99875" />

### 8. Paso 6: el informe de incidencia

En una empresa, un parche que no está documentado es un parche que no existe: nadie puede comprobar que se hizo, ni cuándo, ni cómo. Por eso terminarás con un informe breve, como el que entregarías a tu responsable.

#### 8.1. Estructura del informe

Tu informe en PDF debe tener estos apartados, en este orden:

1. **Datos del sistema:** nombre de la máquina (`hostname`), distribución (`lsb_release -d`), versión de PHP y repositorio de origen.
2. **Diagnóstico inicial:** ¿era vulnerable el sistema? Justifícalo con la evidencia del changelog.
3. **Acciones realizadas:** lista de lo que has hecho, en orden y con fecha y hora.
4. **Verificación:** prueba de que el sistema está corregido y de que Apache se reinició después de la actualización.
5. **Riesgo residual:** ¿queda algo pendiente? Por ejemplo, la mitigación sigue activa, o el parche aún no estaba disponible.
6. **Evidencias:** las 6 evidencias numeradas, cada una con una frase que explique qué demuestra.

#### 8.2. Entregables

- [ ] Informe en PDF con los 6 apartados.
- [ ] Respuestas a las preguntas de reflexión (apartado 9).

#### 8.3. Rúbrica de evaluación

| Criterio | Peso | Excelente | Suficiente | Insuficiente |
| --- | --- | --- | --- | --- |
| Diagnóstico (versión, origen, changelog) | 20 % | Identifica versión y repositorio, y justifica el estado con el changelog | Identifica la versión, pero la justificación es incompleta | Se basa solo en el número de versión |
| Mitigación | 15 % | Copia de seguridad, cambio correcto y verificado en `info.php` | Cambio correcto sin verificación | No aplicada o incorrecta |
| Actualización | 20 % | Revisa antes de actualizar y conserva el `php.ini` | Actualiza correctamente sin revisión previa | No actualiza o rompe el servicio |
| Reinicio y verificación | 20 % | Demuestra con fechas que el reinicio fue posterior | Reinicia, pero no lo demuestra | No reinicia |
| Limpieza | 5 % | Borra `info.php` y comprueba el 404 | Lo borra sin comprobar | No lo borra |
| Informe | 10 % | Completo, ordenado y con evidencias explicadas | Completo pero con evidencias sin explicar | Faltan apartados |
| Preguntas de reflexión | 10 % | Respuestas razonadas y propias | Respuestas correctas pero escuetas | Sin responder o copiadas |

### 9. Preguntas de reflexión

Responde con tus propias palabras, en 3 o 4 líneas cada una.

1. Tu compañero dice: «Mi `php -v` sigue mostrando 8.3.6, así que no estoy parcheado». ¿Tiene razón? ¿Cómo lo comprobarías?
2. ¿Por qué un servidor con el paquete ya actualizado puede seguir siendo vulnerable? ¿Qué comando lo evita?
3. ¿Qué diferencia hay entre una **mitigación** y una **corrección**? Pon un ejemplo de esta práctica para cada una.
4. Una empresa tiene un servidor con PHP 7.4 que «funciona perfectamente y nadie quiere tocar». ¿Qué riesgo corre con php2shell y qué le recomendarías?
5. Los detalles de estas vulnerabilidades se filtraron antes de que hubiera parche. ¿Qué es una *divulgación coordinada* y por qué es importante respetarla?
6. Si administraras 50 servidores en lugar de uno, ¿harías este proceso a mano en cada uno? Investiga y nombra una herramienta que permita automatizarlo.

### Fuentes

- [The Hacker News: PHP Issues Emergency Patches for Two Critical PHP2Shell RCE Flaws](https://thehackernews.com/2026/10/php-issues-emergency-patches-for-two.html)
- [Laravel Forge: PHP security advisory (versiones afectadas y corregidas)](https://laravel.com/forge/docs/knowledge-base/php-security-release-october-2026)
- [Huntress: php2shell, Leaked Critical PHP Vulnerabilities](https://www.huntress.com/blog/php2shell-leaked-critical-php-vulnerabilities)
- [Google Cloud / Wiz: Responding to core PHP vulnerabilities](https://cloud.google.com/blog/products/identity-security/responding-to-core-php-vulnerabilities-cve-2026-109618-cve-2026-109619)
- [Codeable: PHP Security Release on 21 October 2026](https://www.codeable.io/blog/php-vulnerability-cve-2026-109618/)
