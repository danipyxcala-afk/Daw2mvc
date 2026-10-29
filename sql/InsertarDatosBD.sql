-- =====================================================================
--  SIGMEAT · Datos de prueba para la base de datos daw2mvc
--  Ejecutar DESPUÉS del script de estructura (CREATE TABLE ...).
--  Es re-ejecutable: vacía las tablas antes de insertar.
--
--  Convenciones usadas:
--   * producto_ingrediente.cantidad > 0  -> ingrediente que lleva el producto
--     por defecto (se puede QUITAR). El valor es cuántas unidades lleva.
--   * producto_ingrediente.cantidad = 0  -> ingrediente que NO lleva, pero que
--     se ofrece como EXTRA en ese producto.
--   * Extras disponibles de un producto = sus ingredientes con
--     ingredientes.precio_extra > 0 (incluidos o no por defecto; si ya lo lleva,
--     el extra añade una unidad más).
--   * Precios con IVA incluido. La contraseña de los usuarios de prueba es
--     'Test1234!' y la del admin 'Admin1234!' (hash bcrypt).
--   * ofertas.valor: descuento/codigo = porcentaje; combo = precio final del
--     combo en euros; 2x1 = NULL.
--   * pedido_detalle.subtotal = cantidad * (precio_unitario + extras añadidos).
--   * pedidos.total = subtotal - descuento.
-- =====================================================================

USE daw2mvc;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE pedido_detalle_ingrediente;
TRUNCATE TABLE pedido_detalle;
TRUNCATE TABLE pedidos;
TRUNCATE TABLE oferta_producto;
TRUNCATE TABLE ofertas;
TRUNCATE TABLE producto_ingrediente;
TRUNCATE TABLE productos;
TRUNCATE TABLE ingredientes;
TRUNCATE TABLE categorias;
TRUNCATE TABLE usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
-- 1. CATEGORÍAS
-- ---------------------------------------------------------------------
INSERT INTO categorias (id, nombre, descripcion, activa) VALUES
  (1, 'Hamburguesas', 'Hamburguesas de ternera, pollo y vegetales preparadas al momento.', TRUE),
  (2, 'Complementos', 'Patatas, aros, nuggets y ensaladas para acompañar.', TRUE),
  (3, 'Bebidas', 'Refrescos, agua, zumo, cerveza y batidos.', TRUE),
  (4, 'Postres', 'Dulces para terminar la comida.', TRUE);

-- ---------------------------------------------------------------------
-- 2. INGREDIENTES (precio_extra > 0 => se puede añadir como extra)
-- ---------------------------------------------------------------------
INSERT INTO ingredientes (id, nombre, precio_extra, activo) VALUES
  (1, 'Pan de hamburguesa', 0.00, TRUE),
  (2, 'Carne de ternera', 2.50, TRUE),
  (3, 'Lechuga', 0.00, TRUE),
  (4, 'Tomate', 0.00, TRUE),
  (5, 'Cebolla', 0.00, TRUE),
  (6, 'Salsa especial', 0.00, TRUE),
  (7, 'Queso cheddar', 0.80, TRUE),
  (8, 'Beicon crujiente', 0.80, TRUE),
  (9, 'Huevo a la plancha', 0.80, TRUE),
  (10, 'Aguacate', 0.80, TRUE),
  (11, 'Cebolla caramelizada', 0.80, TRUE),
  (12, 'Pepinillos', 0.50, TRUE),
  (13, 'Jalapeños', 0.50, TRUE),
  (14, 'Champiñones salteados', 0.80, TRUE),
  (15, 'Salsa BBQ', 0.50, TRUE),
  (16, 'Salsa picante', 0.50, TRUE),
  (17, 'Pollo crujiente', 2.00, TRUE),
  (18, 'Hamburguesa vegetal', 2.50, TRUE),
  (19, 'Mayonesa', 0.00, TRUE),
  (20, 'Pollo a la plancha', 2.00, TRUE),
  (21, 'Salsa césar', 0.50, TRUE),
  (22, 'Parmesano', 0.80, TRUE),
  (23, 'Picatostes', 0.50, TRUE),
  (24, 'Patatas fritas', 0.00, TRUE),
  (25, 'Patatas gajo', 0.00, TRUE),
  (26, 'Sal', 0.00, TRUE),
  (27, 'Especias', 0.00, TRUE),
  (28, 'Salsa brava', 0.50, TRUE),
  (29, 'Alioli', 0.50, TRUE),
  (30, 'Aros de cebolla rebozados', 0.00, TRUE),
  (31, 'Pollo empanado', 0.00, TRUE),
  (32, 'Cebolla crujiente', 0.50, TRUE),
  (33, 'Hielo', 0.00, TRUE),
  (34, 'Rodaja de limón', 0.20, TRUE),
  (35, 'Agua mineral', 0.00, TRUE),
  (36, 'Coca-cola', 0.00, TRUE),
  (37, 'Coca-cola Zero', 0.00, TRUE),
  (38, 'Fanta Naranja', 0.00, TRUE),
  (39, 'Aquarius', 0.00, TRUE),
  (40, 'Zumo de naranja', 0.00, TRUE),
  (41, 'Cerveza', 0.00, TRUE),
  (42, 'Té helado de limón', 0.00, TRUE),
  (43, 'Leche', 0.00, TRUE),
  (44, 'Cacao', 0.00, TRUE),
  (45, 'Helado de vainilla', 1.00, TRUE),
  (46, 'Nata montada', 0.50, TRUE),
  (47, 'Sirope de chocolate', 0.50, TRUE),
  (48, 'Brownie de chocolate', 0.00, TRUE),
  (49, 'Natillas', 0.00, TRUE),
  (50, 'Galleta', 0.00, TRUE),
  (51, 'Canela', 0.00, TRUE),
  (52, 'Queso crema', 0.00, TRUE),
  (53, 'Base de galleta', 0.00, TRUE),
  (54, 'Mermelada de frutos rojos', 0.50, TRUE),
  (55, 'Masa de cookie', 0.00, TRUE),
  (56, 'Pepitas de chocolate', 0.00, TRUE);

