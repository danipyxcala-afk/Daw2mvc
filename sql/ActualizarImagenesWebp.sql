-- =====================================================================
--  SIGMEAT · Migración: imágenes de productos de PNG a WebP
--  Para bases de datos ya creadas con la versión anterior de
--  InsertarDatosBD.sql. Es re-ejecutable (solo toca rutas .png).
-- =====================================================================

USE daw2mvc;

UPDATE productos
SET imagen = REPLACE(imagen, '.png', '.webp')
WHERE imagen LIKE '%.png';
