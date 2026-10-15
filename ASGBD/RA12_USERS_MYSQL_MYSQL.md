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

<img width="626" height="266" alt="image" src="https://github.com/user-attachments/assets/71b8c867-029e-4648-9012-a445414901ac" />

Para escuchar todas las interfaces de red, tengo que cambiar este parámetro, estaba en 127.0.0.1 a 0.0.0.0, lo que hará que escuche todos.
<img width="634" height="363" alt="image" src="https://github.com/user-attachments/assets/c72ec0f2-3273-4318-a887-7e340d6b4a25" />


Conéctate con el usuario Crispula.

<img width="602" height="478" alt="image" src="https://github.com/user-attachments/assets/19794e31-615c-45ab-bef2-c576d74d8cf5" />

Inserta un registro en la tabla comentario. Actualiza un registro de la tabla grupo. 

<img width="539" height="235" alt="image" src="https://github.com/user-attachments/assets/df135a39-68d7-4936-8bc4-99326303c38b" />

<img width="625" height="174" alt="image" src="https://github.com/user-attachments/assets/25be824c-e9fe-4a51-9dde-b4433e1e3c6f" />

<img width="626" height="149" alt="image" src="https://github.com/user-attachments/assets/b2abf7f8-3276-4c78-b0e9-504a0d8fb4a8" />


Muestra las sentencias y su resultado al ejecutarlas sobre la base de datos de la red social.

<img width="592" height="269" alt="image" src="https://github.com/user-attachments/assets/e6dcc9e9-9a0d-4512-893a-1e12fecf03e8" />

<img width="1009" height="320" alt="image" src="https://github.com/user-attachments/assets/0c7ab67f-f06a-4803-964d-786000f043e3" />

Concede permiso de borrado sobre la tabla usuario a Bego. Muestra la sentencia utilizada y el resultado de su ejecución.

<img width="694" height="209" alt="image" src="https://github.com/user-attachments/assets/b518780b-84cb-42db-97d4-38f6357ca8c5" />

Concede permiso de lectura y actualización sobre la tabla grupo a Mati. Muestra la sentencia utilizada y el resultado de su ejecución.

<img width="678" height="196" alt="image" src="https://github.com/user-attachments/assets/be195764-7a9f-47ed-95d4-dbcb75d596b5" />

Vuelve a conectarte con tu usuario de mysql.

<img width="628" height="418" alt="image" src="https://github.com/user-attachments/assets/a1e985b2-f362-4e52-b08e-984b1a75739b" />

Concede permisos totales sobre todas las tablas de la base de datos de la red social a Mifli. Muestra la sentencia utilizada y el resultado de su ejecución.

<img width="659" height="205" alt="image" src="https://github.com/user-attachments/assets/a3c04a27-e084-492f-89e7-24689e182b65" />

<img width="1002" height="298" alt="image" src="https://github.com/user-attachments/assets/f0d34757-7335-433f-a127-d8ceda31b2ec" />


Quítale permisos de borrado sobre todas las tablas de la base de datos de la red social a Mifli. Muestra la sentencia utilizada y el resultado de su ejecución.

<img width="1007" height="298" alt="image" src="https://github.com/user-attachments/assets/e3dff286-1c28-431c-bc8d-f5c68b421f4b" />

Muestra los usuarios creados y sus privilegios (los que están en la tabla user de la base de datos mysql). Indica la sentencia que has utilizado para mostrar esos usuarios.

<img width="1001" height="295" alt="image" src="https://github.com/user-attachments/assets/8ec1c210-d379-4b5d-b377-0bc4dfa02991" />

<img width="961" height="572" alt="image" src="https://github.com/user-attachments/assets/5516dabf-4dee-4a69-8ee7-06718f941529" />

Cambia la contraseña del usuario Mifli modificando directamente la tabla user. Indica la sentencia que has utilizado para ello.

<img width="620" height="41" alt="image" src="https://github.com/user-attachments/assets/6713fc35-4308-474c-afc7-dfe6f133eb53" />

¿Has necesitado hacer FLUSH PRIVILEGES después de la sentencia anterior? Explica el porqué y para qué sirve FLUSH PRIVILEGES.

No es necesario ejecutar FLUSH PRIVILEGES cuando se modifica la contraseña mediante ALTER USER, ya que el servidor aplica los cambios a través del mecanismo de administración de cuentas. Cuando se modifican directamente las tablas de privilegios, puede ser necesario recargarlas, dependiendo de la versión y del método utilizado.

¿Puedo utilizar la función PASSWORD con GRANT? Justifica tu respuesta.
No se debe utilizar PASSWORD() con GRANT de forma indiscriminada, porque su disponibilidad y la sintaxis admitida dependen de la versión. La forma recomendada es establecer la contraseña mediante CREATE USER o ALTER USER con IDENTIFIED BY y conceder los privilegios con GRANT.

Elimina el usuario Mifli. Muestra la sentencia utilizada y el resultado de su ejecución.

<img width="530" height="95" alt="image" src="https://github.com/user-attachments/assets/5f4d18a7-9212-4e22-95ef-8a36319250d7" />

Entrega
