FASE 1: Permisos de Archivos en Linux

#Ejercicio 1: Gestión de Permisos en un Entorno de Trabajo Multiusuario
Escenario: imagina que eres el administrador de un equipo de desarrollo con varios usuarios, y necesitas configurar los permisos de un proyecto compartido entre tres usuarios: monon1, tronko2 y birmingan3. Cada uno debe tener permisos específicos para un directorio de proyecto, de acuerdo con su rol.

#Paso 1: Crear un entorno simulado de usuarios y grupos. Crea los tres usuarios y un grupo común llamado devEria2. Crea un directorio llamado di_recto para el proyecto y cambia el grupo propietario a devEria2.
Aqui se pueden ver los comandos usados para crear los tres usuarios. 
<img width="448" height="207" alt="image" src="https://github.com/user-attachments/assets/2df7c159-9042-4c69-96d3-9f9bc8d73a3c" />
Aqui se puede ver como creé el grupo de devEra2 y como añadi dichos usuarios al grupo.
<img width="393" height="192" alt="image" src="https://github.com/user-attachments/assets/8ac611ca-7328-4ac9-84fd-e6e4d0d0bcb8" />
Ahora creé el directorio y cambié el propietario de dicho directorio usando el comando de chgrp.
<img width="348" height="103" alt="image" src="https://github.com/user-attachments/assets/3da25212-9aa1-455b-9cc3-5a8853ea2e7b" />

#Paso 2: Configuración de permisos básicos. Configura los permisos para que solo los usuarios del grupo devEria2 puedan escribir en el directorio. Verifica mostrando los permisos del directorio.
Aqui se puede ver como configureré los permisos basicos, dandole permisos a los integrantes del grupo de devEria2 y sin darle permisos a otro, por eso 770.
<img width="531" height="110" alt="image" src="https://github.com/user-attachments/assets/37ea4efe-2213-4ea9-af5b-ae182471a446" />

#Paso 3: Configuración de permisos avanzados. monon1 debe tener permisos completos (lectura, escritura, ejecución) en todo el proyecto: cambia el propietario del directorio a monon1. Los otros dos usuarios del grupo solo deben poder leer y ejecutar archivos, pero no modificarlos: cambia los permisos de modo que el grupo devEria2 solo tenga permisos de lectura y ejecución.
SE cambiará el propietario dle directorio a monon1 usando el comando de chwon, Se cambiarán los pemrisos, haciendo que el propietario tenga todos los permisos, y los permisos del grupo sea de lectura y ejecución, un 5.
<img width="506" height="161" alt="image" src="https://github.com/user-attachments/assets/020e2d80-22f4-43d5-8476-04f57e947e94" />

Preguntas:

¿Qué sucede si un usuario fuera del grupo devEria2 intenta acceder al directorio?
No tendrá permiso de acceso, como se puede ver en la imagen.
<img width="347" height="64" alt="image" src="https://github.com/user-attachments/assets/ff6cb650-f9da-4d8e-bb53-bb551139c121" />

¿Qué sucede si tronko2 intenta modificar un archivo dentro del directorio?
El tampoco tiene permisos de modificacion, como se puede ver en la imagen.
