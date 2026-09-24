### Al ataque
# Aqui se verá el desarrollo de la practica de Pydictor.
Tendremos que instalar python en su ultima version antes. (sudo apt install python3).
Para esta practica vamos a simular un ataque, para ello vamos a usar la herramienta de Pydictor, que permite la creación para fuerza bruta.
<img width="656" height="280" alt="Captura de pantalla 2026-09-18 121131" src="https://github.com/user-attachments/assets/a3d8a8aa-7e6b-4778-b5da-22af30c7cbd9" />
En esta imagen se puede ver como instalé la herramienta de Pydictor usando los siguiente comandos en la terminal, en estos comandos cloné el repositorio oficial y después entré en la carpeta del programa.

Para comprobar su funcionamiento usaremos el comando de python3 pydictor.py y como se puede ver en la imagen, el comando mostró la siguiente respuesta.
"
<img width="661" height="526" alt="Captura de pantalla 2026-09-18 121317" src="https://github.com/user-attachments/assets/2efac216-05a3-4d5e-846b-bc6329fd042e" />

Ahora para instalar la segunda herramienta llamada Dymerge se usará el comando de "git clone https://github.com/k4m4/dymerge.git, después accedí al directorio que se creó igual que con Pydictor.
<img width="615" height="175" alt="Captura de pantalla 2026-09-18 121405" src="https://github.com/user-attachments/assets/dde66aa2-0f9f-405a-a586-682ccebc0f79" />

Después ejecutaremos la herramienta para comprobar su funcionamiento con el comando de "python dymerge.py -h".
<img width="627" height="402" alt="Captura de pantalla 2026-09-18 121714" src="https://github.com/user-attachments/assets/8412670d-caea-46eb-baa6-35827b71af88" />

# Segunda parte de la practica
Habrá que instalar OpenSSH, y después iniciar y configurar el servidor. Para instalarlo primero actualizaremos los repositorios con "sudo apt update" y después usaremos el comando de "sudo apt install openssh-server openssh-client -y" para instalar esta herramienta.
<img width="662" height="533" alt="Captura de pantalla 2026-09-18 122321" src="https://github.com/user-attachments/assets/9911571d-345f-41f1-be8d-22eb927952d8" />
Primero, para iniciar el servicio usaremos el comando de "sudo systemctl start ssh", para habilitar el servicio usaremos el comando de "sudo systemctl enable ssh" y para comprobar si está activo usaremos el comando de "sudo systemctl status ssh".
<img width="653" height="574" alt="Captura de pantalla 2026-09-18 122807" src="https://github.com/user-attachments/assets/bdebd511-246d-4c01-9f5c-9ac55d33c1e8" />

El archivo de configuración principal se encuentra en /etc/ssh/sshd_config. Antes de editarlo, es recomendable hacer una copia de seguridad:"sudo cp /etc/ssh/sshd_config /etc/ssh/sshd_config.bak" y después vamos a editarlo, configurandolo, usando el comando de "sudo nano /etc/ssh/sshd_config", he usado el comando cat para ver primero el contenido.
<img width="656" height="558" alt="Captura de pantalla 2026-09-18 123138" src="https://github.com/user-attachments/assets/bddf01e5-c472-44fc-a8e3-ddbdbb709c2b" />

Para crear un usuario se usará el comando de "sudo useradd -m objetivo" y para darle una contraseña usamos el comando de "sudo passwd objetivo".<img width="411" height="148" alt="Captura de pantalla 2026-09-18 123546" src="https://github.com/user-attachments/assets/32faeddd-d0d2-4a85-b7d9-f47911dbf9b2" />

Antes de conectarnos tendremos que saber la ip del servidor SSH, para eso vamos a usar el comando de ip a, lo que nos dió la ip de 10.0.2.15. Ahora para conectarnos tendremos que usar el comando de "ssh objetivo@[ip del servidro]" en mi caso será ssh objetivo 10.0.2.15.
<img width="654" height="335" alt="Captura de pantalla 2026-09-18 123914" src="https://github.com/user-attachments/assets/d0a71dce-95a9-444c-a168-6f5aac1e2866" />

Antes de comenzar a simular el ataque de fuerza bruta, creé el diccionario, con varias contraseñas aleatorias y con la real en ella. <img width="608" height="239" alt="interiordiccionario" src="https://github.com/user-attachments/assets/e077ead7-7099-4cbe-83ab-e8bcaa184328" />

Ahora vamos a lanzar el ataque desde otra terminal usando el comando de "hydra -l objetivo -P diccionario.txt ssh://10.0.2.15".<img width="636" height="329" alt="Captura de pantalla 2026-09-18 124645" src="https://github.com/user-attachments/assets/e8c8ece9-7e20-4903-9722-fcc5b2dcd9f4" />
Se puede ver en la imagen como el servicio de hydra comenzó el ataque a los usuarios dados, en este caso, objetivo, leyó las contraseñas que habia en el diccionario y llegó ala conclusión que objetivo era la contraseña, probando una a una las contraseñas que habia en el diccionario, este era un ataque de diccionario.

