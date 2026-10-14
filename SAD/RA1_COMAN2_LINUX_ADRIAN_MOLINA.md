FASE 1: Permisos de Archivos en Linux

## Ejercicio 1: Gestión de Permisos en un Entorno de Trabajo Multiusuario

Escenario: imagina que eres el administrador de un equipo de desarrollo con varios usuarios, y necesitas configurar los permisos de un proyecto compartido entre tres usuarios: monon1, tronko2 y birmingan3. Cada uno debe tener permisos específicos para un directorio de proyecto, de acuerdo con su rol.

## Paso 1: Crear un entorno simulado de usuarios y grupos. Crea los tres usuarios y un grupo común llamado devEria2. Crea un directorio llamado di_recto para el proyecto y cambia el grupo propietario a devEria2.
Aqui se pueden ver los comandos usados para crear los tres usuarios. 

<img width="448" height="207" alt="image" src="https://github.com/user-attachments/assets/2df7c159-9042-4c69-96d3-9f9bc8d73a3c" />

Aqui se puede ver como creé el grupo de devEra2 y como añadi dichos usuarios al grupo.

<img width="393" height="192" alt="image" src="https://github.com/user-attachments/assets/8ac611ca-7328-4ac9-84fd-e6e4d0d0bcb8" />

Ahora creé el directorio y cambié el propietario de dicho directorio usando el comando de chgrp.

<img width="348" height="103" alt="image" src="https://github.com/user-attachments/assets/3da25212-9aa1-455b-9cc3-5a8853ea2e7b" />

## Paso 2: Configuración de permisos básicos. Configura los permisos para que solo los usuarios del grupo devEria2 puedan escribir en el directorio. Verifica mostrando los permisos del directorio.
Aqui se puede ver como configureré los permisos basicos, dandole permisos a los integrantes del grupo de devEria2 y sin darle permisos a otro, por eso 770.

<img width="531" height="110" alt="image" src="https://github.com/user-attachments/assets/37ea4efe-2213-4ea9-af5b-ae182471a446" />

## Paso 3: Configuración de permisos avanzados. monon1 debe tener permisos completos (lectura, escritura, ejecución) en todo el proyecto: 

cambia el propietario del directorio a monon1. Los otros dos usuarios del grupo solo deben poder leer y ejecutar archivos, pero no modificarlos: cambia los permisos de modo que el grupo devEria2 solo tenga permisos de lectura y ejecución.
SE cambiará el propietario dle directorio a monon1 usando el comando de chwon, Se cambiarán los pemrisos, haciendo que el propietario tenga todos los permisos, y los permisos del grupo sea de lectura y ejecución, un 5.

<img width="506" height="161" alt="image" src="https://github.com/user-attachments/assets/020e2d80-22f4-43d5-8476-04f57e947e94" />

Preguntas:

### ¿Qué sucede si un usuario fuera del grupo devEria2 intenta acceder al directorio?
No tendrá permiso de acceso, como se puede ver en la imagen.

<img width="347" height="64" alt="image" src="https://github.com/user-attachments/assets/ff6cb650-f9da-4d8e-bb53-bb551139c121" />

### ¿Qué sucede si tronko2 intenta modificar un archivo dentro del directorio?
El tampoco tiene permisos de modificacion, como se puede ver en la imagen.

## Ejercicio 2: Control de Acceso con el Bit SGID en Directorios
Escenario: el equipo de desarrollo necesita colaborar en un subdirectorio dentro de di_recto. Queremos asegurarnos de que cualquier archivo creado en ese subdirectorio tenga automáticamente el mismo grupo propietario (devEria2), para facilitar la colaboración.

Paso 1: Crear un subdirectorio para colaboración. Crea un subdirectorio llamado di_afano dentro de /di_recto. Cambia el grupo propietario del subdirectorio a devEria2.

<img width="391" height="259" alt="image" src="https://github.com/user-attachments/assets/5ac3bd6e-518a-4f9f-b3fa-36fb027d0e1f" />

Paso 2: Aplicar el bit SGID. Aplica el bit SGID al subdirectorio di_afano, para que todos los archivos creados en él hereden el grupo propietario. Verifica y muestra los permisos del subdirectorio.

