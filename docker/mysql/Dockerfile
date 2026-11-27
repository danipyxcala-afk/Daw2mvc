# MySQL con los scripts de creación y datos dentro de la imagen.
# Se ejecutan solo la primera vez (volumen de datos vacío), en orden alfabético.
FROM mysql:latest

COPY sql/CreacionBD.sql /docker-entrypoint-initdb.d/01-CreacionBD.sql
COPY sql/InsertarDatosBD.sql /docker-entrypoint-initdb.d/02-InsertarDatosBD.sql
