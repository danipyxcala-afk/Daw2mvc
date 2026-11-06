<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sigmeat</title>
    <link rel="icon" type="image/png" href="<?= url ?>/assets/img/logo/favicon-32.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= url ?>/assets/css/main.css">
</head>

<body>
    <?php include_once __DIR__ . "/header.php"; ?>

    <main>
        <!-- Notificaciones cuando se actualiza algo en carrito -->
            <?php if (isset($_SESSION['aviso'])) { ?>
                <div class="container">
                    <div class="alert alert-info" role="status">
                        <?= htmlspecialchars($_SESSION['aviso'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                </div>
                <?php
                // El aviso se muestra una sola vez
                unset($_SESSION['aviso']);
            } ?>
            <?php include_once $view; ?>
    </main>

    <?php include_once __DIR__ . "/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= url ?>/assets/js/app.js" defer></script>
</body>

</html>

<!-- Home
Titulo modificar foto de fondo para bajar la opacidad Oscurecer

Cambiar todos los botones con boton con flechita
hacer que los botones menos padding
Alinear el boton de elige tu categoria a la derecha
Separar el construyendo el futuro y elige tu categoria
unicamente 1 boton en la portada y que sea el oscuro
el boton de listado es añadir el carrito 1 de añadir al carrito y otro de personalizar
y si haces click a al cuadrado si puedes personalizar el, es decir desde 2 sitios puedes personalizar boton y marco
revisar migas de pan falta en carrito y carta
si vas a carta dejar que el nav se quede seleccionado
en los ingredientes principales de la comida si cabe un 4 ponerlo en horizontal
invertir la cantidad y el total en el producto
separar separacion de productos del carrito y la papelera elimina el producto completo y que salga un aviso
Añadir la leyenda nombre / cantidad / precio

en mvl hacer los botones mas grandes que llegen mas de lado a lado -->