<img width="556" height="116" alt="image" src="https://github.com/user-attachments/assets/59a94a23-c87e-4804-8258-cc2c615a0dc7" />

Paso 3: Crear archivos de prueba. Cambia a tronko2 y crea un archivo llamado archivo_tronko2.txt dentro del subdirectorio di_afano. Verifica y muestra los permisos y el grupo propietario del archivo.

<img width="608" height="264" alt="image" src="https://github.com/user-attachments/assets/57468690-b895-492b-a377-99ede640835e" />

Preguntas:

### ¿Cuál es el grupo propietario del archivo creado por tronko2?

El grupo propietario será devEria2, porque el directorio di_afano tiene activado el bit SGID.
Normalmente, sin SGID, el archivo heredaría el grupo principal efectivo del usuario que lo crea, según la configuración del sistema. Con SGID en el directorio, hereda el grupo propietario de ese directorio.

### ¿Qué ventaja aporta el bit SGID en un entorno de colaboración?

Unifica el grupo propietario: los archivos nuevos heredan el grupo del directorio.
Facilita el trabajo en equipo: los miembros del grupo pueden acceder a los archivos según los permisos asignados.
Reduce errores administrativos: no es necesario cambiar manualmente el grupo de cada archivo.
Mejora la organización: el contenido del proyecto mantiene una propiedad de grupo coherente.

## Ejercicio 3: Gestión de Archivos Temporales con Sticky Bit
Escenario: se ha creado un directorio temporal compartido entre todos los usuarios del sistema. Necesitas asegurarte de que los usuarios puedan crear y modificar sus propios archivos, pero no puedan eliminar o modificar los archivos de otros usuarios.

Paso 1: Crear un directorio temporal. Crea un directorio llamado tmp_rano en /tmp. Cambia los permisos para que todos los usuarios puedan leer, escribir y ejecutar en el directorio.

<img width="384" height="97" alt="image" src="https://github.com/user-attachments/assets/df36f500-1ce4-4a3a-8363-e98211f17964" />

Paso 2: Aplicar el sticky bit. Aplica el sticky bit al directorio para evitar que los usuarios eliminen archivos de otros. Verifica los permisos del directorio.

<img width="448" height="112" alt="image" src="https://github.com/user-attachments/assets/71a2e25e-3520-4535-9bf6-5032f21dacca" />

Paso 3: Crear archivos de prueba. Cambia a monon1 y crea un archivo en el directorio temporal. Cambia a birmingan3 y verifica si puede eliminar el archivo de monon1.

<img width="623" height="296" alt="image" src="https://github.com/user-attachments/assets/673470c1-8075-48b7-82da-b9f3bef0e98a" />

Preguntas:

### ¿Pudo birmingan3 eliminar el archivo de monon1? ¿Por qué?

No. Como el directorio tiene activado el sticky bit (t), un usuario normal no puede eliminar ni renombrar archivos pertenecientes a otros usuarios, aunque el directorio tenga permisos 777.
Las excepciones principales son el propietario del archivo, el propietario del directorio y los procesos con privilegios adecuados.

### ¿Cómo ayuda el sticky bit a mejorar la seguridad en directorios compartidos?

Protege los archivos ajenos: evita que cualquier usuario elimine o renombre archivos de otros usuarios.
Permite la colaboración: todos pueden crear archivos en el directorio compartido.
Reduce eliminaciones accidentales o malintencionadas: cada usuario conserva el control de sus propios archivos.
Facilita la gestión de espacios temporales: es el mecanismo utilizado tradicionalmente en directorios como /tmp.

## Ejercicio 4: Configuración de umask y Creación de Archivos Nuevos
Escenario: quieres configurar el entorno de trabajo para que todos los archivos nuevos creados por los usuarios tengan permisos predeterminados restrictivos (sólo lectura y escritura para el propietario, sin acceso para el grupo y otros).

Paso 1: Configurar umask. Verifica el valor actual de umask. Cambia el valor de umask a 077 para que los archivos creados sean accesibles solo por el propietario.

<img width="410" height="177" alt="image" src="https://github.com/user-attachments/assets/83f3a4e7-9e0f-47df-bd77-aca7e3843ee0" />

