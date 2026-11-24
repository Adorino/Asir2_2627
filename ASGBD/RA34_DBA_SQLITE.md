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



#### 1.2. Tamaño y más

Justifica cuánto ocupa la base de datos en disco. ¿En qué momento aumenta de tamaño si se mete más info? ¿Cómo harías algo para optimizar eso?

<img width="649" height="109" alt="image" src="https://github.com/user-attachments/assets/bf284754-c83e-4ea4-bf64-a37ab940b145" />

20 KB ÷ 4 KB = 5 páginas exactas.

La página 1 contiene la cabecera de la base de datos (100 bytes) y la tabla maestra (sqlite_schema) donde se guarda la estructura (CREATE TABLE) de tus tablas (Mandarinas, Melocotones, Caquis). Cada tabla nueva y cada índice (como los creados automáticamente por AUTOINCREMENT) reserva al menos una página completa (4 KB), aunque todavía esté vacía o tenga pocos registros.

### 2. Optimización del rendimiento y mantenimiento (5 puntos)

Se ha encontrado un trozo de log de consultas a la base de datos durante el día 27 de octubre de 2024 (enlace arriba). Se pide qué optimizaciones realizarías y por qué, para mejorar la base de datos en función de la información que te ofrece el log, y justifícalo.

**PISTA:** utiliza `EXPLAIN QUERY PLAN` y revisa todos los pragmas de SQLite.

<img width="667" height="299" alt="image" src="https://github.com/user-attachments/assets/6647beba-397a-4924-a125-e0ccce52791d" />

Para la optimización, he creado índices.

<img width="661" height="232" alt="image" src="https://github.com/user-attachments/assets/dcefaf0c-9f99-4496-9230-a79bfaf60701" />

También se pueden llevar a cabos configuraciones PRAGMA para cambiar requisitos o uso de RAM.

<img width="410" height="219" alt="image" src="https://github.com/user-attachments/assets/d5b69722-e997-438a-bb79-661b3a47ce4b" />

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

- ¿Cómo impactan los cambios en el PRAGMA en el rendimiento y la seguridad de la base de datos?= Aceleran la base de datos usando más RAM y menos disco, aunque reducen ligeramente la durabilidad ante cortes eléctricos y refuerzan la integridad con foreign_keys = ON.

- ¿Qué mecanismos adicionales usarías para proteger una base de datos SQLite en un entorno de producción?= •  Aplicar permisos estrictos de archivo, cifrado (SQLCipher), consultas parametrizadas, conexiones de solo lectura y copias en caliente (VACUUM INTO).

- ¿Qué diferencia existe entre los modos de journaling como DELETE, TRUNCATE y WAL en SQLite?= • DELETE borra el journal y TRUNCATE lo vacía a cero (bloqueando lecturas), mientras WAL escribe en un archivo aparte permitiendo lecturas y escrituras concurrentes.


### Ejercicios de clase.

#### Princesas Disney 
Una empresa de ocio quiere guardar en una base de datos su catálogo de princesas de Disney. De cada princesa interesa su nombre, que la identifica, y su color de pelo. Toda princesa es natural de un único reino, aunque hay reinos en los que todavía no consta ninguna princesa. Los reinos se distinguen por su nombre y tienen una moneda oficial.

Las películas se identifican por su título y se registran también su año de estreno y su duración en minutos. Toda princesa del catálogo aparece al menos en una película, y una misma princesa puede aparecer en varias, incluso en cameos de pocos minutos. Toda película tiene al menos una princesa en su reparto.

Por último, algunas películas no se desarrollan en ningún reino concreto, pero las que sí lo hacen se ambientan en uno solo, y un mismo reino puede servir de escenario a muchas películas.
[Crear en sqlite la base de datos]

-- Activar el soporte de claves foráneas en SQLite
PRAGMA foreign_keys = ON;

-- 1. Tabla Reinos
CREATE TABLE Reinos (
    nombre TEXT PRIMARY KEY,
    moneda_oficial TEXT NOT NULL
);