Para ver los intentos se usará el comando de sudo journalctl -u ssh -f:<img width="656" height="401" alt="Captura de pantalla 2026-09-18 125000" src="https://github.com/user-attachments/assets/18eb7e2c-0bb9-4b82-8858-667e1485dd06" />

Analizar los resultados y estudiar cómo mitigar ataques similares en entornos reales: 
Cuando hydra realiza el ataque, el archivo log muestra un patrón muy claro. Tras ver el journal se ve que se escribieron muchas contraseñas a la vez, que es algo que un humano no puede hacer,  se puede ver que lo hizo un mismo usuario y también en los registros se ver que con precisión la IP de origen del atacante y el puerto que se a usado.

Para mejorar las defensas contra la fuerza bruta se podrían eliminar las contraseñas por completo y en su lugar usar claves criptográficas SSH, para esto habria que editar el archivo de configuración con el comando de "sudo nano /etc/ssh/sshd_config" y se añadirian las lineas de:
PasswordAuthentication no
PubkeyAuthentication yes

Tambien se podria usar la herramienta de fail2ban que si detecta varios intentos de sesión que comparte IP, bloqueará el intento de inicio de sesión.

# Utilizar diccionarion con Hydra para simular un ataque de fuerza bruta con HTTP (formulario web)

Para este apartado tendremos que instalar y configurar la herramienta de DVWA desde github con el comando, primero accediendo al directorio web.
También tendremos que comprobar que tenemos apache habilitado.

Para ahora configurarlo como una aplicación web vulnerable en el servidor Apache local, usaremos:
sudo chown -R www-data:www-data /var/www/html/DVWA
sudo chmod -R 755 /var/www/html/DVWA

<img width="666" height="429" alt="Captura de pantalla 2026-09-18 130438" src="https://github.com/user-attachments/assets/f9e568c9-ac2f-4700-85b0-95509e60a6dd" />

Tras tener todo preparado tendremos que abrir DVWA, para esto desde el Navegador vamos a la web http://127.0.0.1/DVWA/, que nos llevará a la instalación de DVWA, en esta pagina entraremos a DVWA security y vamos a bajar la seguridad a baja. (hubieron errores al buscar http://127.0.0.1/DVWA/, tuve que crear las bases de datos en mariadb, para ello instale mariadb.
<img width="807" height="561" alt="image" src="https://github.com/user-attachments/assets/ddb7564e-3136-4795-9359-60ca45c81cf3" />

Tras esto tuve que comprobar que DVWA tengra las mismas credenciales en su archivo.
<img width="648" height="508" alt="image" src="https://github.com/user-attachments/assets/5cf85718-3b4f-4dcf-a6c8-a0ae87411d7c" />

tras esto pude iniciar DVWA en el buscador y bajar la seguridad.
<img width="1317" height="659" alt="image" src="https://github.com/user-attachments/assets/34e82940-6aef-427e-b718-625e3bc4bb74" />

En esta pagina tendremos que bajar abajo y hacer clic en el boton que dice Create / reset data base. Tras esto nos dirigiremos a la parte de abajo que apareció tras hacer clic en el boton anteriomente dicho, y haremos clic en setup.
<img width="594" height="413" alt="image" src="https://github.com/user-attachments/assets/3d840562-42c2-4437-b3de-58f85a713388" />

ahora entraremos en este apartado para bajar la seguridad a low.
<img width="1069" height="483" alt="image" src="https://github.com/user-attachments/assets/d3478bae-a483-4b0b-bb27-188dbd19248e" />
<img width="924" height="464" alt="image" src="https://github.com/user-attachments/assets/bbfdcbe6-6a86-4897-ad1e-df91bba9942b" />

Aqui se encuentra el formulario que Hydra usará.
<img width="852" height="425" alt="image" src="https://github.com/user-attachments/assets/31eaa549-ed38-4797-a863-f262c2932ab9" />

Sabiendo los datos investigando en DVWA sabemos que el comando para hacer el ataque será "hydra -l objetivo -P diccionario.txt 10.0.2.15 http-get-form "/DVWA/vulnerabilities/brute/:username=^USER^&password=^PASS^&Login=Login:F=Username and/or password incorrect.""
Ya que este comando hará que hydra vaya a tal dirección, entre al recuadro de usuario y contraseña y lo rellene usando el contenido de diccionario.txt y si recibe Username and/or password incorrect. tendrá que intentarlo hasta que deje de recibir ese mensaje.

<img width="651" height="381" alt="image" src="https://github.com/user-attachments/assets/3b399d8d-3327-4c63-a89f-07de2a7c80a8" />

Se tratan de falsos positivos. Para evitar los falsos positivos tuve que editar la parte en la que pregunta por el nombre y la contraseña.

Para mitigar daños, se podria establecer un número máximo de intentos fallidos desde una misma cuenta, Incrementar el tiempo de espera después de cada intento fallido, Las contraseñas deben ser suficientemente largas y no utilizar información fácilmente predecible.