Paso 2: Crear archivos de prueba. Crea un archivo nuevo llamado gomaesp_umask y verifica sus permisos.

<img width="560" height="142" alt="image" src="https://github.com/user-attachments/assets/7810206b-ab97-4763-a9b6-0cc8e8c898f6" />

Paso 3: Restablecer umask. Si deseas restaurar el valor predeterminado de umask, puedes hacerlo.
<img width="365" height="104" alt="image" src="https://github.com/user-attachments/assets/7996d47b-4250-4258-a6b7-f72ac7f6f47e" />

Preguntas:

### ¿Cómo afectó el valor de umask a los permisos de los nuevos archivos?

Al establecer umask 077, los archivos nuevos creados normalmente con permisos iniciales 666 quedan con permisos 600 (rw-------).
Esto significa que:
- El propietario puede leer y escribir.
- Los miembros del grupo no tienen acceso por los permisos tradicionales.
- Los demás usuarios tampoco tienen acceso por los permisos tradicionales.
Los directorios nuevos normalmente quedan con permisos 700, por lo que solo su propietario puede listarlos y acceder a ellos.

### ¿Cómo podrías usar umask para mejorar la seguridad de los archivos en un sistema multiusuario?

Puedes aplicar máscaras restrictivas para evitar que los archivos nuevos sean accesibles por otros usuarios de forma predeterminada.
- umask 077: para archivos privados, como documentos de trabajo o configuraciones personales.
- umask 027: para permitir lectura al grupo, pero denegar el acceso a los demás usuarios.
- umask 022: para permitir lectura a otros usuarios, pero no escritura por los permisos habituales.
En un entorno multiusuario, umask 077 es especialmente útil para información confidencial, ya que reduce el riesgo de exposición accidental.

## Ejercicio 5: Implementación de ACLs
Queremos que birmingan3 pueda leer un archivo específico dentro de un nuevo directorio que se tiene que crear llamado archivos_criticos, pero sin poder modificarlo.

<img width="442" height="129" alt="image" src="https://github.com/user-attachments/assets/174b5ff4-7ca7-4b67-a840-a4a0874d24d6" />

<img width="435" height="93" alt="image" src="https://github.com/user-attachments/assets/fd789e59-939d-43a5-88fe-0b61546256c0" />

<img width="441" height="193" alt="image" src="https://github.com/user-attachments/assets/aa0a479a-f41a-4535-b1a0-b8c553f09feb" />

<img width="602" height="490" alt="image" src="https://github.com/user-attachments/assets/58c8ffd2-f4fc-464d-aa9f-03540fe354b2" />

Habilita ACLs en el sistema si no están habilitadas (si ya lo están, omite este paso).

## FASE 2: Reto de Búsquedas Avanzadas
Objetivo: uso efectivo de los comandos de búsqueda (grep, find, locate) y sus opciones para localizar información específica, archivos y directorios dentro del sistema de ficheros.

Setup Inicial a realizar (se asume que se está en tu directorio personal):

Creación de la Estructura de Ficheros — crea la siguiente jerarquía de directorios y archivos:

mkdir -p Documentos/Informes Documentos/Logs Proyectos/web Proyectos/app
touch Documentos/Logs/log_acceso.2023 Documentos/Logs/log_error.2024
touch Proyectos/web/index.html Proyectos/web/estilos.css
touch Proyectos/app/main.py Proyectos/app/config_dev.ini
touch Documentos/Informes/informe_final.txt
Relleno de Contenido — utiliza el comando echo o un editor de texto (como nano) para añadir el siguiente contenido a los archivos:

<img width="628" height="379" alt="image" src="https://github.com/user-attachments/assets/61d1df72-e831-46c4-b5a0-905cb7c10b30" />

Documentos/Logs/log_error.2024:

[CRIT] Error en la base de datos.
[WARN] Conexion lenta.
[CRIT] Fallo de autenticacion.
[INFO] Tarea completada.

<img width="425" height="151" alt="image" src="https://github.com/user-attachments/assets/f16d6bf4-0fd0-4540-b9c7-9aa7e18a6adf" />

Proyectos/app/main.py:

