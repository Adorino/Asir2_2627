Empresa 1: Alcomer Boquerón Caliente, la configuración debe estar orientada a alta concurrencia, muchas lecturas/escrituras simultáneas, transacciones de compra e inventario y tiempos de respuesta bajos.


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



