-- ---------------------------------------------------------------------
-- 3. PRODUCTOS y sus INGREDIENTES (un bloque por producto)
-- ---------------------------------------------------------------------

-- ===== HAMBURGUESAS =====

-- 1. Classic Burger · 8.90 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (1, 1, 'Classic Burger', 'Carne de ternera de 180 g, lechuga, tomate, cebolla y nuestra salsa especial en pan.', 8.90, 'img/productos/classic-burger.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (1, 1, 1), -- Pan de hamburguesa (base)
  (1, 2, 1), -- Carne de ternera (base, extra +2.50 €)
  (1, 3, 1), -- Lechuga (base)
  (1, 4, 1), -- Tomate (base)
  (1, 5, 1), -- Cebolla (base)
  (1, 6, 1), -- Salsa especial (base)
  (1, 7, 0), -- Queso cheddar (extra opcional, extra +0.80 €)
  (1, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (1, 9, 0), -- Huevo a la plancha (extra opcional, extra +0.80 €)
  (1, 10, 0), -- Aguacate (extra opcional, extra +0.80 €)
  (1, 11, 0); -- Cebolla caramelizada (extra opcional, extra +0.80 €)

-- 2. Cheese Bacon · 10.50 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (2, 1, 'Cheese Bacon', 'Carne de ternera de 180 g, doble queso cheddar y beicon crujiente.', 10.50, 'img/productos/cheese-bacon.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (2, 1, 1), -- Pan de hamburguesa (base)
  (2, 2, 1), -- Carne de ternera (base, extra +2.50 €)
  (2, 7, 2), -- Queso cheddar (base, extra +0.80 €)
  (2, 8, 1), -- Beicon crujiente (base, extra +0.80 €)
  (2, 6, 1), -- Salsa especial (base)
  (2, 9, 0), -- Huevo a la plancha (extra opcional, extra +0.80 €)
  (2, 10, 0), -- Aguacate (extra opcional, extra +0.80 €)
  (2, 11, 0), -- Cebolla caramelizada (extra opcional, extra +0.80 €)
  (2, 12, 0); -- Pepinillos (extra opcional, extra +0.50 €)

-- 3. Veggie Burger · 9.50 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (3, 1, 'Veggie Burger', 'Hamburguesa vegetal con aguacate, tomate y lechuga.', 9.50, 'img/productos/veggie-burger.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (3, 1, 1), -- Pan de hamburguesa (base)
  (3, 18, 1), -- Hamburguesa vegetal (base, extra +2.50 €)
  (3, 10, 1), -- Aguacate (base, extra +0.80 €)
  (3, 4, 1), -- Tomate (base)
  (3, 3, 1), -- Lechuga (base)
  (3, 7, 0), -- Queso cheddar (extra opcional, extra +0.80 €)
  (3, 11, 0), -- Cebolla caramelizada (extra opcional, extra +0.80 €)
  (3, 14, 0), -- Champiñones salteados (extra opcional, extra +0.80 €)
  (3, 13, 0); -- Jalapeños (extra opcional, extra +0.50 €)

-- 4. BBQ Burger · 10.90 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (4, 1, 'BBQ Burger', 'Carne de ternera de 180 g, queso cheddar, beicon crujiente, cebolla crujiente y salsa BBQ.', 10.90, 'img/productos/bbq-burger.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (4, 1, 1), -- Pan de hamburguesa (base)
  (4, 2, 1), -- Carne de ternera (base, extra +2.50 €)
  (4, 7, 1), -- Queso cheddar (base, extra +0.80 €)
  (4, 8, 1), -- Beicon crujiente (base, extra +0.80 €)
  (4, 32, 1), -- Cebolla crujiente (base, extra +0.50 €)
  (4, 15, 1), -- Salsa BBQ (base, extra +0.50 €)
  (4, 9, 0), -- Huevo a la plancha (extra opcional, extra +0.80 €)
  (4, 13, 0), -- Jalapeños (extra opcional, extra +0.50 €)
  (4, 10, 0), -- Aguacate (extra opcional, extra +0.80 €)
  (4, 11, 0); -- Cebolla caramelizada (extra opcional, extra +0.80 €)

-- 5. Crispy Chicken · 9.90 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (5, 1, 'Crispy Chicken', 'Pollo crujiente, lechuga, tomate y mayonesa en pan.', 9.90, 'img/productos/crispy-chicken.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (5, 1, 1), -- Pan de hamburguesa (base)
  (5, 17, 1), -- Pollo crujiente (base, extra +2.00 €)
  (5, 3, 1), -- Lechuga (base)
  (5, 4, 1), -- Tomate (base)
  (5, 19, 1), -- Mayonesa (base)
  (5, 7, 0), -- Queso cheddar (extra opcional, extra +0.80 €)
  (5, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (5, 10, 0), -- Aguacate (extra opcional, extra +0.80 €)
  (5, 16, 0); -- Salsa picante (extra opcional, extra +0.50 €)

-- 6. Spicy Burger · 10.20 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (6, 1, 'Spicy Burger', 'Carne de ternera de 180 g, queso cheddar, jalapeños, salsa picante y lechuga.', 10.20, 'img/productos/spicy-burger.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (6, 1, 1), -- Pan de hamburguesa (base)
  (6, 2, 1), -- Carne de ternera (base, extra +2.50 €)
  (6, 7, 1), -- Queso cheddar (base, extra +0.80 €)
  (6, 13, 1), -- Jalapeños (base, extra +0.50 €)
  (6, 16, 1), -- Salsa picante (base, extra +0.50 €)
  (6, 3, 1), -- Lechuga (base)
  (6, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (6, 9, 0), -- Huevo a la plancha (extra opcional, extra +0.80 €)
  (6, 10, 0), -- Aguacate (extra opcional, extra +0.80 €)
  (6, 12, 0); -- Pepinillos (extra opcional, extra +0.50 €)

-- 7. Double Burger · 12.50 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (7, 1, 'Double Burger', 'Doble carne de ternera de 180 g, doble queso cheddar, pepinillos, cebolla y salsa especial.', 12.50, 'img/productos/double-burger.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (7, 1, 1), -- Pan de hamburguesa (base)
  (7, 2, 2), -- Carne de ternera (base, extra +2.50 €)
  (7, 7, 2), -- Queso cheddar (base, extra +0.80 €)
  (7, 12, 1), -- Pepinillos (base, extra +0.50 €)
  (7, 5, 1), -- Cebolla (base)
  (7, 6, 1), -- Salsa especial (base)
  (7, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (7, 9, 0), -- Huevo a la plancha (extra opcional, extra +0.80 €)
  (7, 11, 0); -- Cebolla caramelizada (extra opcional, extra +0.80 €)

-- 8. Mushroom Burger · 10.40 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (8, 1, 'Mushroom Burger', 'Carne de ternera de 180 g, champiñones salteados, queso cheddar y salsa especial.', 10.40, 'img/productos/mushroom-burger.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (8, 1, 1), -- Pan de hamburguesa (base)
  (8, 2, 1), -- Carne de ternera (base, extra +2.50 €)
  (8, 14, 1), -- Champiñones salteados (base, extra +0.80 €)
  (8, 7, 1), -- Queso cheddar (base, extra +0.80 €)
  (8, 6, 1), -- Salsa especial (base)
  (8, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (8, 9, 0), -- Huevo a la plancha (extra opcional, extra +0.80 €)
  (8, 10, 0), -- Aguacate (extra opcional, extra +0.80 €)
  (8, 11, 0); -- Cebolla caramelizada (extra opcional, extra +0.80 €)

-- 9. Campus Burger · 12.90 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (9, 1, 'Campus Burger', 'La más completa: carne de ternera de 180 g, huevo a la plancha, beicon crujiente, queso cheddar, lechuga, tomate y salsa especial.', 12.90, 'img/productos/campus-burger.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (9, 1, 1), -- Pan de hamburguesa (base)
  (9, 2, 1), -- Carne de ternera (base, extra +2.50 €)
  (9, 9, 1), -- Huevo a la plancha (base, extra +0.80 €)
  (9, 8, 1), -- Beicon crujiente (base, extra +0.80 €)
  (9, 7, 1), -- Queso cheddar (base, extra +0.80 €)
  (9, 3, 1), -- Lechuga (base)
  (9, 4, 1), -- Tomate (base)
  (9, 6, 1), -- Salsa especial (base)
  (9, 10, 0), -- Aguacate (extra opcional, extra +0.80 €)
  (9, 11, 0), -- Cebolla caramelizada (extra opcional, extra +0.80 €)
  (9, 12, 0), -- Pepinillos (extra opcional, extra +0.50 €)
  (9, 13, 0); -- Jalapeños (extra opcional, extra +0.50 €)

-- ===== COMPLEMENTOS =====

-- 10. Patatas Classicas · 3.50 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (10, 2, 'Patatas Classicas', 'Patatas fritas crujientes con sal.', 3.50, 'img/productos/patatas-classicas.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (10, 24, 1), -- Patatas fritas (base)
  (10, 26, 1), -- Sal (base)
  (10, 7, 0), -- Queso cheddar (extra opcional, extra +0.80 €)
  (10, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (10, 28, 0), -- Salsa brava (extra opcional, extra +0.50 €)
  (10, 29, 0), -- Alioli (extra opcional, extra +0.50 €)
  (10, 15, 0); -- Salsa BBQ (extra opcional, extra +0.50 €)

-- 11. Patatas Deluxe · 3.70 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (11, 2, 'Patatas Deluxe', 'Patatas gajo con piel, sal y especias.', 3.70, 'img/productos/patatas-deluxe.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (11, 25, 1), -- Patatas gajo (base)
  (11, 26, 1), -- Sal (base)
  (11, 27, 1), -- Especias (base)
  (11, 7, 0), -- Queso cheddar (extra opcional, extra +0.80 €)
  (11, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (11, 28, 0), -- Salsa brava (extra opcional, extra +0.50 €)
  (11, 29, 0), -- Alioli (extra opcional, extra +0.50 €)
  (11, 13, 0); -- Jalapeños (extra opcional, extra +0.50 €)

-- 12. Patatas Bravas · 4.20 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (12, 2, 'Patatas Bravas', 'Patatas fritas con salsa brava y alioli.', 4.20, 'img/productos/patatas-bravas.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (12, 24, 1), -- Patatas fritas (base)
  (12, 28, 1), -- Salsa brava (base, extra +0.50 €)
  (12, 29, 1), -- Alioli (base, extra +0.50 €)
  (12, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (12, 7, 0), -- Queso cheddar (extra opcional, extra +0.80 €)
  (12, 13, 0); -- Jalapeños (extra opcional, extra +0.50 €)

-- 13. Aros de cebolla · 4.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (13, 2, 'Aros de cebolla', 'Aros de cebolla rebozados con salsa BBQ.', 4.00, 'img/productos/aros-de-cebolla.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (13, 30, 1), -- Aros de cebolla rebozados (base)
  (13, 15, 1), -- Salsa BBQ (base, extra +0.50 €)
  (13, 29, 0), -- Alioli (extra opcional, extra +0.50 €)
  (13, 16, 0); -- Salsa picante (extra opcional, extra +0.50 €)

-- 14. Nuggets de pollo · 4.50 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (14, 2, 'Nuggets de pollo', '6 nuggets de pollo empanado con salsa BBQ.', 4.50, 'img/productos/nuggets-de-pollo.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (14, 31, 1), -- Pollo empanado (base)
  (14, 15, 1), -- Salsa BBQ (base, extra +0.50 €)
  (14, 29, 0), -- Alioli (extra opcional, extra +0.50 €)
  (14, 16, 0); -- Salsa picante (extra opcional, extra +0.50 €)

-- 15. Ensalada césar · 8.50 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (15, 2, 'Ensalada césar', 'Pollo a la plancha, lechuga, parmesano, picatostes y salsa césar.', 8.50, 'img/productos/ensalada-cesar.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (15, 20, 1), -- Pollo a la plancha (base, extra +2.00 €)
  (15, 3, 1), -- Lechuga (base)
  (15, 22, 1), -- Parmesano (base, extra +0.80 €)
  (15, 23, 1), -- Picatostes (base, extra +0.50 €)
  (15, 21, 1), -- Salsa césar (base, extra +0.50 €)
  (15, 10, 0), -- Aguacate (extra opcional, extra +0.80 €)
  (15, 8, 0), -- Beicon crujiente (extra opcional, extra +0.80 €)
  (15, 9, 0); -- Huevo a la plancha (extra opcional, extra +0.80 €)

-- ===== BEBIDAS =====

-- 16. Agua · 2.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (16, 3, 'Agua', 'Agua mineral 50 cl.', 2.00, 'img/productos/agua.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (16, 35, 1), -- Agua mineral (base)
  (16, 33, 1), -- Hielo (base)
  (16, 34, 0); -- Rodaja de limón (extra opcional, extra +0.20 €)

-- 17. Coca-cola · 3.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (17, 3, 'Coca-cola', 'Coca-cola 33 cl.', 3.00, 'img/productos/coca-cola.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (17, 36, 1), -- Coca-cola (base)
  (17, 33, 1), -- Hielo (base)
  (17, 34, 0); -- Rodaja de limón (extra opcional, extra +0.20 €)

-- 18. Coca-cola Zero · 3.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (18, 3, 'Coca-cola Zero', 'Coca-cola Zero 33 cl.', 3.00, 'img/productos/coca-cola-zero.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (18, 37, 1), -- Coca-cola Zero (base)
  (18, 33, 1), -- Hielo (base)
  (18, 34, 0); -- Rodaja de limón (extra opcional, extra +0.20 €)

-- 19. Fanta Naranja · 3.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (19, 3, 'Fanta Naranja', 'Fanta de naranja 33 cl.', 3.00, 'img/productos/fanta-naranja.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (19, 38, 1), -- Fanta Naranja (base)
  (19, 33, 1), -- Hielo (base)
  (19, 34, 0); -- Rodaja de limón (extra opcional, extra +0.20 €)

-- 20. Aquarius · 3.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (20, 3, 'Aquarius', 'Aquarius de limón 33 cl.', 3.00, 'img/productos/aquarius.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (20, 39, 1), -- Aquarius (base)
  (20, 33, 1), -- Hielo (base)
  (20, 34, 0); -- Rodaja de limón (extra opcional, extra +0.20 €)

-- 21. Zumo de naranja · 3.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (21, 3, 'Zumo de naranja', 'Zumo de naranja 33 cl.', 3.00, 'img/productos/zumo-de-naranja.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (21, 40, 1), -- Zumo de naranja (base)
  (21, 33, 1); -- Hielo (base)

-- 22. Cerveza · 3.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (22, 3, 'Cerveza', 'Cerveza 33 cl. Solo para mayores de 18 años.', 3.00, 'img/productos/cerveza.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (22, 41, 1), -- Cerveza (base)
  (22, 34, 0); -- Rodaja de limón (extra opcional, extra +0.20 €)

-- 23. Batido chocolate · 2.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (23, 3, 'Batido chocolate', 'Batido de chocolate con leche, cacao y helado de vainilla.', 2.00, 'img/productos/batido-chocolate.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (23, 43, 1), -- Leche (base)
  (23, 44, 1), -- Cacao (base)
  (23, 45, 1), -- Helado de vainilla (base, extra +1.00 €)
  (23, 46, 0), -- Nata montada (extra opcional, extra +0.50 €)
  (23, 47, 0); -- Sirope de chocolate (extra opcional, extra +0.50 €)

-- 24. Té helado de limón · 3.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (24, 3, 'Té helado de limón', 'Té helado de limón 33 cl.', 3.00, 'img/productos/te-helado-limon.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (24, 42, 1), -- Té helado de limón (base)
  (24, 33, 1), -- Hielo (base)
  (24, 34, 0); -- Rodaja de limón (extra opcional, extra +0.20 €)

-- ===== POSTRES =====

-- 25. Brownie con helado · 6.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (25, 4, 'Brownie con helado', 'Brownie de chocolate caliente con helado de vainilla y sirope.', 6.00, 'img/productos/brownie-con-helado.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (25, 48, 1), -- Brownie de chocolate (base)
  (25, 45, 1), -- Helado de vainilla (base, extra +1.00 €)
  (25, 47, 1), -- Sirope de chocolate (base, extra +0.50 €)
  (25, 46, 0); -- Nata montada (extra opcional, extra +0.50 €)

-- 26. Helado · 5.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (26, 4, 'Helado', 'Dos bolas de helado de vainilla con sirope de chocolate.', 5.00, 'img/productos/helado.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (26, 45, 2), -- Helado de vainilla (base, extra +1.00 €)
  (26, 47, 1), -- Sirope de chocolate (base, extra +0.50 €)
  (26, 46, 0); -- Nata montada (extra opcional, extra +0.50 €)

-- 27. Natilla · 4.00 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (27, 4, 'Natilla', 'Natillas caseras con galleta y canela.', 4.00, 'img/productos/natilla.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (27, 49, 1), -- Natillas (base)
  (27, 50, 1), -- Galleta (base)
  (27, 51, 1), -- Canela (base)
  (27, 46, 0), -- Nata montada (extra opcional, extra +0.50 €)
  (27, 47, 0); -- Sirope de chocolate (extra opcional, extra +0.50 €)

-- 28. Tarta de queso · 4.50 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (28, 4, 'Tarta de queso', 'Tarta de queso cremosa con mermelada de frutos rojos.', 4.50, 'img/productos/tarta-de-queso.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (28, 52, 1), -- Queso crema (base)
  (28, 53, 1), -- Base de galleta (base)
  (28, 54, 1), -- Mermelada de frutos rojos (base, extra +0.50 €)
  (28, 46, 0), -- Nata montada (extra opcional, extra +0.50 €)
  (28, 47, 0); -- Sirope de chocolate (extra opcional, extra +0.50 €)

-- 29. Cookie con pepitas · 2.50 €
INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, imagen, activo) VALUES
  (29, 4, 'Cookie con pepitas', 'Cookie recién hecha con pepitas de chocolate.', 2.50, 'img/productos/cookie-con-pepitas.png', TRUE);
INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES
  (29, 55, 1), -- Masa de cookie (base)
  (29, 56, 1), -- Pepitas de chocolate (base)
  (29, 45, 0), -- Helado de vainilla (extra opcional, extra +1.00 €)
  (29, 47, 0), -- Sirope de chocolate (extra opcional, extra +0.50 €)
  (29, 46, 0); -- Nata montada (extra opcional, extra +0.50 €)

-- ---------------------------------------------------------------------
-- 4. OFERTAS
-- ---------------------------------------------------------------------
INSERT INTO ofertas (id, nombre, descripcion, tipo, valor, codigo, fecha_inicio, fecha_fin, activa) VALUES
  (1, 'Menú Estudiante', 'Classic Burger + Patatas Classicas + Coca-cola a precio cerrado.', 'combo', 12.50, NULL, '2026-09-01 00:00:00', NULL, TRUE),
  (2, '2x1 en hamburguesas veggie y clásicas', 'Pide dos Classic Burger o dos Veggie Burger y paga solo una.', '2x1', NULL, NULL, '2026-10-01 00:00:00', '2026-11-30 23:59:59', TRUE),
  (3, 'Dulce fin de curso', '15% de descuento en todos los postres.', 'descuento', 15.00, NULL, '2026-10-15 00:00:00', '2026-12-20 23:59:59', TRUE),
  (4, 'Código UNI10', '10% de descuento en el pedido con tu carnet universitario.', 'codigo', 10.00, 'UNI10', '2026-09-01 00:00:00', NULL, TRUE),
  (5, 'Bienvenida', '15% de descuento en tu primer pedido.', 'codigo', 15.00, 'BIENVENIDA15', '2026-09-01 00:00:00', NULL, TRUE),
  (6, 'Verano 2x1 refrescos', '2x1 en Coca-cola y Fanta Naranja (campaña finalizada).', '2x1', NULL, NULL, '2026-06-15 00:00:00', '2026-08-31 23:59:59', FALSE);

INSERT INTO oferta_producto (oferta_id, producto_id) VALUES
  (1, 1),  -- Menú Estudiante: Classic Burger
  (1, 10),  -- Menú Estudiante: Patatas Classicas
  (1, 17),  -- Menú Estudiante: Coca-cola
  (2, 1),  -- 2x1 en hamburguesas veggie y clásicas: Classic Burger
  (2, 3),  -- 2x1 en hamburguesas veggie y clásicas: Veggie Burger
  (3, 25),  -- Dulce fin de curso: Brownie con helado
  (3, 26),  -- Dulce fin de curso: Helado
  (3, 27),  -- Dulce fin de curso: Natilla
  (3, 28),  -- Dulce fin de curso: Tarta de queso
  (3, 29),  -- Dulce fin de curso: Cookie con pepitas
  (6, 17),  -- Verano 2x1 refrescos: Coca-cola
  (6, 19);  -- Verano 2x1 refrescos: Fanta Naranja
-- (UNI10 y BIENVENIDA15 son códigos globales: no se asocian a productos concretos)

-- ---------------------------------------------------------------------
-- 5. USUARIOS (1 admin + 24 usuarios de prueba)
-- ---------------------------------------------------------------------
INSERT INTO usuarios (id, nombre, email, password, telefono, direccion, fecha_nacimiento, rol, fecha_registro) VALUES
  (1, 'Admin Sigmeat', 'admin@sigmeat.test', 'admin', '600000000', 'Calle Mayor 1, local 2', NULL, 'admin', '2026-08-25 09:00:00'),
  (2, 'Lucía Fernández Gil', 'lucia.fernandez@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '610001234', 'Calle Mayor 3, 1º A', '2002-01-01', 'usuario', '2026-09-01 10:00:00'),
  (3, 'Marc Soler Puig', 'marc.soler@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '611001271', 'Avenida de la Universidad 5, 2º B', '2003-06-08', 'usuario', '2026-09-03 10:07:00'),
  (4, 'Carla Martínez Ruiz', 'carla.martinez@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '612001308', 'Calle del Campus 7, 3º C', '2004-11-15', 'usuario', '2026-09-05 10:14:00'),
  (5, 'Pau Vidal Ferrer', 'pau.vidal@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', NULL, 'Calle Estudiantes 9, 4º D', '2005-04-22', 'usuario', '2026-09-07 10:21:00'),
  (6, 'Sofía López Navarro', 'sofia.lopez@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '614001382', 'Plaza Mayor 11, 5º A', '2006-09-01', 'usuario', '2026-09-09 10:28:00'),
  (7, 'Álex García Romero', 'alex.garcia@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '615001419', NULL, '2007-02-08', 'usuario', '2026-09-11 10:35:00'),
  (8, 'Marta Sánchez Vega', 'marta.sanchez@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '616001456', 'Calle Goya 15, 2º C', NULL, 'usuario', '2026-09-13 10:42:00'),
  (9, 'Jordi Roca Mas', 'jordi.roca@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '617001493', 'Avenida de Europa 17, 3º D', '2003-12-22', 'usuario', '2026-09-15 10:49:00'),
  (10, 'Laura Moreno Díaz', 'laura.moreno@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '618001530', 'Calle Libertad 19, 4º A', '2004-05-01', 'usuario', '2026-09-17 10:56:00'),
  (11, 'Hugo Ortega Castillo', 'hugo.ortega@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '619001567', 'Calle del Sol 21, 5º B', '2005-10-08', 'usuario', '2026-09-19 11:03:00'),
  (12, 'Paula Torres Molina', 'paula.torres@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', NULL, 'Calle Alcalá 23, 1º C', '2006-03-15', 'usuario', '2026-09-21 11:10:00'),
  (13, 'Daniel Ramos Serra', 'daniel.ramos@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '621001641', NULL, '2007-08-22', 'usuario', '2026-09-23 11:17:00'),
  (14, 'Nerea Iglesias Prat', 'nerea.iglesias@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '622001678', 'Calle Mayor 27, 3º A', '2002-01-01', 'usuario', '2026-09-25 11:24:00'),
  (15, 'Adrián Castro Núñez', 'adrian.castro@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '623001715', 'Avenida de la Universidad 29, 4º B', '2003-06-08', 'usuario', '2026-09-27 11:31:00'),
  (16, 'Claudia Herrera Bosch', 'claudia.herrera@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '624001752', 'Calle del Campus 31, 5º C', NULL, 'usuario', '2026-09-29 11:38:00'),
  (17, 'Sergio Medina León', 'sergio.medina@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '625001789', 'Calle Estudiantes 33, 1º D', '2005-04-22', 'usuario', '2026-10-01 11:45:00'),
  (18, 'Irene Campos Vila', 'irene.campos@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '626001826', 'Plaza Mayor 35, 2º A', '2006-09-01', 'usuario', '2026-10-03 11:52:00'),
  (19, 'Pol Navarro Sala', 'pol.navarro@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', NULL, NULL, '2007-02-08', 'usuario', '2026-10-05 11:59:00'),
  (20, 'Andrea Gil Marín', 'andrea.gil@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '628001900', 'Calle Goya 39, 4º C', '2002-07-15', 'usuario', '2026-10-07 12:06:00'),
  (21, 'Víctor Pascual Rey', 'victor.pascual@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '629001937', 'Avenida de Europa 41, 5º D', '2003-12-22', 'usuario', '2026-10-09 12:13:00'),
  (22, 'Júlia Ferrer Costa', 'julia.ferrer@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '630001974', 'Calle Libertad 43, 1º A', '2004-05-01', 'usuario', '2026-10-11 12:20:00'),
  (23, 'Raúl Delgado Pons', 'raul.delgado@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '631002011', 'Calle del Sol 45, 2º B', '2005-10-08', 'usuario', '2026-10-13 12:27:00'),
  (24, 'Alba Muñoz Rivas', 'alba.munoz@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '632002048', 'Calle Alcalá 47, 3º C', NULL, 'usuario', '2026-10-15 12:34:00'),
  (25, 'Ismael Benítez Cano', 'ismael.benitez@alumnos.test', '$2y$12$GcBfEFscl09vVVOMoyJc5upqmabfpyGoN.ntpb3hXYs/QprTVxqxa', '633002085', NULL, '2007-08-22', 'usuario', '2026-10-17 12:41:00');

-- ---------------------------------------------------------------------
-- 6. PEDIDOS de prueba (10)
-- ---------------------------------------------------------------------
INSERT INTO pedidos (id, usuario_id, estado, fecha_pedido, subtotal, descuento, total, metodo_pago, estado_pago) VALUES
  (1, 2, 'entregado', '2026-10-05 13:42:10', 16.20, 0.00, 16.20, 'simulado', 'pagado'),
  (2, 3, 'entregado', '2026-10-07 14:10:33', 33.10, 0.00, 33.10, 'simulado', 'pagado'),
  (3, 5, 'entregado', '2026-10-09 21:05:48', 27.10, 2.71, 24.39, 'simulado', 'pagado'), -- código UNI10 (-10%)
  (4, 7, 'entregado', '2026-10-12 13:30:21', 24.80, 0.00, 24.80, 'simulado', 'pagado'),
  (5, 9, 'entregado', '2026-10-14 20:15:02', 32.10, 0.00, 32.10, 'simulado', 'pagado'),
  (6, 11, 'enviado', '2026-10-16 19:40:55', 15.40, 2.90, 12.50, 'simulado', 'pagado'), -- Menú Estudiante
  (7, 12, 'preparando', '2026-10-18 14:20:17', 21.20, 3.18, 18.02, 'simulado', 'pagado'), -- código BIENVENIDA15 (-15%)
  (8, 15, 'confirmado', '2026-10-19 22:05:40', 41.60, 0.00, 41.60, 'simulado', 'pagado'),
  (9, 18, 'pendiente', '2026-10-21 13:15:09', 22.00, 0.60, 21.40, 'simulado', 'pendiente'), -- Dulce fin de curso (-15% postres)
  (10, 20, 'cancelado', '2026-10-22 20:50:31', 22.70, 0.00, 22.70, 'simulado', 'fallido'); -- pago fallido

INSERT INTO pedido_detalle (id, pedido_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal) VALUES
  (1, 1, 1, 'Classic Burger', 8.90, 1, 9.70), -- pedido 1: +Beicon crujiente
  (2, 1, 10, 'Patatas Classicas', 3.50, 1, 3.50), -- pedido 1
  (3, 1, 17, 'Coca-cola', 3.00, 1, 3.00), -- pedido 1: sin Hielo
  (4, 2, 2, 'Cheese Bacon', 10.50, 2, 22.60), -- pedido 2: +Queso cheddar, sin Salsa especial
  (5, 2, 11, 'Patatas Deluxe', 3.70, 1, 4.50), -- pedido 2: +Queso cheddar
  (6, 2, 20, 'Aquarius', 3.00, 2, 6.00), -- pedido 2
  (7, 3, 7, 'Double Burger', 12.50, 1, 14.10), -- pedido 3: +Huevo a la plancha, +Beicon crujiente
  (8, 3, 13, 'Aros de cebolla', 4.00, 1, 4.00), -- pedido 3
  (9, 3, 22, 'Cerveza', 3.00, 1, 3.00), -- pedido 3
  (10, 3, 25, 'Brownie con helado', 6.00, 1, 6.00), -- pedido 3
  (11, 4, 3, 'Veggie Burger', 9.50, 1, 10.30), -- pedido 4: +Queso cheddar, sin Tomate
  (12, 4, 15, 'Ensalada césar', 8.50, 1, 8.50), -- pedido 4: sin Picatostes
  (13, 4, 21, 'Zumo de naranja', 3.00, 2, 6.00), -- pedido 4
  (14, 5, 4, 'BBQ Burger', 10.90, 1, 10.90), -- pedido 5: sin Cebolla crujiente
  (15, 5, 6, 'Spicy Burger', 10.20, 1, 11.00), -- pedido 5: +Beicon crujiente
  (16, 5, 12, 'Patatas Bravas', 4.20, 1, 4.20), -- pedido 5
  (17, 5, 18, 'Coca-cola Zero', 3.00, 2, 6.00), -- pedido 5: sin Hielo
  (18, 6, 1, 'Classic Burger', 8.90, 1, 8.90), -- pedido 6
  (19, 6, 10, 'Patatas Classicas', 3.50, 1, 3.50), -- pedido 6
  (20, 6, 17, 'Coca-cola', 3.00, 1, 3.00), -- pedido 6
  (21, 7, 5, 'Crispy Chicken', 9.90, 1, 10.70), -- pedido 7: +Aguacate
  (22, 7, 14, 'Nuggets de pollo', 4.50, 1, 5.00), -- pedido 7: +Alioli
  (23, 7, 19, 'Fanta Naranja', 3.00, 1, 3.00), -- pedido 7: sin Hielo
  (24, 7, 29, 'Cookie con pepitas', 2.50, 1, 2.50), -- pedido 7
  (25, 8, 9, 'Campus Burger', 12.90, 2, 27.40), -- pedido 8: +Cebolla caramelizada, sin Lechuga
  (26, 8, 11, 'Patatas Deluxe', 3.70, 1, 3.70), -- pedido 8
  (27, 8, 24, 'Té helado de limón', 3.00, 2, 6.00), -- pedido 8: sin Hielo
  (28, 8, 28, 'Tarta de queso', 4.50, 1, 4.50), -- pedido 8
  (29, 9, 8, 'Mushroom Burger', 10.40, 1, 12.00), -- pedido 9: +Huevo a la plancha, +Beicon crujiente
  (30, 9, 10, 'Patatas Classicas', 3.50, 1, 4.00), -- pedido 9: +Alioli
  (31, 9, 16, 'Agua', 2.00, 1, 2.00), -- pedido 9
  (32, 9, 27, 'Natilla', 4.00, 1, 4.00), -- pedido 9
  (33, 10, 7, 'Double Burger', 12.50, 1, 12.50), -- pedido 10
  (34, 10, 22, 'Cerveza', 3.00, 2, 6.00), -- pedido 10
  (35, 10, 12, 'Patatas Bravas', 4.20, 1, 4.20); -- pedido 10

-- Ingredientes de cada línea: primero se copian como 'incluido' todos los
-- ingredientes base del producto (cantidad > 0)...
INSERT INTO pedido_detalle_ingrediente (pedido_detalle_id, ingrediente_id, nombre_ingrediente, precio_extra, accion)
SELECT d.id, i.id, i.nombre, 0, 'incluido'
FROM pedido_detalle d
JOIN producto_ingrediente pi ON pi.producto_id = d.producto_id AND pi.cantidad > 0
JOIN ingredientes i ON i.id = pi.ingrediente_id
ORDER BY d.id, i.id;

-- ...después se marcan como 'quitado' los que el cliente ha quitado...
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 3 AND ingrediente_id = 33; -- Coca-cola: sin Hielo
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 4 AND ingrediente_id = 6; -- Cheese Bacon: sin Salsa especial
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 11 AND ingrediente_id = 4; -- Veggie Burger: sin Tomate
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 12 AND ingrediente_id = 23; -- Ensalada césar: sin Picatostes
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 14 AND ingrediente_id = 32; -- BBQ Burger: sin Cebolla crujiente
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 17 AND ingrediente_id = 33; -- Coca-cola Zero: sin Hielo
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 23 AND ingrediente_id = 33; -- Fanta Naranja: sin Hielo
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 25 AND ingrediente_id = 3; -- Campus Burger: sin Lechuga
UPDATE pedido_detalle_ingrediente SET accion = 'quitado' WHERE pedido_detalle_id = 27 AND ingrediente_id = 33; -- Té helado de limón: sin Hielo

-- ...y por último se añaden los extras ('añadido') con su precio.
INSERT INTO pedido_detalle_ingrediente (pedido_detalle_id, ingrediente_id, nombre_ingrediente, precio_extra, accion) VALUES
  (1, 8, 'Beicon crujiente', 0.80, 'añadido'),  -- Classic Burger (pedido 1): +Beicon crujiente
  (4, 7, 'Queso cheddar', 0.80, 'añadido'),  -- Cheese Bacon (pedido 2): +Queso cheddar
  (5, 7, 'Queso cheddar', 0.80, 'añadido'),  -- Patatas Deluxe (pedido 2): +Queso cheddar
  (7, 9, 'Huevo a la plancha', 0.80, 'añadido'),  -- Double Burger (pedido 3): +Huevo a la plancha
  (7, 8, 'Beicon crujiente', 0.80, 'añadido'),  -- Double Burger (pedido 3): +Beicon crujiente
  (11, 7, 'Queso cheddar', 0.80, 'añadido'),  -- Veggie Burger (pedido 4): +Queso cheddar
  (15, 8, 'Beicon crujiente', 0.80, 'añadido'),  -- Spicy Burger (pedido 5): +Beicon crujiente
  (21, 10, 'Aguacate', 0.80, 'añadido'),  -- Crispy Chicken (pedido 7): +Aguacate
  (22, 29, 'Alioli', 0.50, 'añadido'),  -- Nuggets de pollo (pedido 7): +Alioli
  (25, 11, 'Cebolla caramelizada', 0.80, 'añadido'),  -- Campus Burger (pedido 8): +Cebolla caramelizada
  (29, 9, 'Huevo a la plancha', 0.80, 'añadido'),  -- Mushroom Burger (pedido 9): +Huevo a la plancha
  (29, 8, 'Beicon crujiente', 0.80, 'añadido'),  -- Mushroom Burger (pedido 9): +Beicon crujiente
  (30, 29, 'Alioli', 0.50, 'añadido');  -- Patatas Classicas (pedido 9): +Alioli
