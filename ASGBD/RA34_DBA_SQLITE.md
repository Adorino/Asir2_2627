# RA34_DBA_SQLITE- ADRIÁN MOLINA

## ENUNCIADO

Eres el DBA (administrador) de una base de datos SQLite para una pequeña aplicación de gestión de frutas en dispositivos móviles. Tendrás que configurar correctamente la base de datos, optimizar su rendimiento, realizar backups/restauraciones y garantizar la seguridad de los datos almacenados.

Log de consultas de referencia (para el apartado de optimización): https://drive.google.com/file/d/1RToxJsbzJo_mOdjcGh6ff2DMFP7RsQAA/view

## Finalidad

1. Gestionar y configurar el entorno de la base de datos SQLite.
2. Optimizar el rendimiento de la base de datos a través de diferentes técnicas de ajuste.
3. Implementar copias de seguridad y restauración.
4. Aplicar técnicas de seguridad para proteger los datos sensibles.

## Requisitos del entorno

- Instalación de SQLite: asegúrate de tener SQLite instalado en tu entorno de trabajo. Puedes verificarlo con `sqlite3 --version`.
- Crea una base de datos llamada `frutitas.db` que almacenará la información de mandarinas, melocotones y caquis.

## 1. Configuración de la base de datos (2 puntos)

#### 1.1. Creación de tablas y estructura

Crea las siguientes tablas básicas con las restricciones adecuadas:

- **Mandarinas**:
  - `id_mandarina` (INTEGER, PK, AUTOINCREMENT): identificador único para cada mandarina.
  - `color` (TEXT, NOT NULL): color de la mandarina.
  - `tipo` (TEXT, NOT NULL): tipo de mandarina.
  - `size` (TEXT, NOT NULL): tamaño de la mandarina.
  - `fecha_recogida` (DATE, NOT NULL): fecha en la que se recogió la mandarina.

<img width="667" height="182" alt="image" src="https://github.com/user-attachments/assets/24f9d205-61b5-4a10-84e9-44b22bb8f42b" />

<img width="665" height="109" alt="image" src="https://github.com/user-attachments/assets/883cb50f-5e7f-48b5-8aee-99bd6699b4be" />


- **Melocotones**:
  - `id_melocoton` (INTEGER, PK, AUTOINCREMENT): identificador único para cada melocotón.
  - `tipo` (TEXT, NOT NULL): tipo de melocotón.
  - `suavidad` (BOOLEAN, NOT NULL): indica si el melocotón es suave (1) o no (0).

 <img width="665" height="43" alt="image" src="https://github.com/user-attachments/assets/3fdb09c0-54df-4f6c-93e7-6c18df229405" />

<img width="665" height="80" alt="image" src="https://github.com/user-attachments/assets/528926f0-fbfd-426a-93fa-af8e843ce6ad" />

- **Caquis**:
  - `id_caqui` (INTEGER, PK, AUTOINCREMENT): identificador único para cada caqui.
  - `id_mandarina` (INTEGER, FK, NOT NULL): relacionado con `id_mandarina` en la tabla mandarinas.
  - `id_melocoton` (INTEGER, FK, NOT NULL): relacionado con `id_melocoton` en la tabla melocotones.
  - `color` (TEXT, NOT NULL): color del caqui.
  - `pedunculo` (BOOLEAN, NOT NULL): indica si el caqui tiene pedúnculo (1) o no (0).
  - `tiempo_maduracion` (INTEGER, NOT NULL): tiempo de maduración en días.

Dejamos las foreign key al final para evitar problemas.

<img width="667" height="105" alt="image" src="https://github.com/user-attachments/assets/ccbcfcf9-f590-4449-a9a8-c0eb51408639" />

<img width="668" height="71" alt="image" src="https://github.com/user-attachments/assets/cb5eba63-e1dc-4630-a584-463f35c8f62a" />



### 1.2. Tamaño y más

Justifica cuánto ocupa la base de datos en disco. ¿En qué momento aumenta de tamaño si se mete más info? ¿Cómo harías algo para optimizar eso?

<img width="649" height="109" alt="image" src="https://github.com/user-attachments/assets/bf284754-c83e-4ea4-bf64-a37ab940b145" />

20 KB ÷ 4 KB = 5 páginas exactas.