-- 2. Tabla Princesas
-- Toda princesa es natural de un único reino (NOT NULL)
CREATE TABLE Princesas (
    nombre TEXT PRIMARY KEY,
    color_pelo TEXT NOT NULL,
    nombre_reino TEXT NOT NULL,
    FOREIGN KEY (nombre_reino) REFERENCES Reinos(nombre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- 3. Tabla Peliculas
-- Algunas películas no tienen reino (permite NULL)
CREATE TABLE Peliculas (
    titulo TEXT PRIMARY KEY,
    anio_estreno INTEGER NOT NULL,
    duracion_minutos INTEGER NOT NULL CHECK (duracion_minutos > 0),
    nombre_reino TEXT,
    FOREIGN KEY (nombre_reino) REFERENCES Reinos(nombre)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

-- 4. Tabla intermedia (Relación N:M Princesas - Peliculas)
CREATE TABLE Princesa_Pelicula (
    nombre_princesa TEXT NOT NULL,
    titulo_pelicula TEXT NOT NULL,
    minutos_aparicion INTEGER NOT NULL CHECK (minutos_aparicion > 0),
    PRIMARY KEY (nombre_princesa, titulo_pelicula),
    FOREIGN KEY (nombre_princesa) REFERENCES Princesas(nombre)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (titulo_pelicula) REFERENCES Peliculas(titulo)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

INSERT INTO Reinos (nombre, moneda_oficial) VALUES 
    ('Arendelle', 'Corona'),
    ('Atlántica', 'Concha de oro'),
    ('Corona', 'Moneda solar'); -- Reino sin princesas aún

INSERT INTO Princesas (nombre, color_pelo, nombre_reino) VALUES 
    ('Elsa', 'Rubio platino', 'Arendelle'),
    ('Ariel', 'Pelirrojo', 'Atlántica');

INSERT INTO Peliculas (titulo, anio_estreno, duracion_minutos, nombre_reino) VALUES 
    ('Frozen', 2013, 102, 'Arendelle'),
    ('La Sirenita', 1989, 83, 'Atlántica'),
    ('Ralph rompe Internet', 2018, 112, NULL); -- Película sin reino concreto

INSERT INTO Princesa_Pelicula (nombre_princesa, titulo_pelicula, minutos_aparicion) VALUES 
    ('Elsa', 'Frozen', 45),
    ('Ariel', 'La Sirenita', 52),
    ('Elsa', 'Ralph rompe Internet', 3),   -- Cameo
    ('Ariel', 'Ralph rompe Internet', 3);  -- Cameo

#### GTA6
Una empresa de entretenimiento quiere guardar en una base de datos el universo criminal del juego GTA VI. De cada personaje interesa su nombre, que lo identifica, y su apodo en el mundo criminal. Todo personaje pertenece a una única banda, aunque hay bandas en las que todavía no consta ningún personaje registrado. Las bandas se distinguen por su nombre y tienen una actividad ilícita principal.
Los atracos se identifican por su título y se registran también su tipo (robo de banco, contrabando, secuestro…) y su recompensa en dólares. Todo personaje del catálogo participa al menos en un atraco, y un mismo personaje puede participar en varios, incluso con pocos minutos de protagonismo. Todo atraco tiene al menos un personaje en su reparto.
Por último, algunos atracos no se desarrollan en el territorio de ninguna banda concreta, pero los que sí lo hacen tienen lugar en el territorio de una sola, y una misma banda puede ser escenario de muchos atracos.
[Crear en sqlite la base de datos]

-- Activar restricciones de claves foráneas
PRAGMA foreign_keys = ON;

-- 1. Tabla Bandas
CREATE TABLE Bandas (
    nombre TEXT PRIMARY KEY,
    actividad_ilicita TEXT NOT NULL
);

-- 2. Tabla Personajes
-- Todo personaje pertenece obligatoriamente a una única banda (NOT NULL)
CREATE TABLE Personajes (
    nombre TEXT PRIMARY KEY,
    apodo TEXT NOT NULL,
    nombre_banda TEXT NOT NULL,
    FOREIGN KEY (nombre_banda) REFERENCES Bandas(nombre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- 3. Tabla Atracos
-- Algunos atracos no tienen territorio de banda (permite NULL)
CREATE TABLE Atracos (
    titulo TEXT PRIMARY KEY,
    tipo TEXT NOT NULL,
    recompensa_dolares INTEGER NOT NULL CHECK (recompensa_dolares > 0),
    nombre_banda_territorio TEXT,
    FOREIGN KEY (nombre_banda_territorio) REFERENCES Bandas(nombre)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

-- 4. Tabla intermedia (Relación N:M Personajes - Atracos)
CREATE TABLE Participaciones (
    nombre_personaje TEXT NOT NULL,
    titulo_atraco TEXT NOT NULL,
    minutos_protagonismo INTEGER NOT NULL CHECK (minutos_protagonismo > 0),
    PRIMARY KEY (nombre_personaje, titulo_atraco),
    FOREIGN KEY (nombre_personaje) REFERENCES Personajes(nombre)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (titulo_atraco) REFERENCES Atracos(titulo)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- Bandas inventadas (incluyendo una sin personajes registrados)
INSERT INTO Bandas (nombre, actividad_ilicita) VALUES 
    ('Los Caimanes del Pantano', 'Contrabando fluvial'),
    ('Sindicato Neón', 'Ciberdelitos y lavado de activos'),
    ('Hermanos del Asfalto', 'Robo de vehículos de lujo'),
    ('Espectro Nocturno', 'Tráfico de arte'); -- Banda sin personajes aún

-- Personajes inventados
INSERT INTO Personajes (nombre, apodo, nombre_banda) VALUES 
    ('Mateo Vance', 'El Sombra', 'Los Caimanes del Pantano'),
    ('Valeria Cruz', 'Chispa', 'Sindicato Neón'),
    ('Dante Moretti', 'El Mecánico', 'Hermanos del Asfalto'),
    ('Elena Rostova', 'Víbora', 'Sindicato Neón');

-- Atracos inventados (incluyendo uno sin territorio de ninguna banda)
INSERT INTO Atracos (titulo, tipo, recompensa_dolares, nombre_banda_territorio) VALUES 
    ('Golpe al Ferry de Vice', 'Contrabando', 450000, 'Los Caimanes del Pantano'),
    ('Asalto a la Bóveda Central', 'Robo de banco', 1200000, 'Sindicato Neón'),
    ('Rescate en el Puente Sur', 'Secuestro', 300000, NULL), -- Sin territorio de banda
    ('Carrera Fantasma', 'Robo de vehículos', 600000, 'Hermanos del Asfalto');

-- Participaciones en atracos (incluyendo cameos de pocos minutos)
INSERT INTO Participaciones (nombre_personaje, titulo_atraco, minutos_protagonismo) VALUES 
    ('Mateo Vance', 'Golpe al Ferry de Vice', 35),
    ('Valeria Cruz', 'Asalto a la Bóveda Central', 42),
    ('Elena Rostova', 'Asalto a la Bóveda Central', 28),
    ('Dante Moretti', 'Carrera Fantasma', 40),
    ('Mateo Vance', 'Rescate en el Puente Sur', 20),
    ('Valeria Cruz', 'Golpe al Ferry de Vice', 3),       -- Participación breve (3 min)
    ('Dante Moretti', 'Asalto a la Bóveda Central', 4);  -- Participación breve (4 min)



