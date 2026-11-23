# RA34_DBA_SQLITE- ADRIÁN MOLINA

## ENUNCIADO

Eres el DBA (administrador) de una base de datos SQLite para una pequeña aplicación de gestión de frutas en dispositivos móviles. Tendrás que configurar correctamente la base de datos, optimizar su rendimiento, realizar backups/restauraciones y garantizar la seguridad de los datos almacenados.

Log de consultas de referencia (para el apartado de optimización): https://drive.google.com/file/d/1RToxJsbzJo_mOdjcGh6ff2DMFP7RsQAA/view

### Finalidad

1. Gestionar y configurar el entorno de la base de datos SQLite.
2. Optimizar el rendimiento de la base de datos a través de diferentes técnicas de ajuste.
3. Implementar copias de seguridad y restauración.
4. Aplicar técnicas de seguridad para proteger los datos sensibles.

### Requisitos del entorno

- Instalación de SQLite: asegúrate de tener SQLite instalado en tu entorno de trabajo. Puedes verificarlo con `sqlite3 --version`.
- Crea una base de datos llamada `frutitas.db` que almacenará la información de mandarinas, melocotones y caquis.

### 1. Configuración de la base de datos (2 puntos)

#### 1.1. Creación de tablas y estructura

Crea las siguientes tablas básicas con las restricciones adecuadas:

- **Mandarinas**:
  - `id_mandarina` (INTEGER, PK, AUTOINCREMENT): identificador único para cada mandarina.
  - `color` (TEXT, NOT NULL): color de la mandarina.
  - `tipo` (TEXT, NOT NULL): tipo de mandarina.
  - `size` (TEXT, NOT NULL): tamaño de la mandarina.
  - `fecha_recogida` (DATE, NOT NULL): fecha en la que se recogió la mandarina.

<img width="667" height="182" alt="image" src="https://github.com/user-attachments/assets/24f9d205-61b5-4a10-84e9-44b22bb8f42b" />

- **Melocotones**:
  - `id_melocoton` (INTEGER, PK, AUTOINCREMENT): identificador único para cada melocotón.
  - `tipo` (TEXT, NOT NULL): tipo de melocotón.
  - `suavidad` (BOOLEAN, NOT NULL): indica si el melocotón es suave (1) o no (0).

 <img width="665" height="43" alt="image" src="https://github.com/user-attachments/assets/3fdb09c0-54df-4f6c-93e7-6c18df229405" />

- **Caquis**:
  - `id_caqui` (INTEGER, PK, AUTOINCREMENT): identificador único para cada caqui.
  - `id_mandarina` (INTEGER, FK, NOT NULL): relacionado con `id_mandarina` en la tabla mandarinas.
  - `id_melocoton` (INTEGER, FK, NOT NULL): relacionado con `id_melocoton` en la tabla melocotones.
  - `color` (TEXT, NOT NULL): color del caqui.
  - `pedunculo` (BOOLEAN, NOT NULL): indica si el caqui tiene pedúnculo (1) o no (0).
  - `tiempo_maduracion` (INTEGER, NOT NULL): tiempo de maduración en días.

Dejamos las foreign key al final para evitar problemas.

<img width="667" height="105" alt="image" src="https://github.com/user-attachments/assets/ccbcfcf9-f590-4449-a9a8-c0eb51408639" />

#### 1.2. Tamaño y más

Justifica cuánto ocupa la base de datos en disco. ¿En qué momento aumenta de tamaño si se mete más info? ¿Cómo harías algo para optimizar eso?

<img width="649" height="109" alt="image" src="https://github.com/user-attachments/assets/bf284754-c83e-4ea4-bf64-a37ab940b145" />

20 KB ÷ 4 KB = 5 páginas exactas.

La página 1 contiene la cabecera de la base de datos (100 bytes) y la tabla maestra (sqlite_schema) donde se guarda la estructura (CREATE TABLE) de tus tablas (Mandarinas, Melocotones, Caquis). Cada tabla nueva y cada índice (como los creados automáticamente por AUTOINCREMENT) reserva al menos una página completa (4 KB), aunque todavía esté vacía o tenga pocos registros.

### 2. Optimización del rendimiento y mantenimiento (5 puntos)

Se ha encontrado un trozo de log de consultas a la base de datos durante el día 27 de octubre de 2024 (enlace arriba). Se pide qué optimizaciones realizarías y por qué, para mejorar la base de datos en función de la información que te ofrece el log, y justifícalo.

**PISTA:** utiliza `EXPLAIN QUERY PLAN` y revisa todos los pragmas de SQLite.

### 3. Copias de seguridad y restauración (2.5 puntos)

#### 3.1. Realización de una copia de seguridad con el nombre `frutitas_bonitas_bonitas.db`

<img width="627" height="306" alt="image" src="https://github.com/user-attachments/assets/3cd96d4f-dc18-4b90-91f2-6cd48240dd64" />

#### 3.2. Realiza la restauración desde la copia de seguridad

<img width="667" height="48" alt="image" src="https://github.com/user-attachments/assets/2843cc67-0932-4dcc-9c1b-8ba377268477" />

Se puede hacer de esta forma o con el comando de cp frutitas_bonitas_bonitas.db frutitas.db

#### 3.3. Automatización de backups

Entraremos en /home/alumno/backup_frutitas.sh con nano /home/alumno/backup_frutitas.sh y en el añadimos el siguiente script.

<img width="595" height="250" alt="image" src="https://github.com/user-attachments/assets/ee8d9d28-8051-4cf2-945d-c9a1a8fde217" />

<img width="553" height="204" alt="image" src="https://github.com/user-attachments/assets/4c436c90-2414-4319-9a03-386426103077" />

<img width="654" height="443" alt="image" src="https://github.com/user-attachments/assets/23297e6d-fd2d-4f9b-85bc-f60c4e067936" />


Crea un script para backups automáticos que se ejecute todos los días a las 23:59:59.

### 4. Preguntas sin ChatGPT ni IAs (0.5 puntos)

- ¿Cómo impactan los cambios en el PRAGMA en el rendimiento y la seguridad de la base de datos?
- ¿Qué mecanismos adicionales usarías para proteger una base de datos SQLite en un entorno de producción?
- ¿Qué diferencia existe entre los modos de journaling como DELETE, TRUNCATE y WAL en SQLite?