La página 1 contiene la cabecera de la base de datos (100 bytes) y la tabla maestra (sqlite_schema) donde se guarda la estructura (CREATE TABLE) de tus tablas (Mandarinas, Melocotones, Caquis). Cada tabla nueva y cada índice (como los creados automáticamente por AUTOINCREMENT) reserva al menos una página completa (4 KB), aunque todavía esté vacía o tenga pocos registros.

## 2. Optimización del rendimiento y mantenimiento (5 puntos)

Se ha encontrado un trozo de log de consultas a la base de datos durante el día 27 de octubre de 2024 (enlace arriba). Se pide qué optimizaciones realizarías y por qué, para mejorar la base de datos en función de la información que te ofrece el log, y justifícalo.

**PISTA:** utiliza `EXPLAIN QUERY PLAN` y revisa todos los pragmas de SQLite.

<img width="667" height="299" alt="image" src="https://github.com/user-attachments/assets/6647beba-397a-4924-a125-e0ccce52791d" />

Para la optimización, he creado índices.

<img width="661" height="232" alt="image" src="https://github.com/user-attachments/assets/dcefaf0c-9f99-4496-9230-a79bfaf60701" />

También se pueden llevar a cabos configuraciones PRAGMA para cambiar requisitos o uso de RAM.

<img width="410" height="219" alt="image" src="https://github.com/user-attachments/assets/d5b69722-e997-438a-bb79-661b3a47ce4b" />

## 3. Copias de seguridad y restauración (2.5 puntos)

### 3.1. Realización de una copia de seguridad con el nombre `frutitas_bonitas_bonitas.db`

Yo usé el comando de { sqlite3 origen.db ".backup 'copia_seguridad.db'" } , cambiándolo con mis valores, como se puede ver se creó la copia de seguridad.

<img width="627" height="306" alt="image" src="https://github.com/user-attachments/assets/3cd96d4f-dc18-4b90-91f2-6cd48240dd64" />

### 3.2. Realiza la restauración desde la copia de seguridad

Usaria este comando: sqlite3 base_destino.db ".restore 'copia_seguridad.db'"

<img width="667" height="48" alt="image" src="https://github.com/user-attachments/assets/2843cc67-0932-4dcc-9c1b-8ba377268477" />

Se puede hacer de esta forma o con el comando de cp frutitas_bonitas_bonitas.db frutitas.db

### 3.3. Automatización de backups

Entraremos en /home/alumno/backup_frutitas.sh con nano /home/alumno/backup_frutitas.sh y en el añadimos el siguiente script.

<img width="595" height="250" alt="image" src="https://github.com/user-attachments/assets/ee8d9d28-8051-4cf2-945d-c9a1a8fde217" />

<img width="553" height="204" alt="image" src="https://github.com/user-attachments/assets/4c436c90-2414-4319-9a03-386426103077" />

<img width="654" height="443" alt="image" src="https://github.com/user-attachments/assets/23297e6d-fd2d-4f9b-85bc-f60c4e067936" />

Crea un script para backups automáticos que se ejecute todos los días a las 23:59:59.

## 4. Preguntas sin ChatGPT ni IAs (0.5 puntos)

### ¿Cómo impactan los cambios en el PRAGMA en el rendimiento y la seguridad de la base de datos?
  Aceleran la base de datos usando más RAM y menos disco, aunque reducen ligeramente la durabilidad ante cortes eléctricos y refuerzan la integridad con foreign_keys = ON.

### ¿Qué mecanismos adicionales usarías para proteger una base de datos SQLite en un entorno de producción?
  Aplicar permisos estrictos de archivo, cifrado (SQLCipher), consultas parametrizadas, conexiones de solo lectura y copias en caliente (VACUUM INTO).

### ¿Qué diferencia existe entre los modos de journaling como DELETE, TRUNCATE y WAL en SQLite?
  DELETE borra el journal y TRUNCATE lo vacía a cero (bloqueando lecturas), mientras WAL escribe en un archivo aparte permitiendo lecturas y escrituras concurrentes.


## Ejercicios de clase.

### Princesas Disney 
Una empresa de ocio quiere guardar en una base de datos su catálogo de princesas de Disney. De cada princesa interesa su nombre, que la identifica, y su color de pelo. Toda princesa es natural de un único reino, aunque hay reinos en los que todavía no consta ninguna princesa. Los reinos se distinguen por su nombre y tienen una moneda oficial.

