PRIMERA ENTREVISTA: Alcomer Boquerón Caliente, la configuración debe estar orientada a alta concurrencia, muchas lecturas/escrituras simultáneas, transacciones de compra e inventario y tiempos de respuesta bajos.


| Parámetro | valor | porqué |
| :--- | :--- | :--- |
| innodb_buffer_pool_size | 65 | Al haber muchas consultas y operaciones simultáneas, interesa mantener en memoria la mayor cantidad posible de datos e índices de InnoDB para reducir accesos a disco. |
| innodb_log_file_size | 512M | La empresa realiza muchas operaciones de escritura simultáneas, especialmente compras y actualizaciones de inventario. Un log mayor permite gestionar una cantidad importante de cambios sin forzar continuamente escrituras de los logs. |
| max_connections | 2000 | La empresa tiene miles de usuarios simultáneos, por lo que necesita admitir un número elevado de conexiones. El valor debe dimensionarse según los recursos reales del servidor para evitar consumir toda la memoria. |
| query_cache_size | 0 | Para una aplicación con muchas escrituras y actualizaciones frecuentes del inventario, la caché de consultas resulta poco apropiada, ya que los cambios pueden invalidar frecuentemente las consultas almacenadas. |
| table_open_cache | 2000 | Permite mantener abiertas muchas tablas y reducir la necesidad de abrirlas y cerrarlas repetidamente, algo útil con una carga elevada de usuarios concurrentes. |
| tmp_table_size | 64M | Permite disponer de tablas temporales en memoria de mayor tamaño, ayudando a determinadas consultas que necesitan operaciones temporales. |
| max_heap_table_size | 64M | Se establece de forma coherente con tmp_table_size, permitiendo que las tablas temporales internas que utilizan el motor MEMORY tengan un tamaño mayor. |
| innodb_flush_log_at_trx_commit | 1 | Es especialmente importante para Alcomer porque las compras y las actualizaciones de inventario deben mantener la integridad de las transacciones. Con 1, el log se sincroniza en cada confirmación de transacción. |
| log_bin | ON | Activa el registro binario de las operaciones que modifican los datos. Es útil para recuperación y replicación y aporta un registro de los cambios realizados. |
| slow_query_log | ON | Como la empresa necesita tiempos de respuesta bajos, conviene registrar las consultas que tardan demasiado para poder detectar y optimizar los problemas de rendimiento. |
| slow_query_log_file | mysql-slow.log | Archivo destinado a almacenar las consultas que superen el tiempo establecido como consulta lenta. |
| long_query_time | 1 segundo | La empresa necesita tiempos de respuesta bajos, por lo que interesa detectar consultas que tarden más de aproximadamente un segundo y estudiar si pueden optimizarse. |
| bind-address | 0.0.0.0* | Permitiría que el servidor acepte conexiones desde las interfaces de red disponibles, algo que podría ser necesario si los usuarios/aplicaciones acceden desde otros equipos. |
| innodb_file_per_table | ON | Permite almacenar cada tabla InnoDB en su propio espacio de tablas, facilitando la gestión individual de las tablas y del almacenamiento. |
| performance_schema | ON | Permite obtener información detallada sobre el rendimiento y la actividad del servidor, algo útil para detectar problemas en un entorno de alta concurrencia. |

Para editar estos parametros vamos al archivo .cnf, en la siguiente imagen se puede ver su contenido y lo que vamos a editar. La ubicación de este archivo se encuentra en /opt/lampp/etc/my.cnf
<img width="467" height="251" alt="image" src="https://github.com/user-attachments/assets/bfe05210-5281-43c8-a043-b94f63087e79" />

Después de editar los datos en el archivo (no pude añadir varios parámetros que no estaban originalmente en el archivo ya que al iniciar php, xampp lee este archivo al parecer y si hay mas lineas de las que deberia de haber hay un error y phpmyadmin no funciona).
En la pestaña de SQL se puede ver lo siguiente, por si acaso también pedí los parámetros que no he escrito en el archivo.
<img width="1031" height="516" alt="image" src="https://github.com/user-attachments/assets/65fb81e3-e371-41bf-9453-4245726ec020" />
<img width="381" height="291" alt="image" src="https://github.com/user-attachments/assets/7c736fc0-8cda-4b1c-9f50-58b6f956aa0d" />

SEGUNDA ENTREVISTA: Aquí la prioridad ya no es tener miles de usuarios haciendo operaciones simultáneamente, sino trabajar eficientemente con grandes cantidades de datos históricos y consultas de análisis pesadas.

