BackEnd:
Se utiliza la api Zenserp para busqueda de imagenes relacionada con el titulo
(la API Key tiene acceso a 49 consultas, debido a que es la version gratiuta).
Debido al tamano de las imagenes es probable que se deba aumentar la capacidad 
de almacenamiento por registro de la base de datos. dependiendo del tamano que se desee almacenar.
La pagina index.php en la carpeta rest sirve para llamar a la rest api, que se llama crud.php.
Se adjunta la base de datos esperiencias_explora, utilizada para este requerimiento.