Las películas se identifican por su título y se registran también su año de estreno y su duración en minutos. Toda princesa del catálogo aparece al menos en una película, y una misma princesa puede aparecer en varias, incluso en cameos de pocos minutos. Toda película tiene al menos una princesa en su reparto.

Por último, algunas películas no se desarrollan en ningún reino concreto, pero las que sí lo hacen se ambientan en uno solo, y un mismo reino puede servir de escenario a muchas películas.
[Crear en sqlite la base de datos]

Primero he activado las foreign keys

<img width="487" height="86" alt="image" src="https://github.com/user-attachments/assets/0abf2769-c1b2-4a2b-8876-707b60b90692" />

Tabla de reinos:

<img width="665" height="34" alt="image" src="https://github.com/user-attachments/assets/c47def0f-a806-422d-8dc5-84d47f726725" />

Tabla de princesas:

<img width="665" height="48" alt="image" src="https://github.com/user-attachments/assets/4742319f-2c73-4996-a775-355542612bab" />

Tabla de Peliculas:

<img width="671" height="49" alt="image" src="https://github.com/user-attachments/assets/df3f5815-1559-4b3b-a12f-86f2519fabbb" />

Tabla de resumen:

<img width="661" height="86" alt="image" src="https://github.com/user-attachments/assets/7ed71935-be67-4cfc-96cb-f7ee6a254e14" />

Añadir valores:

<img width="667" height="118" alt="image" src="https://github.com/user-attachments/assets/f0bf423d-cdac-42c9-af9e-0530ca4d8a3a" />

<img width="663" height="70" alt="image" src="https://github.com/user-attachments/assets/779db346-2da1-4454-b790-bd766cbf2a6e" />


### GTA6
Una empresa de entretenimiento quiere guardar en una base de datos el universo criminal del juego GTA VI. De cada personaje interesa su nombre, que lo identifica, y su apodo en el mundo criminal. Todo personaje pertenece a una única banda, aunque hay bandas en las que todavía no consta ningún personaje registrado. Las bandas se distinguen por su nombre y tienen una actividad ilícita principal.
Los atracos se identifican por su título y se registran también su tipo (robo de banco, contrabando, secuestro…) y su recompensa en dólares. Todo personaje del catálogo participa al menos en un atraco, y un mismo personaje puede participar en varios, incluso con pocos minutos de protagonismo. Todo atraco tiene al menos un personaje en su reparto.
Por último, algunos atracos no se desarrollan en el territorio de ninguna banda concreta, pero los que sí lo hacen tienen lugar en el territorio de una sola, y una misma banda puede ser escenario de muchos atracos.
[Crear en sqlite la base de datos]

Activamos las foreign keys en pragma para usarlas.

<img width="399" height="52" alt="image" src="https://github.com/user-attachments/assets/e99d39a0-4089-4ca5-be67-b7dbcc79c49d" />

Tabla de bandas: 

<img width="669" height="38" alt="image" src="https://github.com/user-attachments/assets/cbca13e4-ce76-4f10-8a42-d72ad12e5796" />

Tabla personajes:

<img width="667" height="49" alt="image" src="https://github.com/user-attachments/assets/b128b71a-7fab-481f-ad79-a2db621f9208" />

Tabla atracos:

<img width="665" height="52" alt="image" src="https://github.com/user-attachments/assets/ed45dc59-5a58-4a10-a846-e0efb9503d27" />

Tabla de participaciones:

<img width="670" height="91" alt="image" src="https://github.com/user-attachments/assets/709150cf-2a2c-40e6-8bf0-292b24a191bd" />

Insertamos los datos:

<img width="666" height="65" alt="image" src="https://github.com/user-attachments/assets/7593b062-1655-4025-bc5c-e0f9d6ef58bf" />

<img width="667" height="69" alt="image" src="https://github.com/user-attachments/assets/8e8544c4-6d5c-4ef1-a0dd-c8f60f818b07" />

<img width="663" height="83" alt="image" src="https://github.com/user-attachments/assets/b06ab70c-0405-4053-b037-7591d3c798a5" />

<img width="663" height="101" alt="image" src="https://github.com/user-attachments/assets/0df706db-a1d0-484d-8fc1-31a9a5496b3d" />