| Parámetro | valor | porqué |
| :--- | :--- | :--- |
| innodb_buffer_pool_size | 70 | Se manejan grandes volúmenes de datos y muchas consultas de lectura. Tener una gran parte de los datos e índices en memoria puede reducir los accesos a disco. |
| innodb_log_file_size | 512M | Hay grandes cantidades de datos, pero las operaciones de escritura son periódicas y no constituyen la carga principal. Un tamaño relativamente grande permite gestionar las escrituras sin que el log se quede pequeño rápidamente. |
| max_connections | 150 | No necesita miles de usuarios simultáneos como Alcomer. Las consultas son pesadas, por lo que interesa evitar un número excesivo de consultas complejas ejecutándose al mismo tiempo y consumiendo todos los recursos. |
| query_cache_size | 0 | Las consultas son complejas y trabajan con grandes volúmenes de datos. Además, la caché de consultas puede resultar poco adecuada en configuraciones modernas de MySQL/MariaDB. |
| table_open_cache | 2000 | Permite mantener abiertas bastantes tablas y evitar aperturas repetidas durante las consultas analíticas. |
| tmp_table_size | 256M | Las consultas de agregación y análisis pueden necesitar tablas temporales relativamente grandes. Aumentar este límite permite que determinadas operaciones temporales dispongan de más memoria. |
| max_heap_table_size | 256M | Lo configuramos de forma coherente con tmp_table_size, proporcionando un límite similar para tablas temporales en memoria. |
| innodb_flush_log_at_trx_commit | 1 | Aunque las escrituras sean periódicas, sigue siendo importante mantener la durabilidad e integridad de los datos almacenados. |
| log_bin | ON | Permite registrar los cambios realizados en la base de datos. Puede ser útil para recuperación y para mantener un registro de las operaciones de escritura. |
| slow_query_log | ON | Es especialmente interesante en este caso porque las consultas son complejas y pesadas. Permite identificar cuáles están tardando demasiado. |
| slow_query_log_file | mysql-slow.log | Archivo donde se almacenarán las consultas que superen el tiempo establecido. |
| long_query_time | 5 | Como las consultas de análisis pueden ser complejas y trabajar con grandes cantidades de datos, no tendría sentido considerar automáticamente lenta una consulta que tarde 1 segundo. Un umbral de 5 segundos permite centrarse en las consultas especialmente lentas. |
| bind-address | 0.0.0.0* | Permitiría conexiones desde diferentes interfaces de red. Para una instalación real debería restringirse a las redes o equipos que necesiten acceder al servidor. |
| innodb_file_per_table | ON | Permite mantener los datos de cada tabla InnoDB en su propio espacio de tablas, facilitando la gestión de un sistema con grandes cantidades de datos. |
| performance_schema | ON | Es útil para analizar el rendimiento del servidor y detectar qué operaciones o consultas están consumiendo más recursos. |

Este es el resultado en la tabla de SQL en myphpadmin.
<img width="383" height="290" alt="image" src="https://github.com/user-attachments/assets/0a3e9f79-8b66-43b1-885f-a19e20f96d23" />


TERCERA EMPRESA: una red social donde hay muchas personas conectadas al mismo tiempo, pero donde predominan las escrituras (publicaciones, comentarios, compartidos, modificaciones) frente a las lecturas. Además, aunque no necesita el nivel de concurrencia de un sistema financiero, sí necesita que los cambios realizados por un usuario sean visibles rápidamente para los demás.

| Parámetro | valor | porqué |
| :--- | :--- | :--- |
| innodb_buffer_pool_size | 65 | Hay muchas operaciones y usuarios simultáneos. Mantener una cantidad importante de datos e índices en memoria ayuda a reducir accesos al disco y mejorar los tiempos de respuesta. |
| innodb_log_file_size  | 512M | Hay muchas escrituras debido a publicaciones, comentarios y compartidos. Un log suficientemente grande permite gestionar una cantidad elevada de cambios. |
| max_connections | 1000 | Hay muchas personas utilizando la red social simultáneamente. Aunque la concurrencia no sea tan extrema como en el sistema financiero de Alcomer, se necesita admitir un número elevado de conexiones. |
| query_cache_size | 0 | Debido a la cantidad de modificaciones que se realizan, mantener resultados de consultas en caché puede provocar frecuentes invalidaciones y no resulta especialmente conveniente. |
| table_open_cache | 2000 | Una red social puede realizar muchas operaciones sobre sus tablas simultáneamente. Mantener más tablas abiertas puede reducir operaciones repetitivas de apertura y cierre. |
| tmp_table_size | 64M | Es suficiente para las operaciones temporales habituales sin dedicar una cantidad excesiva de memoria a cada conexión.
| max_heap_table_size | 64M | Se mantiene igual que tmp_table_size para establecer un límite coherente para las tablas temporales en memoria. |
| innodb_flush_log_at_trx_commit | 1 | Las publicaciones, comentarios y modificaciones deben conservarse correctamente. Además, Alfred indica que la consistencia de los datos es importante. |
| log_bin | ON | Permite registrar los cambios realizados en la base de datos, lo que puede ser útil para recuperación y replicación. |
| slow_query_log | ON | Permite identificar consultas que estén provocando tiempos de respuesta elevados en una aplicación con muchos usuarios concurrentes. |
| slow_query_log_file | mysql-slow.log | Archivo en el que se almacenarán las consultas consideradas lentas. |
| long_query_time | 2 | Se busca una respuesta relativamente rápida para los usuarios. Un umbral de 2 segundos permite detectar consultas que puedan estar afectando a la experiencia de uso. |
| bind-address | 0.0.0.0* | Permite conexiones desde las interfaces de red disponibles. En un servidor real debería restringirse a las redes que realmente necesiten acceder. |
| innodb_file_per_table | ON | Permite gestionar los datos de cada tabla InnoDB de forma independiente, algo conveniente para una aplicación con muchas tablas y operaciones. |
| performance_schema | ON | Permite monitorizar el rendimiento del servidor y detectar problemas relacionados con la concurrencia y el consumo de recursos. |

Este es el resultado en la tabla de SQL en myphpadmin.
<img width="394" height="290" alt="image" src="https://github.com/user-attachments/assets/9ccd45bb-5c16-4cb8-aa23-f072907a2dd7" />
















