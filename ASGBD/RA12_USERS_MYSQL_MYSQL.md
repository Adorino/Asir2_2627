RA12_USERS_MYSQL
ENUNCIADO
Realiza en MySQL/MariaDB en Kali Linux la gestión completa de usuarios y permisos sobre una base de datos de red social.

Teoría de referencia (pública): teoria-administracion-mysql.html.

Esquema inicial: base de datos red_social

| usuario |	grupo |	comentario |
| PK id_usuario (INT)	| PK id_grupo (INT)	| PK id_comentario (INT) |
| nombre (VARCHAR) |	nombre_grupo (VARCHAR) |	FK usuario_id (INT) |
| email (VARCHAR) |	FK creador_id (INT) |	FK grupo_id (INT) |
| fecha_registro (DATE) |	fecha_creacion (DATE)	| texto (TEXT) |

Relaciones (claves foráneas)
USUARIO ← GRUPO (1 a N): GRUPO.creador_id referencia a USUARIO.id_usuario. Un usuario crea muchos grupos, pero un grupo tiene solo un creador.
USUARIO ← COMENTARIO (1 a N): COMENTARIO.usuario_id referencia a USUARIO.id_usuario. Un usuario escribe muchos comentarios.
GRUPO ← COMENTARIO (1 a N): COMENTARIO.grupo_id referencia a GRUPO.id_grupo. Un grupo contiene muchos comentarios.
Para cada ejercicio, presenta evidencia de pantallazo con comando y resultado, y lo que se considere necesario.

Ejercicios
Indica el nombre de las tablas que aparecen en tu base de datos mysql.
<img width="303" height="195" alt="image" src="https://github.com/user-attachments/assets/c5ad60a5-50c1-481b-b1ea-8bf95d0b3150" />
<img width="253" height="189" alt="image" src="https://github.com/user-attachments/assets/3950884f-42c2-4a3c-8c6f-f74dd5d78cf5" />

Crea el usuario "Bego" con contraseña "Beglña" para que pueda acceder desde localhost.
Crea el usuario "Mati" con contraseña "aMti90" para que pueda acceder desde el dominio lasalleinstitucion.es.
Crea el usuario "Mifli" con contraseña "lopol45" para que pueda acceder desde el dominio lasalleinstitucion.es.
<img width="614" height="146" alt="image" src="https://github.com/user-attachments/assets/8740d494-7410-4b7b-ac25-5465c5dc4df8" />

Muestra los usuarios creados (los que están en la tabla user de la base de datos mysql). Indica la sentencia que has utilizado para mostrar esos usuarios.
<img width="460" height="292" alt="image" src="https://github.com/user-attachments/assets/d2ad4f9e-74d0-4d8c-92df-f93f9194ce05" />

Muestra el usuario con el que te has logado, utilizando para ello una función. Indica la sentencia que has utilizado para ello.
<img width="414" height="134" alt="image" src="https://github.com/user-attachments/assets/f89398fe-fa65-419a-8286-f80346943330" />

Cambia la contraseña de Mati, de manera que la nueva contraseña sea "minuevacontraseña". Indica la sentencia que has utilizado para ello.
<img width="631" height="75" alt="image" src="https://github.com/user-attachments/assets/ee0b26eb-9c30-4613-833b-343e6b1a2b8b" />

Muestra los privilegios del usuario Bego. Indica la sentencia que has utilizado para ello.
<img width="620" height="150" alt="image" src="https://github.com/user-attachments/assets/6c5ec262-b231-445c-a4de-f253dad97c55" />

Muestra los privilegios del usuario con el que te has logado. Indica la sentencia que has utilizado para ello.
<img width="615" height="369" alt="image" src="https://github.com/user-attachments/assets/1757f19c-e07c-4e3e-ab4b-ba2c023aad70" />

Concede permisos al usuario Bego de lectura y actualización sobre la tabla usuario.
<img width="598" height="72" alt="image" src="https://github.com/user-attachments/assets/eb6997c3-eb6c-40a5-911a-5ead6447b376" />

Conéctate como Bego y lanza una sentencia select y otra update sobre la tabla usuario. Lanza también una sentencia delete. Muestra las sentencias y sus efectos sobre la base de datos de la red social.
<img width="621" height="234" alt="image" src="https://github.com/user-attachments/assets/bf1ac2ef-3bdd-47ed-a004-e8e2dd71d04b" />
<img width="619" height="305" alt="image" src="https://github.com/user-attachments/assets/683c3188-f6f9-45e6-8439-a11658334b9d" />
<img width="632" height="72" alt="image" src="https://github.com/user-attachments/assets/f31deb1c-6172-4a31-bc2b-fff505400e86" />

Concede permisos al usuario Mati de borrado sobre la tabla grupo.
<img width="623" height="281" alt="image" src="https://github.com/user-attachments/assets/e63552f0-d936-471c-9301-81ce37db5561" />

Crea el usuario Crispula con contraseña "rosita" para que pueda acceder desde el dominio lasalleinstitucion.es y con permiso de lectura, actualización y borrado sobre las tablas usuario, grupo y comentario. Concede además permisos a Crispula para que pueda conceder sus permisos a otros usuarios.
<img width="633" height="127" alt="image" src="https://github.com/user-attachments/assets/6e2bb3d6-a2b6-4150-b640-898e12001e77" />

Conéctate con el usuario Crispula.


Inserta un registro en la tabla comentario. Actualiza un registro de la tabla grupo. Muestra las sentencias y su resultado al ejecutarlas sobre la base de datos de la red social.
Concede permiso de borrado sobre la tabla usuario a Bego. Muestra la sentencia utilizada y el resultado de su ejecución.
Concede permiso de lectura y actualización sobre la tabla grupo a Mati. Muestra la sentencia utilizada y el resultado de su ejecución.
Vuelve a conectarte con tu usuario de mysql.
Concede permisos totales sobre todas las tablas de la base de datos de la red social a Mifli. Muestra la sentencia utilizada y el resultado de su ejecución.
Quítale permisos de borrado sobre todas las tablas de la base de datos de la red social a Mifli. Muestra la sentencia utilizada y el resultado de su ejecución.
Muestra los usuarios creados y sus privilegios (los que están en la tabla user de la base de datos mysql). Indica la sentencia que has utilizado para mostrar esos usuarios.
Cambia la contraseña del usuario Mifli modificando directamente la tabla user. Indica la sentencia que has utilizado para ello.
¿Has necesitado hacer FLUSH PRIVILEGES después de la sentencia anterior? Explica el porqué y para qué sirve FLUSH PRIVILEGES.
¿Puedo utilizar la función PASSWORD con GRANT? Justifica tu respuesta.
Elimina el usuario Mifli. Muestra la sentencia utilizada y el resultado de su ejecución.
Entrega
