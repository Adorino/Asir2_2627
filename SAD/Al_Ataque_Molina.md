### Al ataque
# Aqui se verá el desarrollo de la practica de Pydictor.
Tendremos que instalar python en su ultima version antes. (sudo apt install python3).
Para esta practica vamos a simular un ataque, para ello vamos a usar la herramienta de Pydictor, que permite la creación para fuerza bruta.
<img width="656" height="280" alt="Captura de pantalla 2026-09-18 121131" src="https://github.com/user-attachments/assets/a3d8a8aa-7e6b-4778-b5da-22af30c7cbd9" />
En esta imagen se puede ver como instalé la herramienta de Pydictor usando los siguiente comandos en la terminal, en estos comandos cloné el repositorio oficial y después entré en la carpeta del programa.

Para comprobar su funcionamiento usaremos el comando de python3 pydictor.py y como se puede ver en la imagen, el comando mostró la siguiente respuesta.
"<img width="661" height="526" alt="Captura de pantalla 2026-09-18 121317" src="https://github.com/user-attachments/assets/2efac216-05a3-4d5e-846b-bc6329fd042e" />

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

Para ahora configurarlo como una aplicación web vulnerable en el servidor Apache local, usaremos:
sudo chown -R www-data:www-data /var/www/html/DVWA
sudo chmod -R 755 /var/www/html/DVWA

<img width="666" height="429" alt="Captura de pantalla 2026-09-18 130438" src="https://github.com/user-attachments/assets/f9e568c9-ac2f-4700-85b0-95509e60a6dd" />

Para llevar a cabo el ataque de fuerza bruta usando hydra usaremos el comando de hydra -l admin -P diccionario.txt 127.0.0.1 http-post-form "/DVWA/login.php:username=^USER^&password=^PASS^&Login=Login:F=Login failed" este comando hará que hydra busque la contraseña de forma bruta, y buscando contraseñas en el archivo de diccionario. Tambien hay que habilitar apache usando el comando de "sudo systemctl enable apache" y después comprobarlo con "sudo systemctl status apache".

"/DVWA/login.php \(\rightarrow \) :"Ve a esta página exacta".
:username=^USER^&password=^PASS^&Login=Login \(\rightarrow \): "Escribe el diccionario en la casilla llamada 'username', la contraseña en la llamada 'password' y luego haz clic en el botón 'Login'".
:F=Login failed" \(\rightarrow \): "Si tras hacer clic lees en la pantalla las palabras 'Login failed', significa que fallaste. Sigue intentando con la siguiente palabra".

<img width="631" height="338" alt="Captura de pantalla 2026-09-18 131654" src="https://github.com/user-attachments/assets/ba8c0847-0220-4de3-a82c-3063455aed50" />
Este resultado es un falso positivo, ya que dice que todas las contraseñas son correctas, cosa que es falso.

Para arregarlo podemos usar el comando corregido con Cookies, "hydra -l admin -P diccionario.txt 127.0.0.1 http-post-form "/DVWA/login.php:username=^USER^&password=^PASS^&Login=Login:F=Login failed:H=Cookie: PHPSESSID=TU_VALOR_AQUI; security=low""

Para Hydra, el éxito no significa "entré a la cuenta". Significa: "Envié una palabra y la página web NO me devolvió el texto 'Login failed'".