# Este es el script principal
PATH_CONFIG = '/etc/prod/config.ini' # Configuracion de produccion
def iniciar_servidor():
    pass
# Funcion obsoleta: iniciar_antiguo()

<img width="628" height="177" alt="image" src="https://github.com/user-attachments/assets/7ebf1312-4a0a-479d-9a44-cef272b3ed2b" />

Proyectos/app/config_dev.ini:

[GENERAL]
DEBUG = True
PORT = 8080
Ejercicios de Búsqueda

<img width="438" height="137" alt="image" src="https://github.com/user-attachments/assets/bf3ff8be-3eb3-46bf-ab4b-aeb8e5b53ca2" />

## I. Ejercicios con grep (Búsqueda de Contenido)

Busca Errores Críticos: muestra todas las líneas que contengan la palabra [CRIT] dentro del archivo Documentos/Logs/log_error.2024.

<img width="418" height="74" alt="image" src="https://github.com/user-attachments/assets/1df0b927-e5b8-4c6c-8bcd-5af2ad4ce171" />

Busca la Configuración de Producción: dentro del directorio Proyectos, busca recursivamente (-r) en todos los archivos la cadena PATH_CONFIG.

<img width="622" height="83" alt="image" src="https://github.com/user-attachments/assets/576989d8-f2c3-4712-8f2c-09e403ac60b4" />

Contar Fallos: muestra solo el número de líneas (-c) que contienen la palabra Fallo en log_error.2024.

<img width="452" height="65" alt="image" src="https://github.com/user-attachments/assets/0e8cac19-4052-4c1d-aed6-6328afb351e6" />

Líneas sin Comentarios: muestra todas las líneas del archivo Proyectos/app/main.py que NO (-v) comiencen con el símbolo de comentario (#). (Pista: usa la expresión regular ^# para indicar "empieza por #").

<img width="635" height="101" alt="image" src="https://github.com/user-attachments/assets/a493c8b5-088c-4094-ba67-2cfd7a6dc2ac" />

## II. Ejercicios con find (Búsqueda de Archivos por Propiedad)

Archivos de Configuración: busca todos los archivos que terminen con la extensión .ini en todo el directorio de la práctica.

<img width="459" height="64" alt="image" src="https://github.com/user-attachments/assets/83eff0ca-f8d9-464d-8fc3-71f0751c5e58" />

Directorios Específicos: busca todos los elementos que sean directorios (-type d) y se llamen Logs.

<img width="473" height="69" alt="image" src="https://github.com/user-attachments/assets/505be474-0dc3-4b52-9401-5ddf117a7c6d" />

Archivos Grandes (Simulación): ejecuta truncate -s 2M Documentos/Informes/informe_final.txt. Ahora, busca todos los archivos (-type f) dentro de la práctica que sean mayores a 1 Megabyte (-size +1M).

<img width="478" height="108" alt="image" src="https://github.com/user-attachments/assets/5718f180-b017-44c4-abfb-859102b96629" />

Archivos Modificados Recientemente: busca todos los archivos (-type f) que hayan sido modificados (-mtime) en el último día (-1).

<img width="462" height="314" alt="image" src="https://github.com/user-attachments/assets/60986153-046c-40c7-91a2-29288a9139b1" />

## III. Ejercicios con locate (Búsqueda Rápida en Base de Datos)

Nota: si el comando no encuentra los archivos recién creados, se debe ejecutar sudo updatedb primero si tiene permisos.

Búsqueda General: busca rápidamente la ruta completa de todos los archivos que contienen la palabra config en su nombre.

<img width="549" height="491" alt="image" src="https://github.com/user-attachments/assets/705f5976-368e-42f1-99c1-3cc2efc7b4bf" />
<img width="425" height="52" alt="image" src="https://github.com/user-attachments/assets/b5e74d3b-f85b-476e-987a-492bcb0f9d05" />

Búsqueda Sin Distinción: busca el archivo informe_final.txt sin importar si el texto está en mayúsculas o minúsculas (-i).

<img width="470" height="60" alt="image" src="https://github.com/user-attachments/assets/9a9c980c-a8e2-43d9-87ef-72cc94c8a5c6" />


