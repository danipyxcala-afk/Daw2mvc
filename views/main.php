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